<style>
  :root {
    --primary-hover: #1d4ed8;
    --primary-light: rgba(37, 99, 235, 0.1);
    --text-dark: #0f172a;
    --text-muted: #64748b;
  }

  /* Base Setup */
  body {
    font-family: 'Plus Jakarta Sans', sans-serif;
    color: var(--text-dark);
    background-color: #f8fafc;
  }

  /* Hero Banner */
  .features-hero {
    padding: 5rem 0 3rem;
  }

  .badge-pill-custom {
    background-color: var(--primary-light);
    color: var(--primary);
    font-weight: 600;
    font-size: 0.85rem;
    padding: 0.5rem 1.25rem;
    border-radius: 50px;
    display: inline-block;
  }

  /* Feature Cards */
  .feature-card {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 16px;
    padding: 2rem;
    height: 100%;
    transition: all 0.3s ease;
  }

  .feature-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 20px 30px rgba(0, 0, 0, 0.05);
    border-color: rgba(37, 99, 235, 0.3);
  }

  .feature-icon-wrapper {
    width: 56px;
    height: 56px;
    border-radius: 12px;
    background-color: var(--primary-light);
    color: var(--primary);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    margin-bottom: 1.5rem;
  }

  .feature-title {
    font-size: 1.25rem;
    font-weight: 700;
    margin-bottom: 0.75rem;
  }

  .feature-desc {
    color: var(--text-muted);
    font-size: 0.95rem;
    line-height: 1.6;
    margin-bottom: 0;
  }

  /* Call To Action Card */
  .cta-section {
    background: linear-gradient(135deg, var(--primary) 0%, #1e40af 100%);
    border-radius: 20px;
    padding: 3.5rem 2rem;
    color: #ffffff;
  }

  .btn-cta {
    background-color: #ffffff;
    color: var(--primary);
    font-weight: 700;
    padding: 0.8rem 2rem;
    border-radius: 10px;
    transition: all 0.25s ease;
    border: none;
  }

  .btn-cta:hover {
    background-color: #f1f5f9;
    color: var(--primary-hover);
    transform: translateY(-2px);
    text-decoration: none;
  }
</style>

@extends('layout.home')

@section('meta_tags')
  <title>Features - ZeeCV</title>
  <meta name="description" content="Explore the powerful AI features of ZeeCV designed to build optimized, ATS-friendly resumes.">
@endsection

@section('content')
<section class="features-hero text-center">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-8">
        <span class="badge-pill-custom mb-3">Powerful Capabilities</span>
        <h1 class="display-4 font-weight-bold mb-3">Everything you need to land your next job</h1>
        <p class="lead text-muted">ZeeCV uses advanced AI and real-time analytics to help you craft a standout resume in minutes.</p>
      </div>
    </div>
  </div>
</section>

<section class="pb-5">
  <div class="container">
    <div class="row">
      <!-- Feature 1 -->
      <div class="col-md-6 col-lg-4 mb-4">
        <div class="feature-card">
          <div class="feature-icon-wrapper">
            <i class="fas fa-magic"></i>
          </div>
          <h3 class="feature-title">AI Content Generation</h3>
          <p class="feature-desc">Generate tailored summary bullet points and job descriptions optimized for your target industry automatically.</p>
        </div>
      </div>

      <!-- Feature 2 -->
      <div class="col-md-6 col-lg-4 mb-4">
        <div class="feature-card">
          <div class="feature-icon-wrapper">
            <i class="fas fa-check-circle"></i>
          </div>
          <h3 class="feature-title">ATS Resume Checker</h3>
          <p class="feature-desc">Ensure your CV bypasses Applicant Tracking Systems with real-time scoring and keyword optimization tips.</p>
        </div>
      </div>

      <!-- Feature 3 -->
      <div class="col-md-6 col-lg-4 mb-4">
        <div class="feature-card">
          <div class="feature-icon-wrapper">
            <i class="fas fa-layer-group"></i>
          </div>
          <h3 class="feature-title">Modern Templates</h3>
          <p class="feature-desc">Choose from clean, professional, and recruiter-tested templates customized for high readability.</p>
        </div>
      </div>

      <!-- Feature 4 -->
      <div class="col-md-6 col-lg-4 mb-4">
        <div class="feature-card">
          <div class="feature-icon-wrapper">
            <i class="fas fa-bolt"></i>
          </div>
          <h3 class="feature-title">Real-time Preview</h3>
          <p class="feature-desc">Watch your adjustments happen live with our instant side-by-side builder interface.</p>
        </div>
      </div>

      <!-- Feature 5 -->
      <div class="col-md-6 col-lg-4 mb-4">
        <div class="feature-card">
          <div class="feature-icon-wrapper">
            <i class="fas fa-file-pdf"></i>
          </div>
          <h3 class="feature-title">One-Click PDF Export</h3>
          <p class="feature-desc">Download crisp, high-resolution vector PDF resumes ready for immediate job application submissions.</p>
        </div>
      </div>

      <!-- Feature 6 -->
      <div class="col-md-6 col-lg-4 mb-4">
        <div class="feature-card">
          <div class="feature-icon-wrapper">
            <i class="fas fa-lock"></i>
          </div>
          <h3 class="feature-title">Data Privacy First</h3>
          <p class="feature-desc">Your personal information and career history are securely stored and strictly private to you.</p>
        </div>
      </div>
    </div>

    <!-- CTA Section -->
    <div class="row mt-5">
      <div class="col-12">
        <div class="cta-section text-center">
          <h2 class="font-weight-bold mb-3">Ready to build your AI-powered CV?</h2>
          <p class="mb-4 opacity-75">Join thousands of job seekers creating professional resumes for free.</p>
          <a href="{{ url('signup') }}" class="btn btn-cta">Get Started Free</a>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection