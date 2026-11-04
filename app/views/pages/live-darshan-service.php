<?php
defined('APP_ROOT') || exit;
$delays = ['', 'reveal-d1', 'reveal-d2', 'reveal-d3'];

partial('page-hero', [
    'title'   => 'Temple Live Darshan Service in Maharashtra',
    'text'    => 'We set up and run HD live darshan for temples, so devotees can join daily aarti, festivals and special poojas from anywhere in the world.',
    'crumbs'  => [['Temples', 'temple-solutions'], ['Live Darshan Service', 'live-darshan-service']],
    'eyebrow' => '24x7 live temple darshan',
    'image'   => 'img/temple-mark.svg',
    'variant' => 'temple',
    'actions' => '<a class="btn btn-primary" href="' . e(url('devasthan-live')) . '#register">' . icon('bank') . ' Register Your Temple</a>'
               . '<a class="btn btn-whatsapp" href="' . e(whatsapp_url('Namaste, I would like to know about the live darshan service for our temple.')) . '" target="_blank" rel="noopener">' . icon('whatsapp') . ' WhatsApp Us</a>',
]);
?>

<!-- ── What it is ────────────────────────────────────────────────────── -->
<section class="section">
  <div class="container split split-top">
    <div class="reveal">
      <span class="eyebrow">What is a live darshan service?</span>
      <h2>Darshan for every devotee, wherever they live</h2>
      <p class="lead">A live darshan service broadcasts your temple over the internet, so devotees who cannot visit can still see the deity and join the aarti on their phone, TV or computer.</p>
      <p>It helps elderly devotees, people who are unwell, and families who have moved to other cities or countries stay connected to their temple every day. For the temple, it also means more visibility, wider participation in festivals and an easier way for faraway devotees to offer seva.</p>
      <p>We handle the complete setup from our base in Amalner, Jalgaon district, so the trust and priests do not need any technical knowledge. See how it works in our <a href="<?= e(url('blog/why-every-temple-should-offer-live-darshan')) ?>">guide to live darshan for temples</a>.</p>
    </div>
    <div class="card reveal reveal-d2" style="background:var(--gold-50);border-color:#efdcb3">
      <h3><?= icon('list-check') ?> What’s included</h3>
      <ul class="check-list gold mb-0">
        <li>HD camera installation, placed with the trust’s approval</li>
        <li>Internet and streaming equipment setup</li>
        <li>YouTube channel in the temple’s own name</li>
        <li>Live stream on your website and app</li>
        <li>Daily aarti and festival broadcasts</li>
        <li>Stream monitoring and ongoing support</li>
      </ul>
    </div>
  </div>
</section>

<!-- ── Streaming options ─────────────────────────────────────────────── -->
<section class="section section-soft">
  <div class="container">
    <div class="section-head center">
      <span class="eyebrow">Choose what suits your temple</span>
      <h2>Three ways to stream</h2>
      <p>Start small and add more later. We recommend the right option after visiting the temple.</p>
    </div>
    <div class="grid grid-3">
      <?php foreach ([
          ['broadcast', '24x7 live darshan', 'A continuous stream of the deity, so devotees can take darshan at any hour of the day or night.'],
          ['clock', 'Aarti-time streaming', 'The stream runs on the temple’s schedule, covering morning and evening aarti and daily rituals.'],
          ['calendar-event', 'Festival & event coverage', 'Live coverage of festivals, yatras, utsavs and special poojas, for temples not ready for daily streaming.'],
      ] as $k => [$ic, $t, $d]): ?>
        <div class="card feature-card card-hover reveal <?= $delays[$k] ?>">
          <div class="icon-box<?= $k % 2 ? ' maroon' : ' gold' ?>"><?= icon($ic) ?></div>
          <h3><?= e($t) ?></h3>
          <p><?= e($d) ?></p>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- ── What the temple needs ─────────────────────────────────────────── -->
<section class="section">
  <div class="container split">
    <div class="reveal">
      <span class="eyebrow">What your temple needs</span>
      <h2>Less than most trustees expect</h2>
      <p class="lead">We check all of this during the site visit and tell you exactly what is required before any work starts.</p>
    </div>
    <div class="grid grid-2 reveal reveal-d2">
      <?php foreach ([
          ['hand-thumbs-up', 'Trust approval', 'Permission from the trustees and priests for the camera position.'],
          ['camera-video', 'A clear view', 'A respectful place for the camera, with a good view of the deity.'],
          ['wifi', 'Stable internet', 'Broadband is ideal. A reliable 4G or 5G router can also work.'],
          ['lightning-charge', 'Steady power', 'A power point nearby. Backup is useful if power cuts are common.'],
      ] as $k => [$ic, $t, $d]): ?>
        <div class="card feature-card">
          <div class="icon-box<?= $k % 3 ? ' maroon' : ' gold' ?>"><?= icon($ic) ?></div>
          <h3><?= e($t) ?></h3>
          <p><?= e($d) ?></p>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- ── Where we work ─────────────────────────────────────────────────── -->
<section class="section section-soft">
  <div class="container">
    <div class="section-head center">
      <span class="eyebrow">Where we work</span>
      <h2>Live darshan for temples across Maharashtra</h2>
      <p>We are based in Amalner and can set up live darshan at temples anywhere in the state.</p>
    </div>
    <div class="grid grid-3">
      <?php foreach ([
          ['Khandesh', 'Jalgaon, Dhule and Nandurbar, close to our Amalner office.'],
          ['North Maharashtra', 'Nashik and the temple towns around it.'],
          ['Western Maharashtra', 'Pune, Satara, Sangli, Solapur and Kolhapur.'],
          ['Marathwada', 'Chhatrapati Sambhajinagar, Nanded, Latur, Beed and nearby districts.'],
          ['Vidarbha', 'Nagpur, Amravati, Akola, Wardha and nearby districts.'],
          ['Mumbai & Konkan', 'Mumbai, Thane, Raigad, Ratnagiri and Sindhudurg.'],
      ] as $k => [$t, $d]): ?>
        <div class="card feature-card reveal <?= $delays[$k % 3] ?>">
          <h3><?= icon('geo-alt') ?> <?= e($t) ?></h3>
          <p><?= e($d) ?></p>
        </div>
      <?php endforeach; ?>
    </div>
    <p class="text-center" style="margin:32px 0 0">Our work includes live darshan and social media for Shri Mangal Grah Mandir, Amalner. <a href="<?= e(url('portfolio/mangal-grah-mandir-live-darshan')) ?>"><strong>Read the case study</strong></a>.</p>
  </div>
</section>

<!-- ── Marathi ───────────────────────────────────────────────────────── -->
<section class="section" lang="mr">
  <div class="container container-narrow">
    <div class="invite reveal">
      <div class="ornament"><?= icon('flower1') ?></div>
      <h2>मंदिरांसाठी २४x७ लाईव्ह दर्शन सेवा</h2>
      <p class="lead">आशापार्थ एआय मल्टीसर्व्हिसेस महाराष्ट्रातील मंदिरांसाठी लाईव्ह दर्शनाची संपूर्ण सेवा देते. एचडी कॅमेरा बसवणे, यूट्यूब व वेबसाइटवर थेट प्रक्षेपण, रोजची आरती, उत्सव व यात्रांचे लाईव्ह प्रक्षेपण, ऑनलाइन देणगी आणि सोशल मीडिया व्यवस्थापन ही सर्व कामे आमची टीम करते.</p>
      <p>देश-विदेशातील भाविकांना घरबसल्या दर्शन घेता यावे यासाठी आपल्या मंदिराची नोंदणी करा. मंदिराचे विश्वस्त किंवा समिती सदस्य आमच्याशी थेट संपर्क साधू शकतात.</p>
      <div class="hero-actions" style="justify-content:center;margin-bottom:0">
        <a class="btn btn-primary" href="<?= e(url('devasthan-live')) ?>#register"><?= icon('bank') ?> मंदिराची नोंदणी करा</a>
        <a class="btn btn-whatsapp" href="<?= e(whatsapp_url('नमस्कार, आमच्या मंदिरासाठी लाईव्ह दर्शन सेवेची माहिती हवी आहे.')) ?>" target="_blank" rel="noopener"><?= icon('whatsapp') ?> व्हॉट्सॲपवर संपर्क करा</a>
      </div>
    </div>
  </div>
</section>

<!-- ── FAQ ───────────────────────────────────────────────────────────── -->
<section class="section section-soft">
  <div class="container container-narrow">
    <div class="section-head center">
      <span class="eyebrow">FAQ</span>
      <h2>Live darshan questions from trustees</h2>
    </div>
    <?php partial('faq', ['items' => [
        ['How much does a temple live darshan setup cost?', 'It depends on the number of cameras, the internet available and whether you want 24x7 or scheduled streaming. After a site visit we give the trust a clear written quote.'],
        ['Can the stream run 24 hours a day?', 'Yes, if the temple has a stable internet connection and power. Where that is difficult, the stream can run only during aarti or on festival days.'],
        ['What happens if the internet or power goes off?', 'The broadcast pauses until the connection returns. We monitor streams and can recommend backup internet or power for temples where this happens often.'],
        ['Can devotees watch without an app?', 'Yes. Devotees can watch on YouTube or the temple website on any phone, TV or computer, with no special app needed.'],
        ['Who owns the channel and its videos?', 'The temple does. The YouTube channel is created in the temple’s name and stays with the trust.'],
        ['How long does the setup take?', 'It depends on the temple and the equipment needed. We confirm a date after the site visit.'],
    ]]); ?>
  </div>
</section>

<?php partial('cta', [
    'title'   => 'Bring live darshan to your temple',
    'text'    => 'Register your temple with Maharashtra Devasthan Live and our team will contact you to plan a site visit.',
    'primary' => ['Register Your Temple', 'devasthan-live#register'],
]); ?>
