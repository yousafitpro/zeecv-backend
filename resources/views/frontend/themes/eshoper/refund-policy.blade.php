@extends('frontend.themes.eshoper.layout')

@section('content')
<style>
    .policy-wrapper {
        max-width: 850px;
        margin: 50px auto;
        background-color: #fff;
        padding: 40px;
        border-radius: 12px;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);
        font-family: 'Segoe UI', Tahoma, sans-serif;
        color: #333;
    }

    .policy-wrapper h2 {
        font-size: 28px;
        font-weight: 700;
        margin-bottom: 10px;
        color: #2c3e50;
    }

    .policy-wrapper p {
        margin-bottom: 20px;
        line-height: 1.6;
    }

    .policy-section {
        margin-bottom: 30px;
    }

    .policy-section h4 {
        font-size: 20px;
        font-weight: 600;
        margin-bottom: 12px;
        color: #1a73e8;
    }

    .policy-section ul, .policy-section ol {
        padding-left: 20px;
        line-height: 1.7;
    }

    .policy-section li {
        margin-bottom: 8px;
    }

    .policy-section a {
        color: #007bff;
        text-decoration: none;
    }

    .policy-section a:hover {
        text-decoration: underline;
    }
</style>

<div class="policy-wrapper">
    <h2>Return and Refund Policy</h2>
    <p><strong>Effective Date:</strong> July 14, 2025</p>
    <p>Your satisfaction is our priority. If for any reason you are not completely satisfied with your purchase, we are here to help with the return and refund process.</p>

    <div class="policy-section">
        <h4>1. General Return Policy</h4>
        <p>You have 30 days from the date you received your item to request a return.</p>
    </div>

    <div class="policy-section">
        <h4>2. Conditions for Returns</h4>
        <ul>
            <li>The item must be unused, undamaged, and with all original tags attached.</li>
            <li>It must be in its original packaging.</li>
            <li>A proof of purchase (such as a receipt or order confirmation) is required.</li>
        </ul>
    </div>

    <div class="policy-section">
        <h4>3. Non-Refundable Items</h4>
        <ul>
            <li>Gift cards</li>
            <li>Downloadable digital products (e.g., software, ebooks, courses)</li>
            <li>Sale or "Outlet" items (if specified on the product page)</li>
            <li>Custom or personalized items</li>
            <li>Perishable goods (if applicable)</li>
        </ul>
    </div>

    <div class="policy-section">
        <h4>4. Return Process (How to Initiate a Return)</h4>
        <ol>
            <li><strong>Contact Us:</strong> Email <a href="mailto:info@scalifypro.net">info@scalifypro.net</a> with subject "Return Request - Order #[Your Order Number]".</li>
            <li><strong>Await Instructions:</strong> Our team will respond within 48 business hours with return steps and the address.</li>
            <li><strong>Ship the Item:</strong> Pack securely and ship with tracking. We are not responsible for lost or damaged items during return transit.</li>
        </ol>
    </div>

    <div class="policy-section">
        <h4>5. Inspection and Refunds</h4>
        <ul>
            <li><strong>If approved:</strong> A refund will be processed and returned to your original payment method within 5–10 business days.</li>
            <li><strong>If rejected:</strong> We will notify you of the reason and options (e.g., item return at your expense).</li>
        </ul>
    </div>

    <div class="policy-section">
        <h4>6. Return Shipping Costs</h4>
        <p>You are responsible for return shipping costs. Original shipping fees are non-refundable and may be deducted from your refund.</p>
    </div>

    <div class="policy-section">
        <h4>7. Damaged or Incorrect Items</h4>
        <p>If you received a damaged, defective, or incorrect item, contact us within 48 hours of receipt at <a href="mailto:info@scalifypro.net">info@scalifypro.net</a>. Include a photo and your order number. We'll replace the item or offer a full refund including shipping.</p>
    </div>

    <div class="policy-section">
        <h4>8. Exchanges</h4>
        <p>To get a different item, return the original and place a new order after the return is accepted.</p>
    </div>

    <div class="policy-section">
        <h4>9. Contact Us</h4>
        <p>For any questions regarding our Return and Refund Policy, please contact us at <a href="mailto:info@scalifypro.net">info@scalifypro.net</a>.</p>
    </div>
</div>
@endsection
