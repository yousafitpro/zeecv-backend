<style>
  :root {
    --primary: #2563eb;
    --primary-hover: #1d4ed8;
    --primary-light: rgba(37, 99, 235, 0.08);
    --text-dark: #0f172a;
    --text-muted: #64748b;
  }

  body {
    font-family: 'Plus Jakarta Sans', sans-serif;
    color: var(--text-dark);
    background-color: #f8fafc;
  }

  /* Hero Banner */
  .pricing-hero {
    padding: 5rem 0 3rem;
  }

  .badge-free {
    background-color: rgba(16, 185, 129, 0.1);
    color: #10b981;
    font-weight: 700;
    font-size: 0.85rem;
    padding: 0.5rem 1.25rem;
    border-radius: 50px;
    display: inline-block;
    text-transform: uppercase;
    letter-spacing: 0.05em;
  }

  /* Pricing Card */
  .pricing-card {
    background: #ffffff;
    border: 2px solid var(--primary);
    border-radius: 20px;
    padding: 3rem 2.5rem;
    box-shadow: 0 20px 40px rgba(37, 99, 235, 0.08);
    position: relative;
    transition: transform 0.3s ease;
  }

  .pricing-card:hover {
    transform: translateY(-5px);
  }

  .popular-tag {
    position: absolute;
    top: -16px;
    left: 50%;
    transform: translateX(-50%);
    background: var(--primary);
    color: #ffffff;
    padding: 0.35rem 1.25rem;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: 700;
    letter-spacing: 0.05em;
    text-transform: uppercase;
  }

  .price-amount {
    font-size: 3.5rem;
    font-weight: 800;
    color: var(--text-dark);
    line-height: 1;
  }

  .price-currency {
    font-size: 1.75rem;
    font-weight: 700;
    vertical-align: super;
    color: var(--primary);
  }

  /* Feature Checklist */
  .pricing-features {
    list-style: none;
    padding: 0;
    margin: 2rem 0;
  }

  .pricing-features li {
    padding: 0.75rem 0;
    color: var(--text-dark);
    font-size: 1rem;
    display: flex;
    align-items: center;
  }

  .pricing-features i {
    color: #10b981;
    font-size: 1.1rem;
    margin-right: 0.75rem;
  }

  /* Buttons */
  .btn-pricing-primary {
    background-color: var(--primary);
    color: #ffffff !important;
    font-weight: 700;
    padding: 0.85rem 2rem;
    border-radius: 12px;
    border: none;
    transition: all 0.25s ease;
    box-shadow: 0 8px 20px rgba(37, 99, 235, 0.25);
    display: block;
    width: 100%;
    text-align: center;
  }

  .btn-pricing-primary:hover {
    background-color: var(--primary-hover);
    transform: translateY(-2px);
    box-shadow: 0 12px 25px rgba(37, 99, 235, 0.35);
    text-decoration: none;
  }

  /* FAQ Section */
  .faq-card {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 12px;
    padding: 1.5rem;
    height: 100%;
  }

  .faq-question {
    font-weight: 700;
    font-size: 1.1rem;
    margin-bottom: 0.5rem;
  }

  .faq-answer {
    color: var(--text-muted);
    font-size: 0.95rem;
    margin-bottom: 0;
  }
</style>

@extends('layout.home')

@section('meta_tags')
  <title>100% Free Pricing - ZeeCV</title>
  <meta name="description" content="ZeeCV is 100% free. Enjoy unlimited access to AI resume building, ATS scoring, and PDF downloads without subscriptions.">
@endsection

@section('content')
<section class="pricing-hero text-center">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-8">
        <span class="badge-free mb-3">100% Free Forever</span>
        <h1 class="display-4 font-weight-bold mb-3">No Subscriptions. No Hidden Fees.</h1>
        <p class="lead text-muted">Build, optimize, and download professional AI-powered resumes completely free of charge.</p>
      </div>
    </div>
  </div>
</section>

<section class="pb-5">
  <div class="container">
    <!-- Single Free Tier Card -->
    <div class="row justify-content-center mb-5">
      <div class="col-md-8 col-lg-6">
        <div class="pricing-card text-center">
          <div class="popular-tag">Full Access</div>
          <h3 class="font-weight-bold mt-2 mb-1">Free Lifetime Plan</h3>
          <p class="text-muted small">Everything you need to land your dream job</p>
          
          <div class="my-4">
            <span class="price-currency">$</span>
            <span class="price-amount">0</span>
            <span class="text-muted">/ forever</span>
          </div>

          <ul class="pricing-features text-left">
            <li><i class="fas fa-check-circle"></i> Unlimited AI CV Generations</li>
            <li><i class="fas fa-check-circle"></i> ATS Compatibility Checking</li>
            <li><i class="fas fa-check-circle"></i> Access to All Premium Templates</li>
            <li><i class="fas fa-check-circle"></i> High-Resolution PDF Downloads</li>
            <li><i class="fas fa-check-circle"></i> Smart Keyword Match Analysis</li>
            <li><i class="fas fa-check-circle"></i> No Credit Card Required</li>
          </ul>

          <a href="{{ url('signup') }}" class="btn-pricing-primary mt-4">Start Building Free</a>
        </div>
      </div>
    </div>

    <!-- Frequently Asked Questions -->
    <div class="row justify-content-center pt-4">
      <div class="col-lg-10">
        <h2 class="text-center font-weight-bold mb-4">Frequently Asked Questions</h2>
        <div class="row">
          <div class="col-md-6 mb-4">
            <div class="faq-card">
              <h4 class="faq-question">Is ZeeCV really 100% free?</h4>
              <p class="faq-answer">Yes, absolutely! You can create, edit, optimize with AI, and download as many resumes as you want without paying a single cent.</p>
            </div>
          </div>
          <div class="col-md-6 mb-4">
            <div class="faq-card">
              <h4 class="faq-question">Are there limits on PDF downloads?</h4>
              <p class="faq-answer">No limits at all. You can export your resume to PDF whenever you need to update it for a new job application.</p>
            </div>
          </div>
          <div class="col-md-6 mb-4">
            <div class="faq-card">
              <h4 class="faq-question">Do I need to enter a credit card?</h4>
              <p class="faq-answer">No. You don't need to add any payment details or sign up for a trial period. Simply register an account and start building.</p>
            </div>
          </div>
          <div class="col-md-6 mb-4">
            <div class="faq-card">
              <h4 class="faq-question">Is my personal data safe?</h4>
              <p class="faq-answer">We take privacy seriously. Your data is encrypted and secure, and we never sell your personal information to third parties.</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection