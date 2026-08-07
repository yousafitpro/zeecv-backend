@extends('frontend.themes.eshoper.layout')

@section('content')
<br><br>
<div class="container">
    <div class="row">
         <div class="col-md-2"></div>
        <div class="col-md-8">
            <div class="card shadow rounded-3 p-4">
                <h2 class="text-center mb-4">Privacy Policy</h2>

                <p>At <strong>ScalifyPro</strong>, your privacy is extremely important to us. This Privacy Policy outlines how we collect, use, and protect your information when you use our platform.</p>

                <h4>1. Information We Collect</h4>
                <ul>
                    <li>Personal details: name, email address, phone number, shipping address.</li>
                    <li>Account data: login credentials, purchase history, affiliate activity.</li>
                    <li>Device and browser data: IP address, cookies, and usage analytics.</li>
                </ul>

                <h4>2. How We Use Your Information</h4>
                <ul>
                    <li>To process orders and manage payments securely.</li>
                    <li>To provide customer support and communicate updates.</li>
                    <li>To improve our platform experience and detect fraud or abuse.</li>
                    <li>To manage affiliate relationships and commissions.</li>
                </ul>

                <h4>3. Legal Basis (GDPR)</h4>
                <p>We process personal data in compliance with the EU General Data Protection Regulation (GDPR) based on:</p>
                <ul>
                    <li>Your consent.</li>
                    <li>Contractual necessity (e.g. completing a purchase).</li>
                    <li>Legal obligations (e.g. tax records).</li>
                    <li>Legitimate interests (e.g. analytics and security).</li>
                </ul>

                <h4>4. Sharing of Information</h4>
                <p>We do not sell your personal data. We may share information with trusted third parties only when necessary for:</p>
                <ul>
                    <li>Payment processing (e.g. Stripe, PayPal).</li>
                    <li>Shipping and logistics providers.</li>
                    <li>Marketing or analytics tools (e.g. Google Analytics).</li>
                </ul>

                <h4>5. Cookies</h4>
                <p>Our website uses cookies to enhance user experience. You can control cookie preferences through your browser settings.</p>

                <h4>6. Data Retention</h4>
                <p>We retain your data only as long as necessary for the purposes outlined above or to comply with legal requirements.</p>

                <h4>7. Your Rights</h4>
                <p>As an EU user, you have the right to:</p>
                <ul>
                    <li>Access the personal data we hold about you.</li>
                    <li>Request correction or deletion of your data.</li>
                    <li>Object to data processing or request restrictions.</li>
                    <li>Withdraw your consent at any time.</li>
                </ul>

                <h4>8. Data Security</h4>
                <p>We use encryption, access controls, and secure servers to protect your data from unauthorized access or disclosure.</p>

                <h4>9. Changes to This Policy</h4>
                <p>We may update this Privacy Policy to reflect legal or operational changes. Updates will be posted on this page with the revised date.</p>

                <h4>10. Contact Information</h4>
                <p>If you have any questions or wish to exercise your privacy rights, contact us at:</p>
                <p><strong>Email:</strong> support@scalifypro.net</p>
                <p><strong>Company:</strong> ScalifyPro, Italy</p>

                <hr>
                <p class="text-muted text-center">Last updated: {{ date('d/m/Y') }}</p>
            </div>
        </div>
    </div>
</div>
@endsection
