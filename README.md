# AshaParth AI Multiservices: Website

Company website for **AshaParth AI Multiservices**, Vivekanand Tower, Amalner, Jalgaon, Maharashtra 425401.

Built with **plain PHP + MySQL**, with no framework and no Composer. It runs on standard cPanel shared hosting (AquaHost).

---

## Pages

| URL | Page |
|---|---|
| `/` | Home |
| `/about` | About Us, with the three founders |
| `/services` | Services overview |
| `/services/{slug}` | 9 service pages: website-development, resume-website, mobile-app-development, ai-automation, custom-software, seo, social-media-marketing, paid-ads, graphic-design-branding |
| `/resume-website-demo` | Sample resume website with a fictional person (hidden from Google) |
| `/temple-solutions` | Temple digital solutions (the temple vertical) |
| `/live-darshan-service` | Temple live darshan landing page, with a short Marathi section |
| `/devasthan-live` | Maharashtra Devasthan Live, with the **Register Your Temple** form |
| `/portfolio`, `/portfolio/{slug}` | Portfolio and case studies |
| `/blog`, `/blog/{slug}` | Blog |
| `/careers` | General application form with resume upload |
| `/contact` | Contact form and Google Map |
| `/get-a-quote` | Detailed quote form (budget in INR or USD, optional attachment) |
| `/privacy-policy`, `/terms-and-conditions` | Legal pages |
| `/thank-you` | Shown after any form is sent |
| `/sitemap.xml`, `/robots.txt` | Generated automatically |

## Forms

There are four forms: Contact, Get a Quote, Careers and Temple Registration. Every submission is:

1. **Checked for spam**: CSRF token, an invisible honeypot field, a minimum fill time, and a limit of 5 submissions per IP per 30 minutes.
2. **Validated** on the server. Uploads are checked by extension *and* real file type, with a 5 MB maximum.
3. **Saved** to MySQL. You can view the tables in phpMyAdmin.
4. **Emailed** to `ashishchaudhari05@gmail.com`, with any attachment included. Replying to that email goes straight to the customer.
5. **Auto-replied**: the customer gets a "we received it" email with a WhatsApp button.

If the database or email fails, the other one still records the submission. Failures are written to `storage/logs/`.

Uploaded files are stored in `storage/uploads/`, which cannot be opened from the web.

---

## Folder structure

```
index.php                 Front controller / router (all URLs)
.htaccess                 Clean URLs, blocks app/ storage/ database/
app/
  config.php              ← business details, phone, social links, stats (EDIT THIS)
  config.local.php        ← database + email passwords (create from the example; git-ignored)
  data/
    services.php          ← 9 service pages content
    portfolio.php         ← case studies
    blog.php              ← blog posts
    testimonials.php      ← client reviews (currently samples)
  views/pages/*.php       Page templates
  views/layout/           Header (menu, SEO tags) and footer
  views/partials/         Reusable blocks (hero, CTA, cards, FAQ)
  forms.php               Form options, validation, spam protection, handlers
  mailer.php              Email sending + email templates
  lib/PHPMailer/          PHPMailer 7.1.1 (bundled, LGPL)
assets/css/style.css      All styles (brand colours at the top)
assets/js/main.js         Menu, animations, portfolio filter, form helpers
assets/img/               Logo, temple mark, favicon, social share image
database/schema.sql       MySQL tables
storage/uploads/          Uploaded resumes & attachments (private)
storage/logs/             Error, mail and spam logs (private)
```

---

## Run locally (XAMPP)

1. Start **MySQL** from the XAMPP Control Panel.
2. Create the database and tables:
   ```
   C:\xampp\mysql\bin\mysql -u root -e "CREATE DATABASE ashaparth_site CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci"
   C:\xampp\mysql\bin\mysql -u root ashaparth_site < database\schema.sql
   ```
3. Copy `app/config.local.example.php` to `app/config.local.php`. For local testing, set:
   `'env' => 'development'`, the DB user `root` with an empty password, and `'mail' => ['driver' => 'log']`.
   Emails are then written to `storage/logs/mail.log` instead of being sent.
4. Start the site:
   ```
   C:\xampp\php\php.exe -S localhost:8000 index.php
   ```
   Open http://localhost:8000

The site also works inside a sub-folder, e.g. `C:\xampp\htdocs\ashaparth\` at http://localhost/ashaparth/.

---

## Deploy to AquaHost (cPanel)

1. **PHP version**: in cPanel > *Select PHP Version* (or *MultiPHP Manager*), choose **PHP 8.1 or newer** (tested on PHP 8.2). Make sure the `pdo_mysql`, `mbstring`, `fileinfo` and `openssl` extensions are enabled.
2. **Upload files**: on your computer run `C:
mpp\php\php.exe tools\package-deploy.php`. In cPanel > *File Manager*, open `public_html/`, upload `ashaparth-upload.zip`, right-click it, choose *Extract*, then delete the zip. To update the site later, do the same; your server settings are not touched.
3. **Database**: in cPanel > *MySQL Databases*:
   - Create a database (e.g. `cpuser_ashaparth`) and a user with a strong password.
   - Add the user to the database with **All Privileges**.
   - Open **phpMyAdmin**, select the database, go to **Import**, and upload `database/schema.sql`.
4. **Config**: in File Manager, copy `app/config.local.example.php` to `app/config.local.php` and fill in:
   - The `db` name, user and password from step 3.
   - The `mail` settings. **Option A, Gmail (simplest):** turn on 2-Step Verification on the Google account, create an *App Password* at https://myaccount.google.com/apppasswords and paste it as `password`. Use host `smtp.gmail.com`, port `587`, encryption `tls`. **Option B, domain email:** create a mailbox like `info@yourdomain.com` in cPanel > *Email Accounts*, then use host `mail.yourdomain.com`, port `465`, encryption `ssl`.
5. **Permissions**: `storage/uploads/` and `storage/logs/` must be writable (755 normally works on cPanel).
6. **SSL**: enable free SSL in cPanel > *SSL/TLS Status* (AutoSSL) and check that `https://` opens your site.
7. **Domain**: only after SSL works, set `'site_url' => 'https://www.yourdomain.com'` in `app/config.php`. All visitors are then redirected to that exact address (https, and www or non-www as you chose), so Google sees one version of each page. You do not need the commented HTTPS lines in `.htaccess`.
8. **Test**: submit each form once and check that the emails arrive and that the rows appear in phpMyAdmin.
9. **Google**: add the site to Google Search Console and submit `https://yourdomain.com/sitemap.xml`. Create or claim your Google Business Profile, use the same business name, address and phone as the website, and link it to the site.

---

## Automatic deployment (CI/CD)

Every push to `main` runs `.github/workflows/deploy.yml`, which:

1. Tests the site on PHP 8.5, the same version as the host: syntax, every page, every link, and any PHP errors.
2. Stops if anything fails, so a broken version is never uploaded.
3. Uploads only the files that changed, over encrypted FTP.
4. Checks the live site: the new version is really there, main pages load, private folders are blocked, and old addresses redirect.

You can also start it from the **Actions** tab on GitHub with **Run workflow**.

**One-time setup**

1. In cPanel > *FTP Accounts*, create an account (e.g. `deploy@ashaparth.com`) with a strong password. Set its directory to `public_html` only, so it cannot reach anything else.
2. In GitHub, open the repo's *Settings > Secrets and variables > Actions* and add three repository secrets:
   - `FTP_SERVER`: e.g. `ftp.ashaparth.com`
   - `FTP_USERNAME`: the full FTP username
   - `FTP_PASSWORD`: its password

**What deploys never touch**

`app/config.local.php`, `storage/logs`, `storage/uploads`, `.user.ini`, `php.ini`, `.well-known` and `cgi-bin`. These stay on the server only. Keep passwords in `config.local.php` and nowhere else.

**Rules to follow**

- Change site files in git, not in cPanel. The next deploy of a changed file overwrites any edit made on the server.
- Never add `dangerous-clean-slate` to the workflow. It erases the whole server folder, including `config.local.php` and uploaded resumes.
- To undo a bad release, run `git revert <commit>` and push. That deploys the previous version.

## Editing content

| To change… | Edit |
|---|---|
| Phone, email, address, hours, tagline, social links, stats, founders, technologies | `app/config.php` |
| Service page text, features, FAQs | `app/data/services.php` |
| Portfolio / case studies | `app/data/portfolio.php` (add screenshots to `assets/img/portfolio/`) |
| Blog posts | `app/data/blog.php` (copy an entry and change the key, which becomes the URL) |
| Testimonials | `app/data/testimonials.php` |
| Form dropdown options (budgets, positions, districts…) | `app/forms.php` (top section) |
| Colours and fonts | `assets/css/style.css` (variables at the top) |

---

## Placeholders to replace before launch

- [ ] **Social media URLs**: add real links in `app/config.php` > `social`. Icons stay hidden until a link is set.
- [ ] **Stats**: `app/config.php` > `stats` shows facts we can back up. Add client and project totals once you have real counts.
- [ ] **Founder photos and bios**: `app/config.php` > `founders`. Put photos in `assets/img/team/`.
- [ ] **Testimonials**: this section is hidden. Add genuine client reviews (with permission) to `app/data/testimonials.php`, then set `show_testimonials` to `true`.
- [ ] **More portfolio projects**: add real projects to `app/data/portfolio.php` as you complete them.
- [ ] **Portfolio screenshots**: save a screenshot of mangalagrahmandir.in as `assets/img/portfolio/mangal-grah-mandir-website.jpg`. An illustrated cover is shown until then. For the other projects, set `'image' => 'img/portfolio/your-file.jpg'`.
- [ ] **Technologies list**: `app/config.php` > `technologies`. Check that it matches the tools you actually use.
- [ ] **About Us story**: review the text in `app/views/pages/about.php`.
- [ ] **GST number** (optional): `app/config.php` > `gst_number`.
- [ ] **Blog dates**: set each post's `date` in `app/data/blog.php` to the day it really goes live.
- [ ] **Marathi text**: have a Marathi speaker check the section on `/live-darshan-service`.
- [ ] **Local wording**: check the "in Jalgaon and Amalner" paragraph (`local`) on each service in `app/data/services.php`.
- [ ] **Privacy Policy and Terms**: these are general templates. Have them reviewed for your business.

## Review copy on GitHub Pages

GitHub Pages cannot run PHP, so reviews use a static copy built by `tools/build-static.php`. It publishes only HTML and `/assets`, never the PHP source or any config. Every page gets a "review copy" banner and a noindex tag, and form submit buttons are switched off.

To publish an update after making changes:

```
C:
mpp\php\php.exe tools\build-static.php
```

Then push the contents of `dist/` to the `gh-pages` branch. GitHub serves that branch at https://varunschaudhari.github.io/ashaparth-ai-multiservices/. `tools/` and `dist/` are not needed on AquaHost, so skip them when uploading.

## Viewing submissions

Open phpMyAdmin and browse these tables: `contact_enquiries`, `quote_requests`, `career_applications` and `temple_registrations`. Each table has a `status` column you can update by hand, e.g. `new` → `contacted`. Uploaded files are listed in `attachment_path` / `resume_path`. Download them from cPanel File Manager; they are also attached to the notification emails.
