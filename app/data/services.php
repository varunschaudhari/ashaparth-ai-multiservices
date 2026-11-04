<?php
/**
 * Service pages content. Each key is the URL slug: /services/{slug}
 *
 * category: 'build' (technology) or 'grow' (marketing & creative)
 * Icons are Bootstrap Icons names: https://icons.getbootstrap.com
 */

defined('APP_ROOT') || exit;

return [

    // ─────────────────────────────────────────────────────────────────────
    'website-development' => [
        'title'    => 'Website Development',
        'category' => 'build',
        'icon'     => 'window-stack',
        'short'    => 'Fast, mobile-friendly business websites, e-commerce stores and web applications that turn visitors into customers.',
        'seo_title'        => 'Website Development Company in Jalgaon, Maharashtra',
        'meta_description' => 'Professional website development: business websites, e-commerce, WordPress, landing pages and custom web apps. Fast, mobile-first and SEO-ready.',
        'headline' => 'Websites that work as hard as you do',
        'intro'    => 'Your website is often the first impression a customer has of your business. We design and develop fast, secure, mobile-first websites that clearly explain what you do, build trust and make it easy for visitors to call, message or buy.',
        'offerings' => [
            'Business & corporate websites',
            'E-commerce & online stores',
            'WordPress websites',
            'Landing pages for campaigns',
            'Custom web applications & portals',
            'Website redesign & speed optimisation',
        ],
        'features' => [
            ['phone', 'Mobile-first design', 'Most of your visitors use phones. Every page we build looks and works great on any screen size.'],
            ['speedometer2', 'Fast loading', 'Optimised images, clean code and caching so pages load quickly, even on slower mobile networks.'],
            ['search', 'SEO-ready structure', 'Proper headings, meta tags, sitemaps and schema markup so search engines understand your site.'],
            ['shield-check', 'Secure by default', 'SSL setup, spam-protected forms, regular updates and backups to keep your site safe.'],
            ['pencil-square', 'Easy to update', 'Need to change prices or add photos? We set up a simple way for you to manage content.'],
            ['whatsapp', 'Lead-focused', 'Click-to-call, WhatsApp chat and enquiry forms placed where customers actually use them.'],
        ],
        'process' => [
            ['Discovery', 'We understand your business, customers, competitors and goals.'],
            ['Design', 'Wireframes and a visual design that match your brand, shared for your feedback.'],
            ['Development', 'We build, connect forms and payments, add content and test on all devices.'],
            ['Launch & support', 'Domain, hosting and go-live, followed by training and ongoing maintenance.'],
        ],
        'tools' => ['PHP', 'Laravel', 'WordPress', 'WooCommerce', 'React', 'HTML5 / CSS3', 'MySQL', 'Razorpay'],
        'faqs' => [
            ['How long does it take to build a website?', 'A standard business website usually takes 2–4 weeks from the time we receive your content. E-commerce stores and custom web apps take longer depending on features.'],
            ['Will my website work on mobile phones?', 'Yes. Every website we build is fully responsive and tested on mobiles, tablets and desktops.'],
            ['Do you provide domain and hosting?', 'Yes. We can register your domain, set up hosting and business email, or work with your existing provider.'],
            ['Can I update the website myself?', 'Yes. Depending on the project we provide a simple admin panel or WordPress dashboard, and we train you to use it.'],
        ],
    ],

    // ─────────────────────────────────────────────────────────────────────
    'mobile-app-development' => [
        'title'    => 'Mobile App Development',
        'category' => 'build',
        'icon'     => 'phone',
        'short'    => 'Android, iOS and cross-platform apps with clean design, smooth performance and secure back-ends.',
        'seo_title'        => 'Mobile App Development: Android, iOS & Cross-Platform',
        'meta_description' => 'Android, iOS and cross-platform mobile app development: business apps, booking apps, e-commerce apps, temple apps and progressive web apps (PWA).',
        'headline' => 'Put your business in your customers’ pockets',
        'intro'    => 'A well-built mobile app keeps your customers connected to you every day. We plan, design and develop apps for Android and iOS, from simple booking apps to complete business platforms, with the admin panel and back-end needed to run them.',
        'offerings' => [
            'Android apps',
            'iOS apps',
            'Cross-platform apps (Flutter / React Native)',
            'Progressive web apps (PWA)',
            'Booking & appointment apps',
            'E-commerce & delivery apps',
        ],
        'features' => [
            ['layout-text-window', 'Intuitive UI/UX', 'Simple, familiar screens designed around how your users actually think and tap.'],
            ['bell', 'Push notifications', 'Send offers, reminders and updates directly to your users’ phones.'],
            ['credit-card', 'Payments built in', 'UPI, cards and wallets through trusted gateways like Razorpay.'],
            ['translate', 'Multi-language', 'English, Marathi, Hindi and more, so every user is comfortable.'],
            ['cloud-check', 'Secure back-end', 'Robust APIs, admin dashboards and cloud databases that scale with you.'],
            ['shop', 'Store publishing', 'We handle Google Play and App Store listing, review and release.'],
        ],
        'process' => [
            ['Idea & scope', 'We define features, users and the minimum version needed to launch.'],
            ['UI/UX design', 'Clickable prototypes so you can see and feel the app before development.'],
            ['Build & test', 'Agile development with regular builds you can try on your own phone.'],
            ['Publish & grow', 'Store launch, analytics, updates and new features based on real usage.'],
        ],
        'tools' => ['Flutter', 'React Native', 'Kotlin', 'Swift', 'Firebase', 'Node.js', 'Laravel API', 'PWA'],
        'faqs' => [
            ['Android, iOS or both?', 'For most businesses we recommend a cross-platform app (one codebase for both). If you need only Android to start, that keeps the budget lower.'],
            ['How much does an app cost?', 'It depends on features, screens and integrations. Share your idea through our quote form and we will send a clear estimate.'],
            ['Will I own the app and source code?', 'Yes. After final payment, you own the app, the store listings and the source code.'],
            ['Do you maintain the app after launch?', 'Yes. We offer maintenance plans covering bug fixes, OS updates, server monitoring and new features.'],
        ],
    ],

    // ─────────────────────────────────────────────────────────────────────
    'ai-automation' => [
        'title'    => 'AI & Automation',
        'category' => 'build',
        'icon'     => 'robot',
        'short'    => 'AI chatbots, WhatsApp automation and smart workflows that save hours of manual work every week.',
        'seo_title'        => 'AI Chatbots, WhatsApp Automation & Business Process Automation',
        'meta_description' => 'Practical AI for small and growing businesses: AI chatbots, WhatsApp automation, AI content tools, document processing and workflow automation.',
        'headline' => 'Practical AI that saves you time and money',
        'intro'    => 'AI is no longer only for big companies. We help businesses use AI in practical ways: answering customer questions 24x7, automating repetitive tasks, generating reports and connecting the tools you already use, so your team can focus on work that matters.',
        'offerings' => [
            'AI chatbots for website & WhatsApp',
            'WhatsApp Business API automation',
            'Workflow & process automation',
            'AI content & image generation tools',
            'Document reading & data extraction',
            'Custom AI integrations (LLMs)',
        ],
        'features' => [
            ['chat-dots', '24x7 customer replies', 'An AI assistant trained on your business answers common questions instantly, day or night.'],
            ['whatsapp', 'WhatsApp automation', 'Automatic confirmations, reminders, thank-you messages and lead follow-ups on WhatsApp.'],
            ['diagram-3', 'Connected workflows', 'Forms, spreadsheets, CRM, email and WhatsApp working together without copy-paste.'],
            ['file-earmark-text', 'Smart documents', 'Extract data from invoices, forms and PDFs automatically into your systems.'],
            ['bar-chart', 'Automatic reports', 'Daily or weekly summaries of sales, leads and operations delivered to your inbox.'],
            ['shield-lock', 'Privacy-aware', 'We design AI solutions that keep your business and customer data under control.'],
        ],
        'process' => [
            ['Find the bottlenecks', 'We map where your team spends time on repetitive or manual tasks.'],
            ['Design the solution', 'We choose the right AI and automation tools for your budget and goals.'],
            ['Build & train', 'We build, connect and train the system on your real business information.'],
            ['Measure & improve', 'We monitor results and keep refining for better accuracy and savings.'],
        ],
        'tools' => ['OpenAI / GPT', 'Claude', 'Python', 'WhatsApp Business API', 'n8n', 'Zapier', 'Google Workspace', 'Node.js'],
        'faqs' => [
            ['Is AI useful for a small business?', 'Yes. Even simple automations, like instant WhatsApp replies or automatic follow-ups, can save several hours every week and help you respond to customers faster.'],
            ['Will the chatbot give wrong answers?', 'We train chatbots on your approved information, set clear limits on what they answer, and hand over to a human when needed.'],
            ['Can AI work in Marathi or Hindi?', 'Yes. Modern AI models understand and respond in many Indian languages including Marathi and Hindi.'],
            ['What does it cost to run?', 'Running costs depend on usage. We explain expected monthly costs upfront and choose options that fit your budget.'],
        ],
    ],

    // ─────────────────────────────────────────────────────────────────────
    'custom-software' => [
        'title'    => 'Custom Software',
        'category' => 'build',
        'icon'     => 'boxes',
        'short'    => 'ERP, CRM, billing, inventory and management systems built around the way your organisation works.',
        'seo_title'        => 'Custom Software Development: ERP, CRM, Billing & Inventory',
        'meta_description' => 'Custom software development: ERP, CRM, billing, inventory and stock management, school, hospital and temple management systems with role-based access and reports.',
        'headline' => 'Software built around your business, not the other way round',
        'intro'    => 'Off-the-shelf software rarely fits perfectly. We build custom management systems that match your exact workflow, from stock and billing to bookings, staff and reports, so your team works faster with fewer errors.',
        'offerings' => [
            'ERP & business management systems',
            'CRM & lead management',
            'Billing, invoicing & GST',
            'Inventory & stock management',
            'School, clinic & hospital management',
            'Temple & trust management systems',
        ],
        'features' => [
            ['people', 'Role-based access', 'Owners, managers and staff each see only what they need, with full activity history.'],
            ['clipboard-data', 'Real-time dashboards', 'See sales, stock, bookings and payments at a glance, from any device.'],
            ['file-earmark-spreadsheet', 'Reports & exports', 'Detailed reports with Excel and PDF export for accounts and audits.'],
            ['phone', 'Works on mobile', 'Responsive and installable (PWA), so your team can use it on phones in the field.'],
            ['plug', 'Integrations', 'Connect with payment gateways, WhatsApp, SMS, email, Tally and other tools.'],
            ['cloud-arrow-up', 'Cloud & backups', 'Secure cloud hosting with automatic backups so your data is never lost.'],
        ],
        'process' => [
            ['Requirement study', 'We sit with your team to understand every step of the current process.'],
            ['Solution design', 'Modules, screens and data flow documented and approved by you.'],
            ['Phased delivery', 'Core modules first, so you start benefiting early, then the rest.'],
            ['Training & support', 'Hands-on staff training, data migration and ongoing support.'],
        ],
        'tools' => ['PHP / Laravel', 'React', 'Node.js', 'MySQL', 'PostgreSQL', 'PWA', 'REST APIs', 'Cloud hosting'],
        'faqs' => [
            ['Why custom software instead of a ready-made tool?', 'Custom software fits your exact workflow, has no per-user licence fees in many cases, and can grow with your business without forcing you to change how you work.'],
            ['Can you move our existing data?', 'Yes. We can import data from Excel sheets or your old software during setup.'],
            ['Will it work without internet?', 'We can build offline-capable features for situations where connectivity is unreliable, syncing when the connection returns.'],
            ['Do you provide training?', 'Yes. Every project includes training for your staff and simple user guides.'],
        ],
    ],

    // ─────────────────────────────────────────────────────────────────────
    'seo' => [
        'title'    => 'SEO',
        'category' => 'grow',
        'icon'     => 'graph-up-arrow',
        'short'    => 'Rank higher on Google and Google Maps with technical SEO, local SEO and content that attracts real customers.',
        'seo_title'        => 'SEO Services: Local SEO, Google Business Profile & Technical SEO',
        'meta_description' => 'SEO services that bring real customers: local SEO, Google Business Profile optimisation, technical SEO, keyword research, content and monthly reporting.',
        'headline' => 'Be found when customers are searching',
        'intro'    => 'When someone searches for what you offer, you want to be at the top. Our SEO services improve your visibility on Google Search and Google Maps through technical fixes, useful content and local optimisation, bringing steady, free traffic over time.',
        'offerings' => [
            'Local SEO & Google Maps ranking',
            'Google Business Profile setup & optimisation',
            'Technical SEO audit & fixes',
            'Keyword research & content strategy',
            'On-page SEO',
            'Monthly ranking & traffic reports',
        ],
        'features' => [
            ['geo-alt', 'Local visibility', 'Appear in the Google Maps “near me” results that drive calls and walk-ins.'],
            ['tools', 'Technical health', 'Speed, mobile usability, indexing and structured data issues fixed properly.'],
            ['key', 'Right keywords', 'We target the searches your customers actually type, not vanity terms.'],
            ['journal-text', 'Helpful content', 'Blog posts and service pages that answer customer questions and earn trust.'],
            ['star', 'Reviews strategy', 'A simple system to collect and respond to genuine Google reviews.'],
            ['bar-chart-line', 'Transparent reporting', 'Clear monthly reports on rankings, traffic, calls and enquiries.'],
        ],
        'process' => [
            ['Audit', 'A full review of your website, competitors and current rankings.'],
            ['Strategy', 'Target keywords, pages to create and fixes to prioritise.'],
            ['Optimise', 'On-page, technical and local improvements, plus new content.'],
            ['Report & refine', 'Monthly reporting and continuous improvement based on data.'],
        ],
        'tools' => ['Google Search Console', 'Google Analytics 4', 'Google Business Profile', 'Ahrefs / Semrush', 'Screaming Frog', 'PageSpeed Insights'],
        'faqs' => [
            ['How long does SEO take to show results?', 'Local SEO improvements can show within a few weeks. Competitive keywords usually take 3–6 months of consistent work.'],
            ['Do you guarantee the #1 position on Google?', 'No honest agency can guarantee a specific ranking because Google controls the results. We focus on proven practices and show measurable progress every month.'],
            ['Do I need a new website for SEO?', 'Not always. We first audit your current site; often fixing and improving it is enough.'],
            ['What is Google Business Profile?', 'It is your free business listing on Google Search and Maps. A well-optimised profile is one of the biggest sources of local calls and visits.'],
        ],
    ],

    // ─────────────────────────────────────────────────────────────────────
    'social-media-marketing' => [
        'title'    => 'Social Media Marketing',
        'category' => 'grow',
        'icon'     => 'megaphone',
        'short'    => 'Consistent, creative content and community management on Instagram, Facebook, YouTube and LinkedIn.',
        'seo_title'        => 'Social Media Marketing & Management Services',
        'meta_description' => 'Social media management for Instagram, Facebook, YouTube and LinkedIn: content calendars, reels, posters, captions, community management and monthly insights.',
        'headline' => 'Show up every day where your audience spends time',
        'intro'    => 'Social media is where your customers discover, compare and talk about brands. We plan, create and manage content that builds your brand, grows an engaged following and drives enquiries, while you focus on running your business.',
        'offerings' => [
            'Instagram & Facebook management',
            'YouTube channel management',
            'LinkedIn for businesses & founders',
            'Reels & short video editing',
            'Festival & event campaigns',
            'Influencer collaborations',
        ],
        'features' => [
            ['calendar3', 'Monthly content calendar', 'A planned mix of posts, reels and stories approved by you in advance.'],
            ['camera-reels', 'Reels & videos', 'Short, engaging videos edited for maximum reach on Instagram and YouTube.'],
            ['palette', 'On-brand creatives', 'Posters and carousels in your brand colours, fonts and tone.'],
            ['chat-heart', 'Community management', 'Timely replies to comments and messages so no enquiry is missed.'],
            ['hash', 'Hashtags & trends', 'Research-backed hashtags and trending formats to grow organic reach.'],
            ['graph-up', 'Monthly insights', 'Reports on reach, engagement, followers and leads, with next steps.'],
        ],
        'process' => [
            ['Brand study', 'Your audience, competitors, tone of voice and goals.'],
            ['Content plan', 'Themes, formats and a monthly calendar for approval.'],
            ['Create & publish', 'Design, edit, caption and post at the best times.'],
            ['Engage & analyse', 'Community replies, monthly report and improvements.'],
        ],
        'tools' => ['Meta Business Suite', 'Instagram', 'YouTube Studio', 'LinkedIn', 'Canva', 'Adobe Premiere / CapCut', 'Buffer'],
        'faqs' => [
            ['How many posts will you publish per month?', 'It depends on your plan. Typical plans range from 12 to 30 posts and reels per month across your chosen platforms.'],
            ['Do I need to provide photos and videos?', 'Your real photos and videos work best and we guide you on what to shoot. We also create graphics and can arrange shoots when needed.'],
            ['Will I approve content before it is posted?', 'Yes. We share the content calendar and creatives in advance for your approval.'],
            ['Is paid promotion included?', 'Social media management covers organic content. Paid ads are a separate service, though the two work best together.'],
        ],
    ],

    // ─────────────────────────────────────────────────────────────────────
    'paid-ads' => [
        'title'    => 'Paid Ads (Google & Meta)',
        'category' => 'grow',
        'icon'     => 'bullseye',
        'short'    => 'Targeted Google Ads and Meta (Facebook & Instagram) campaigns that bring leads and sales from day one.',
        'seo_title'        => 'Google Ads & Meta Ads Management (Facebook & Instagram)',
        'meta_description' => 'Performance-focused Google Ads and Meta Ads management: search, display, YouTube, Facebook and Instagram campaigns, lead generation and conversion tracking.',
        'headline' => 'Reach the right customers at the right moment',
        'intro'    => 'Paid advertising puts your business in front of people who are ready to buy, today. We set up, manage and optimise Google and Meta campaigns with clear targeting, compelling creatives and proper tracking, so every rupee you spend is accountable.',
        'offerings' => [
            'Google Search Ads',
            'Google Display & YouTube Ads',
            'Facebook & Instagram Ads',
            'Lead generation campaigns',
            'Remarketing campaigns',
            'Landing page optimisation',
        ],
        'features' => [
            ['crosshair', 'Precise targeting', 'Reach people by location, interests, search intent and behaviour.'],
            ['funnel', 'Lead generation', 'Campaigns designed to bring calls, WhatsApp chats and form enquiries.'],
            ['images', 'Ad creatives', 'Scroll-stopping images, videos and ad copy written for conversions.'],
            ['activity', 'Conversion tracking', 'Pixel and analytics setup so we know exactly which ads bring results.'],
            ['arrow-repeat', 'Constant optimisation', 'Weekly tuning of bids, audiences and creatives to lower your cost per lead.'],
            ['currency-rupee', 'Budget control', 'You decide the ad budget; we make it work harder with full transparency.'],
        ],
        'process' => [
            ['Goal & audience', 'Define what success looks like and who we are targeting.'],
            ['Campaign setup', 'Accounts, tracking, audiences, creatives and landing pages.'],
            ['Launch & test', 'Run multiple ad variations to find what performs best.'],
            ['Optimise & scale', 'Cut what does not work and scale what does, reported weekly.'],
        ],
        'tools' => ['Google Ads', 'Meta Ads Manager', 'Google Tag Manager', 'GA4', 'Meta Pixel', 'Looker Studio'],
        'faqs' => [
            ['What budget do I need for ads?', 'You can start small and scale based on results. We recommend a budget based on your goals and competition, and the ad spend is paid directly to Google or Meta.'],
            ['How soon will I get leads?', 'Paid campaigns can start generating enquiries within days of launch, and performance improves as we optimise.'],
            ['Is the ad budget included in your fee?', 'No. Our management fee is separate from the ad budget, which you pay directly to the platform for full transparency.'],
            ['Which is better, Google or Meta ads?', 'Google is great when people are actively searching for your service; Meta is great for awareness and offers. Most businesses benefit from a mix.'],
        ],
    ],

    // ─────────────────────────────────────────────────────────────────────
    'graphic-design-branding' => [
        'title'    => 'Graphic Design & Branding',
        'category' => 'grow',
        'icon'     => 'palette',
        'short'    => 'Logos, brand identity, UI/UX, social creatives and print designs that make your brand memorable.',
        'seo_title'        => 'Logo Design, Branding & Graphic Design Services',
        'meta_description' => 'Graphic design and branding: logo design, brand identity, visiting cards, brochures, posters, social media creatives, packaging and UI/UX design.',
        'headline' => 'Look as professional as the work you do',
        'intro'    => 'Strong design makes people trust you before they have even spoken to you. From a new logo to a complete brand identity, social creatives and print material, we create designs that are consistent, memorable and true to your brand.',
        'offerings' => [
            'Logo design & brand identity',
            'Visiting cards, letterheads & stationery',
            'Brochures, flyers & posters',
            'Social media creatives',
            'Packaging & label design',
            'UI/UX design for web & apps',
        ],
        'features' => [
            ['vector-pen', 'Original logos', 'Unique logo concepts with revisions until it feels exactly right.'],
            ['book', 'Brand guidelines', 'Colours, fonts and usage rules so your brand looks consistent everywhere.'],
            ['printer', 'Print-ready files', 'High-resolution files with correct bleed and colour settings for printing.'],
            ['instagram', 'Social templates', 'Reusable templates so your posts always look on-brand.'],
            ['bounding-box', 'UI/UX design', 'User-friendly interfaces and prototypes for websites and apps.'],
            ['lightning-charge', 'Quick turnaround', 'Fast delivery for festival posters, offers and event creatives.'],
        ],
        'process' => [
            ['Brief', 'Your business, audience, likes, dislikes and references.'],
            ['Concepts', 'Initial design directions presented with the thinking behind them.'],
            ['Refine', 'Revisions based on your feedback until it is just right.'],
            ['Deliver', 'Final files in all formats you need, for print and digital.'],
        ],
        'tools' => ['Adobe Illustrator', 'Adobe Photoshop', 'Figma', 'Canva', 'CorelDRAW', 'Adobe InDesign'],
        'faqs' => [
            ['How many logo options will I get?', 'Typically 2–3 initial concepts, followed by revisions on the one you like best.'],
            ['Will I get the source files?', 'Yes. You receive final files in AI/SVG, PDF, PNG and JPG formats, ready for any use.'],
            ['Can you design for festivals and events quickly?', 'Yes. We regularly design festival greetings, offer posters and event creatives with quick turnaround.'],
            ['Do you print as well?', 'We prepare print-ready files and can coordinate printing with trusted local partners on request.'],
        ],
    ],
];
