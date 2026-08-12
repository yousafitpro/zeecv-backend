@extends('layout.home')
@section('meta_tags')
<meta name="description" content="ZeeCV leverages advanced AI and smart analytics to craft a resume that stands out. Get a free, tailored, modern, and data‑driven resume today.">
@endsection
@section('content')

  <!-- HERO -->
  <section class="hero">
    <div class="hero-content">
      <h1>Build your <span>AI-powered CV - 100% FREE</h1>
      <p>ZeeCV leverages advanced AI and smart analytics to craft a resume that stands out. Get a free, tailored, modern, and data‑driven resume today.</p>
<div class="hero-actions">
    <a href="{{ url('signup') }}" class=" start-with-ai-app-btn">
        <i class="fas fa-magic"></i> Start with AI
    </a>

    <a href="https://play.google.com/store/apps/details?id=com.zeecv"
       target="_blank"
       rel="noopener noreferrer"
       class="download-app-btn">
        <i class="fab fa-google-play"></i>
        Download App
    </a>
</div>
      <div class="hero-stats">
        <div><span class="number">12k+</span><span class="label">CVs generated</span></div>
        <div><span class="number">96%</span><span class="label">interview rate</span></div>
        <div><span class="number">4.9★</span><span class="label">user rating</span></div>
      </div>
    </div>
    <div class="hero-image">
      <!-- decorative CV preview (font awesome + emoji) -->
      <div style="background: white; border-radius: 2rem; padding: 1rem 1rem 0.5rem 1rem; box-shadow: 0 20px 30px -15px rgba(0,0,0,0.05);">
        <div style="display: flex; justify-content: space-between; padding: 0.4rem 0.2rem; border-bottom: 1px dashed #e2e8f0; margin-bottom: 1rem;">
          <span style="font-weight: 700; font-size: 1.2rem;">Alex Rivera</span>
          <span style="color: #2563eb; background: #eef2ff; padding: 0.2rem 0.8rem; border-radius: 30px; font-size: 0.7rem; font-weight: 600;">AI optimized</span>
        </div>
        <div style="display: flex; gap: 2rem; font-size: 0.75rem; color: #334155; justify-content: center;">
          <span><i class="fas fa-envelope" style="color: #2563eb;"></i> alex.r@email.com</span>
          <span><i class="fas fa-phone" style="color: #2563eb;"></i> +1 234 567 890</span>
        </div>
        <div style="margin: 1rem 0; background: #f8fafc; padding: 0.6rem; border-radius: 1rem;">
          <div style="display: flex; gap: 0.8rem; flex-wrap: wrap; justify-content: center;">
            <span style="background: #e2e8f0; padding: 0.2rem 0.8rem; border-radius: 20px; font-size: 0.65rem;">Product Designer</span>
            <span style="background: #e2e8f0; padding: 0.2rem 0.8rem; border-radius: 20px; font-size: 0.65rem;">UX research</span>
            <span style="background: #e2e8f0; padding: 0.2rem 0.8rem; border-radius: 20px; font-size: 0.65rem;">Figma</span>
          </div>
        </div>
        <div style="display: flex; justify-content: space-between; background: #f1f5f9; border-radius: 40px; padding: 0.3rem 0.3rem 0.3rem 1.2rem; margin: 0.8rem 0;">
          <span style="font-size: 0.7rem; font-weight: 500;"><i class="fas fa-check-circle" style="color: #16a34a;"></i> ATS score 94</span>
          <span style="background: #2563eb; color: white; padding: 0.2rem 1rem; border-radius: 40px; font-size: 0.7rem; font-weight: 600;">Advanced</span>
        </div>
        <div class="cv-preview-badge"><i class="fas fa-robot"></i> AI skill match · 97%</div>
      </div>
    </div>
  </section>

  <!-- FEATURES -->
  <h2 class="section-title">Built with <span style="background: linear-gradient(135deg, #2563eb, #7c3aed); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;">AI + advanced</span> tools</h2>
  <p class="section-sub">From smart content generation to real‑time insights — every feature is designed to give you a competitive edge.</p>

  <div class="features-grid">
    <div class="feature-card">
      <div class="icon"><i class="fas fa-pen-fancy"></i></div>
      <h3>AI content writer</h3>
      <p>Let our AI craft bullet points, summaries, and achievements tailored to your industry.</p>
    </div>
    <div class="feature-card">
      <div class="icon"><i class="fas fa-chart-line"></i></div>
      <h3>Real‑time ATS scan</h3>
      <p>Optimize your CV for any job description with advanced keyword and skill matching.</p>
    </div>
    <div class="feature-card">
      <div class="icon"><i class="fas fa-layer-group"></i></div>
      <h3>Smart templates</h3>
      <p>Modern, minimal, or classic — all templates are designed by typography experts.</p>
    </div>
    <div class="feature-card">
      <div class="icon"><i class="fas fa-cloud-upload-alt"></i></div>
      <h3>One‑click export</h3>
      <p>PDF, Word, or plain text. Your CV is ready for any application portal in seconds.</p>
    </div>
  </div>

  <!-- AI ADVANCED SHOWCASE -->
  <div class="ai-showcase">
    <div class="left">
      <h2><i class="fas fa-microchip"></i> Advanced AI engine</h2>
      <p>ZeeCV uses a fine‑tuned language model and predictive analytics to personalize every section. It learns from millions of successful resumes.</p>
      <div class="badge-group">
        <span class="ai-badge"><i class="fas fa-robot"></i> GPT‑4 &amp; custom models</span>
        <span class="ai-badge"><i class="fas fa-database"></i> 2M+ job data points</span>
        <span class="ai-badge"><i class="fas fa-bolt"></i> real‑time suggestions</span>
      </div>
    </div>
    <div class="right">
      <div class="stat-item"><span class="stat-label">AI match accuracy</span><span class="stat-value"><i class="fas fa-check-circle"></i> 96%</span></div>
      <div class="stat-item"><span class="stat-label">Average build time</span><span class="stat-value"><i class="fas fa-clock"></i> 4.5 min</span></div>
      <div class="stat-item"><span class="stat-label">Resume strength</span><span class="stat-value"><i class="fas fa-shield-alt"></i> Excellent</span></div>
      <div class="stat-item"><span class="stat-label">Industry insights</span><span class="stat-value"><i class="fas fa-lightbulb"></i> 12+</span></div>
    </div>
  </div>

  <!-- TESTIMONIALS -->
  <h2 class="section-title" style="font-size: 2.2rem;">Loved by job seekers</h2>
  <div class="testimonial-grid">
    <div class="testimonial-card">
      <div class="stars"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i></div>
      <p>“ZeeCV’s AI rewrote my summary and I got 3 callbacks in a week. Seriously impressive.”</p>
      <div class="user"><i class="fas fa-user-circle"></i><div><div class="name">Maya Chen</div><div class="role">Marketing manager</div></div></div>
    </div>
    <div class="testimonial-card">
      <div class="stars"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i></div>
      <p>“The ATS scanner is a game changer. I landed my dream role at a FAANG company.”</p>
      <div class="user"><i class="fas fa-user-circle"></i><div><div class="name">James Okafor</div><div class="role">Software engineer</div></div></div>
    </div>
    <div class="testimonial-card">
      <div class="stars"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i></div>
      <p>“Clean templates and the AI suggestions saved me hours. Highly recommend ZeeCV.”</p>
      <div class="user"><i class="fas fa-user-circle"></i><div><div class="name">Priya Sharma</div><div class="role">Product designer</div></div></div>
    </div>
  </div>

  <!-- CTA -->
  <div class="cta-section">
    <h2>Start building your <span style="background: linear-gradient(135deg, #2563eb, #7c3aed); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;">AI CV</span> today</h2>
    <p>Join thousands of professionals who upgraded their career with ZeeCV.</p>
    <a href="{{ url('signup') }}" class="btn-primary"><i class="fas fa-rocket"></i> Create my CV now</a>
  </div>
@endsection