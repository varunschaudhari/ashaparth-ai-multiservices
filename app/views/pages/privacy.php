<?php
defined('APP_ROOT') || exit;
$name = e(config('legal_name'));
partial('page-hero', [
    'title'  => 'Privacy Policy',
    'text'   => 'How we collect, use and protect the information you share with us through this website.',
    'crumbs' => [['Privacy Policy', 'privacy-policy']],
    'icon'   => 'shield-lock',
]);
?>
<section class="section">
  <div class="container container-narrow">
    <span class="legal-updated"><?= icon('calendar3') ?> Last updated: 3 November 2026</span>
    <div class="prose">
      <p>This Privacy Policy explains how <strong><?= $name ?></strong> (“we”, “us”, “our”), a <?= e(strtolower(config('legal_type'))) ?> firm based at <?= e(full_address(true)) ?>, handles personal information collected through this website. By using this website or submitting a form, you agree to the practices described here.</p>

      <h2>1. Information we collect</h2>
      <p>We collect only the information you choose to give us when you use our forms:</p>
      <ul>
        <li><strong>Contact &amp; quote forms:</strong> name, email, phone/WhatsApp number, company, country or city, the services you are interested in, budget, timeline, project details and any file you attach.</li>
        <li><strong>Career applications:</strong> name, contact details, city, position, experience, portfolio links, a short note and your resume.</li>
        <li><strong>Temple registrations:</strong> temple name and location, contact person’s name, designation, phone, email and the services requested.</li>
      </ul>
      <p>For security and spam prevention, we also record the IP address, browser type and time of each submission.</p>

      <h2>2. How we use your information</h2>
      <ul>
        <li>To respond to your enquiry, prepare quotes and deliver the services you request</li>
        <li>To evaluate job applications and contact candidates</li>
        <li>To contact temple trusts about Maharashtra Devasthan Live and our temple services</li>
        <li>To send you a confirmation email when you submit a form</li>
        <li>To protect the website from spam and misuse</li>
      </ul>
      <p>We do not sell, rent or trade your personal information. We do not send marketing messages unless you have asked us to.</p>

      <h2>3. Cookies</h2>
      <p>This website uses a single essential session cookie to keep forms secure (protection against cross-site request forgery). We do not use advertising or tracking cookies. If analytics are added in future, this policy will be updated.</p>

      <h2>4. Third-party services</h2>
      <p>Some features on this website are provided by third parties, which may receive technical information such as your IP address when the page loads:</p>
      <ul>
        <li><strong>Google Maps</strong> (embedded map on the Contact page)</li>
        <li><strong>Google Fonts</strong> and <strong>jsDelivr</strong> (fonts and icons)</li>
        <li><strong>WhatsApp</strong> (when you click a WhatsApp chat button)</li>
        <li>Our email and hosting providers, which process form submissions on our behalf</li>
      </ul>
      <p>These services are governed by their own privacy policies.</p>

      <h2>5. Data storage and security</h2>
      <p>Form submissions are stored in a secured database and delivered to our business email. Uploaded files are stored in a protected folder that is not publicly accessible. We use reasonable technical and organisational measures to protect your information, but no method of transmission over the internet is completely secure.</p>

      <h2>6. Data retention</h2>
      <p>We keep enquiries and quotes for as long as needed to respond and maintain our business records. Resumes are kept for up to 12 months for future opportunities unless you ask us to delete them sooner.</p>

      <h2>7. Your rights</h2>
      <p>In line with applicable Indian law, including the Digital Personal Data Protection Act, 2023, you may ask us to access, correct or delete the personal information you have shared, or withdraw your consent. To make a request, contact us using the details below.</p>

      <h2>8. Children’s privacy</h2>
      <p>This website is intended for businesses, institutions and adults. We do not knowingly collect information from children under 18.</p>

      <h2>9. Changes to this policy</h2>
      <p>We may update this policy from time to time. The “Last updated” date above shows when it was last changed.</p>

      <h2>10. Contact us</h2>
      <p><strong><?= $name ?></strong><br>
        <?= e(full_address(true)) ?><br>
        Phone: <a href="<?= e(tel_url()) ?>"><?= e(config('phone')) ?></a><br>
        Email: <a href="<?= e(mailto_url()) ?>"><?= e(config('email')) ?></a></p>
    </div>
  </div>
</section>
