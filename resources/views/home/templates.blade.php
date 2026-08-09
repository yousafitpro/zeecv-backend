<style>
  :root {
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

  /* Hero Section */
  .templates-hero {
    padding: 5rem 0 2.5rem;
  }

  .badge-templates {
    background-color: var(--primary-light);
    color: var(--primary);
    font-weight: 700;
    font-size: 0.85rem;
    padding: 0.5rem 1.25rem;
    border-radius: 50px;
    display: inline-block;
    text-transform: uppercase;
    letter-spacing: 0.05em;
  }

  /* Filter Nav Tabs */
  .nav-pills-custom .nav-link {
    color: var(--text-muted);
    font-weight: 600;
    padding: 0.6rem 1.5rem;
    border-radius: 10px;
    transition: all 0.25s ease;
  }

  .nav-pills-custom .nav-link.active {
    background-color: var(--primary);
    color: #ffffff;
    box-shadow: 0 4px 12px rgba(37, 99, 235, 0.3);
  }

  /* Template Cards */
  .template-card {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 16px;
    overflow: hidden;
    transition: all 0.3s ease;
    height: 100%;
    display: flex;
    flex-direction: column;
  }

  .template-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 20px 30px rgba(0, 0, 0, 0.08);
    border-color: rgba(37, 99, 235, 0.3);
  }

  .template-img-wrapper {
    position: relative;
    background-color: #f1f5f9;
    padding: 1.5rem;
    text-align: center;
    overflow: hidden;
  }

  .template-img-wrapper img {
    max-width: 100%;
    border-radius: 8px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s ease;
  }

  .template-card:hover .template-img-wrapper img {
    transform: scale(1.02);
  }

  /* Badges on Template Cards */
  .badge-tag {
    position: absolute;
    top: 12px;
    right: 12px;
    font-size: 0.75rem;
    font-weight: 700;
    padding: 0.35rem 0.85rem;
    border-radius: 20px;
    text-transform: uppercase;
    letter-spacing: 0.04em;
  }

  .badge-advanced {
    background-color: #7c3aed;
    color: #ffffff;
    box-shadow: 0 4px 10px rgba(124, 58, 237, 0.3);
  }

  .badge-free-tag {
    background-color: #10b981;
    color: #ffffff;
  }

  .template-info {
    padding: 1.5rem;
    flex-grow: 1;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
  }

  .template-title {
    font-weight: 700;
    font-size: 1.15rem;
    margin-bottom: 0.3rem;
  }

  .template-desc {
    color: var(--text-muted);
    font-size: 0.875rem;
    margin-bottom: 1.25rem;
  }

  .btn-use-template {
    background-color: var(--primary-light);
    color: var(--primary);
    font-weight: 600;
    border-radius: 10px;
    padding: 0.6rem 1rem;
    text-align: center;
    transition: all 0.25s ease;
    border: none;
    display: block;
    width: 100%;
  }

  .btn-use-template:hover {
    background-color: var(--primary);
    color: #ffffff;
    text-decoration: none;
  }
</style>

@extends('layout.home')

@section('meta_tags')
  <title>Resume Templates - Free & Advanced AI Templates | ZeeCV</title>
  <meta name="description" content="Explore free and advanced ATS-friendly resume templates on ZeeCV. Choose a layout optimized by AI to land your next interview.">
@endsection

@section('content')
<section class="templates-hero text-center">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-8">
        <span class="badge-templates mb-3">Professional Layouts</span>
        <h1 class="display-4 font-weight-bold mb-3">Pick a Template & Get Started</h1>
        <p class="lead text-muted">Choose from free standard designs or advanced AI-optimized templates engineered for ATS scoring.</p>

        <!-- Category Filters -->
        <ul class="nav nav-pills nav-pills-custom justify-content-center mt-4" id="templateTabs" role="tablist">
          <li class="nav-item">
            <a class="nav-link active" id="all-tab" data-toggle="pill" href="#all" role="tab">All Templates</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" id="advanced-tab" data-toggle="pill" href="#advanced" role="tab">Advanced AI</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" id="free-tab" data-toggle="pill" href="#free" role="tab">100% Free</a>
          </li>
        </ul>
      </div>
    </div>
  </div>
</section>

<section class="pb-5">
  <div class="container">
    <div class="tab-content" id="templateTabsContent">
      
      <!-- ALL TEMPLATES -->
      <div class="tab-pane fade show active" id="all" role="tabpanel">
        <div class="row">
          
          <!-- Template 1: Advanced -->
          <div class="col-md-6 col-lg-4 mb-4">
            <div class="template-card">
              <div class="template-img-wrapper">
                <span class="badge-tag badge-advanced">Advanced AI</span>
                <img src="{{ asset('app-icons/logo.png') }}" alt="Alex Rivera Modern Template" class="img-fluid" style="max-height: 220px; object-fit: contain;">
              </div>
              <div class="template-info">
                <div>
                  <h3 class="template-title">Alex Rivera (AI Optimized)</h3>
                  <p class="template-desc">High ATS score structure designed for product designers, engineers, and tech pros.</p>
                </div>
                <a href="{{ url('signup') }}" class="btn-use-template">Use This Template</a>
              </div>
            </div>
          </div>

          <!-- Template 2: Free -->
          <div class="col-md-6 col-lg-4 mb-4">
            <div class="template-card">
              <div class="template-img-wrapper">
                <span class="badge-tag badge-free-tag">100% Free</span>
                <img src="{{ asset('app-icons/logo.png') }}" alt="Classic Minimal Template" class="img-fluid" style="max-height: 220px; object-fit: contain;">
              </div>
              <div class="template-info">
                <div>
                  <h3 class="template-title">Classic Minimal</h3>
                  <p class="template-desc">Clean, single-column design suitable for traditional industries and corporate roles.</p>
                </div>
                <a href="{{ url('signup') }}" class="btn-use-template">Use This Template</a>
              </div>
            </div>
          </div>

          <!-- Template 3: Advanced -->
          <div class="col-md-6 col-lg-4 mb-4">
            <div class="template-card">
              <div class="template-img-wrapper">
                <span class="badge-tag badge-advanced">Advanced AI</span>
                <img src="{{ asset('app-icons/logo.png') }}" alt="Executive Analytics Template" class="img-fluid" style="max-height: 220px; object-fit: contain;">
              </div>
              <div class="template-info">
                <div>
                  <h3 class="template-title">Executive Analytics</h3>
                  <p class="template-desc">Includes smart skill match indicators and keyword sections for senior positions.</p>
                </div>
                <a href="{{ url('signup') }}" class="btn-use-template">Use This Template</a>
              </div>
            </div>
          </div>

          <!-- Template 4: Free -->
          <div class="col-md-6 col-lg-4 mb-4">
            <div class="template-card">
              <div class="template-img-wrapper">
                <span class="badge-tag badge-free-tag">100% Free</span>
                <img src="{{ asset('app-icons/logo.png') }}" alt="Creative Standard Template" class="img-fluid" style="max-height: 220px; object-fit: contain;">
              </div>
              <div class="template-info">
                <div>
                  <h3 class="template-title">Modern Crisp</h3>
                  <p class="template-desc">Balanced layout with subtle color accents perfect for marketers and creatives.</p>
                </div>
                <a href="{{ url('signup') }}" class="btn-use-template">Use This Template</a>
              </div>
            </div>
          </div>

        </div>
      </div>

      <!-- ADVANCED TEMPLATES TAB -->
      <div class="tab-pane fade" id="advanced" role="tabpanel">
        <div class="row">
          <div class="col-md-6 col-lg-4 mb-4">
            <div class="template-card">
              <div class="template-img-wrapper">
                <span class="badge-tag badge-advanced">Advanced AI</span>
                <img src="{{ asset('app-icons/logo.png') }}" alt="Alex Rivera Modern Template" class="img-fluid" style="max-height: 220px; object-fit: contain;">
              </div>
              <div class="template-info">
                <div>
                  <h3 class="template-title">Alex Rivera (AI Optimized)</h3>
                  <p class="template-desc">High ATS score structure designed for product designers, engineers, and tech pros.</p>
                </div>
                <a href="{{ url('signup') }}" class="btn-use-template">Use This Template</a>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- FREE TEMPLATES TAB -->
      <div class="tab-pane fade" id="free" role="tabpanel">
        <div class="row">
          <div class="col-md-6 col-lg-4 mb-4">
            <div class="template-card">
              <div class="template-img-wrapper">
                <span class="badge-tag badge-free-tag">100% Free</span>
                <img src="{{ asset('app-icons/logo.png') }}" alt="Classic Minimal Template" class="img-fluid" style="max-height: 220px; object-fit: contain;">
              </div>
              <div class="template-info">
                <div>
                  <h3 class="template-title">Classic Minimal</h3>
                  <p class="template-desc">Clean, single-column design suitable for traditional industries and corporate roles.</p>
                </div>
                <a href="{{ url('signup') }}" class="btn-use-template">Use This Template</a>
              </div>
            </div>
          </div>
        </div>
      </div>

    </div>
  </div>
</section>
@endsection