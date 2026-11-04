<?php
defined('APP_ROOT') || exit;
$name = e(config('legal_name'));
partial('page-hero', [
    'title'  => 'Terms & Conditions',
    'text'   => 'The terms that apply when you use this website and engage our services.',
    'crumbs' => [['Terms & Conditions', 'terms-and-conditions']],
    'icon'   => 'file-earmark-text',
]);
?>
<section class="section">
  <div class="container container-narrow">
    <span class="legal-updated"><?= icon('calendar3') ?> Last updated: 3 November 2026</span>
    <div class="prose">
      <p>These Terms &amp; Conditions govern your use of this website, operated by <strong><?= $name ?></strong>, a <?= e(strtolower(config('legal_type'))) ?> firm based at <?= e(full_address(true)) ?>. By using this website, you accept these terms.</p>

      <h2>1. Use of this website</h2>
      <p>The content on this website is for general information about our services. You agree not to misuse the website, submit false information, attempt to gain unauthorised access, or send spam through our forms.</p>

      <h2>2. Quotes and proposals</h2>
      <p>Quotes provided through the website, phone, WhatsApp or email are estimates based on the information you share. The final scope, deliverables, timeline and price for any project are those stated in the written proposal or agreement accepted by both parties. Quotes are valid for 30 days unless stated otherwise.</p>

      <h2>3. Payments</h2>
      <p>Payment terms, including advance amounts and milestones, are specified in each proposal. Prices for clients in India are quoted in INR and may be subject to applicable taxes; prices for international clients may be quoted in USD. Third-party costs such as domain names, hosting, paid software, app store fees and advertising budgets are separate unless included in writing.</p>

      <h2>4. Client responsibilities</h2>
      <p>Clients are responsible for providing accurate content, timely feedback and the necessary approvals, and for ensuring they have the rights to any text, images, logos or other material they provide to us.</p>

      <h2>5. Intellectual property</h2>
      <p>Upon full payment, ownership of the final deliverables created specifically for the client is transferred to the client, unless otherwise agreed. We may use third-party or open-source components, which remain subject to their own licences. We may showcase completed work in our portfolio unless the client asks us not to.</p>

      <h2>6. Temple services</h2>
      <p>For live darshan, websites, apps and donation services provided to temples, the temple trust remains the owner of its channels, accounts and donation funds. Online donations are processed by licensed payment gateways and credited directly to the trust’s account. Camera installation and streaming are carried out with the trust’s approval and in line with its customs.</p>

      <h2>7. Third-party platforms</h2>
      <p>Our services may depend on platforms such as Google, Meta, YouTube, WhatsApp, app stores and payment gateways. We are not responsible for changes, outages, policy decisions or account actions taken by these platforms. We cannot guarantee specific search rankings, ad performance, follower counts or app store approval.</p>

      <h2>8. Limitation of liability</h2>
      <p>To the extent permitted by law, we are not liable for indirect or consequential losses arising from the use of this website or our services. Our total liability for any project is limited to the amount paid for that project.</p>

      <h2>9. External links</h2>
      <p>This website may link to external websites, including client projects. We are not responsible for the content or practices of those sites.</p>

      <h2>10. Governing law</h2>
      <p>These terms are governed by the laws of India. Any disputes are subject to the exclusive jurisdiction of the courts at Jalgaon, Maharashtra.</p>

      <h2>11. Changes</h2>
      <p>We may update these terms from time to time. Continued use of the website after changes means you accept the updated terms.</p>

      <h2>12. Contact</h2>
      <p>Questions about these terms? Contact us at <a href="<?= e(mailto_url()) ?>"><?= e(config('email')) ?></a> or <a href="<?= e(tel_url()) ?>"><?= e(config('phone')) ?></a>.</p>
    </div>
  </div>
</section>
