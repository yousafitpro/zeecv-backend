<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>ZeeCV · AI CV Builder</title>
  <!-- Font Awesome (free icons) -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
      background: #f9fcff;
      color: #0b1a2e;
      line-height: 1.5;
    }

    .container {
      max-width: 1280px;
      margin: 0 auto;
      padding: 0 2rem;
    }

    /* header / nav */
    .navbar {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 1.5rem 0;
      flex-wrap: wrap;
    }

    .logo {
      display: flex;
      align-items: center;
      gap: 0.5rem;
      font-size: 1.8rem;
      font-weight: 700;
      letter-spacing: -0.02em;
      color: #0b1a2e;
    }
    .logo i {
      color: #3b82f6;
      font-size: 2rem;
    }
    .logo span {
      background: linear-gradient(145deg, #2563eb, #7c3aed);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      background-clip: text;
    }

    .nav-links {
      display: flex;
      gap: 2.5rem;
      align-items: center;
    }
    .nav-links a {
      text-decoration: none;
      color: #1e293b;
      font-weight: 500;
      transition: color 0.2s;
    }
    .nav-links a:hover {
      color: #2563eb;
    }
    .btn-outline {
      border: 1.5px solid #2563eb;
      background: transparent;
      padding: 0.5rem 1.5rem;
      border-radius: 60px;
      font-weight: 600;
      color: #2563eb;
      transition: all 0.2s;
      cursor: default;
    }
    .btn-outline:hover {
      background: #2563eb;
      color: white;
    }

    .btn-primary {
      background: #2563eb;
      border: none;
      padding: 0.7rem 2rem;
      border-radius: 60px;
      font-weight: 600;
      color: white;
      box-shadow: 0 8px 20px rgba(37, 99, 235, 0.25);
      transition: all 0.25s;
      cursor: default;
      display: inline-flex;
      align-items: center;
      gap: 0.5rem;
    }
    .btn-primary i {
      font-size: 1rem;
    }
    .btn-primary:hover {
      transform: translateY(-3px);
      box-shadow: 0 15px 30px rgba(37, 99, 235, 0.35);
      background: #1d4ed8;
    }

    /* hero section */
    .hero {
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 2.5rem 0 5rem 0;
      flex-wrap: wrap;
      gap: 2rem;
    }
    .hero-content {
      flex: 1 1 500px;
    }
    .hero-content h1 {
      font-size: 3.8rem;
      font-weight: 800;
      letter-spacing: -0.03em;
      line-height: 1.1;
      margin-bottom: 1.2rem;
    }
    .hero-content h1 span {
      background: linear-gradient(135deg, #2563eb, #7c3aed);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      background-clip: text;
    }
    .hero-content p {
      font-size: 1.25rem;
      color: #334155;
      max-width: 500px;
      margin-bottom: 2rem;
    }
    .hero-actions {
      display: flex;
      flex-wrap: wrap;
      gap: 1rem;
      align-items: center;
    }
    .hero-actions .btn-primary {
      padding: 0.9rem 2.5rem;
      font-size: 1.1rem;
    }
    .hero-stats {
      display: flex;
      gap: 2.5rem;
      margin-top: 2.8rem;
    }
    .hero-stats div {
      display: flex;
      flex-direction: column;
    }
    .hero-stats .number {
      font-size: 2rem;
      font-weight: 700;
      color: #0b1a2e;
    }
    .hero-stats .label {
      font-size: 0.9rem;
      color: #475569;
      letter-spacing: 0.02em;
    }

    .hero-image {
      flex: 1 1 400px;
      background: linear-gradient(145deg, #eef2ff, #e0e7ff);
      border-radius: 3rem 3rem 3rem 0;
      padding: 1.5rem 1.5rem 0 1.5rem;
      box-shadow: 0 25px 40px -10px rgba(37, 99, 235, 0.15);
      text-align: center;
    }
    .hero-image img {
      max-width: 100%;
      height: auto;
      display: block;
      margin: 0 auto;
      border-radius: 1.5rem 1.5rem 0 0;
      box-shadow: 0 10px 20px rgba(0,0,0,0.02);
    }
    .cv-preview-badge {
      background: white;
      padding: 0.8rem 1.8rem;
      border-radius: 60px;
      display: inline-block;
      margin-top: 0.5rem;
      font-weight: 600;
      font-size: 0.9rem;
      color: #1e293b;
      box-shadow: 0 2px 8px rgba(0,0,0,0.02);
      border: 1px solid rgba(37, 99, 235, 0.1);
    }
    .cv-preview-badge i {
      color: #2563eb;
      margin-right: 0.5rem;
    }

    /* features section */
    .section-title {
      font-size: 2.5rem;
      font-weight: 700;
      text-align: center;
      margin-bottom: 0.8rem;
      letter-spacing: -0.02em;
    }
    .section-sub {
      text-align: center;
      color: #475569;
      max-width: 600px;
      margin: 0 auto 3.5rem auto;
      font-size: 1.1rem;
    }

    .features-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
      gap: 2.5rem;
      margin-bottom: 4rem;
    }
    .feature-card {
      background: white;
      padding: 2rem 1.8rem;
      border-radius: 2rem;
      box-shadow: 0 10px 25px -8px rgba(0,0,0,0.03);
      border: 1px solid #f1f5f9;
      transition: all 0.25s;
    }
    .feature-card:hover {
      transform: translateY(-8px);
      border-color: #b9d0fa;
      box-shadow: 0 20px 35px -10px rgba(37, 99, 235, 0.08);
    }
    .feature-card .icon {
      background: #eef2ff;
      width: 60px;
      height: 60px;
      border-radius: 20px;
      display: flex;
      align-items: center;
      justify-content: center;
      margin-bottom: 1.5rem;
      font-size: 1.8rem;
      color: #2563eb;
    }
    .feature-card h3 {
      font-size: 1.4rem;
      margin-bottom: 0.6rem;
      font-weight: 700;
    }
    .feature-card p {
      color: #475569;
    }

    /* AI advanced section */
    .ai-showcase {
      background: #0b1a2e;
      border-radius: 3rem;
      padding: 4rem 3rem;
      margin: 4rem 0 5rem 0;
      color: white;
      display: flex;
      flex-wrap: wrap;
      align-items: center;
      justify-content: space-between;
      gap: 2rem;
    }
    .ai-showcase .left {
      flex: 1 1 300px;
    }
    .ai-showcase .left h2 {
      font-size: 2.5rem;
      font-weight: 700;
      line-height: 1.2;
      margin-bottom: 1rem;
    }
    .ai-showcase .left h2 i {
      color: #a78bfa;
      margin-right: 0.5rem;
    }
    .ai-showcase .left p {
      color: #cbd5e1;
      font-size: 1.1rem;
      max-width: 450px;
    }
    .ai-showcase .badge-group {
      display: flex;
      flex-wrap: wrap;
      gap: 1rem;
      margin-top: 2rem;
    }
    .ai-badge {
      background: rgba(255,255,255,0.06);
      backdrop-filter: blur(4px);
      border: 1px solid rgba(255,255,255,0.08);
      padding: 0.6rem 1.4rem;
      border-radius: 60px;
      font-weight: 500;
      display: flex;
      align-items: center;
      gap: 0.5rem;
      color: #e2e8f0;
    }
    .ai-badge i {
      color: #818cf8;
    }
    .ai-showcase .right {
      background: rgba(255,255,255,0.02);
      border-radius: 2rem;
      padding: 1.5rem;
      border: 1px solid rgba(255,255,255,0.05);
      flex: 1 1 280px;
      backdrop-filter: blur(5px);
    }
    .ai-showcase .right .stat-item {
      display: flex;
      justify-content: space-between;
      padding: 0.9rem 0.2rem;
      border-bottom: 1px solid rgba(255,255,255,0.04);
    }
    .ai-showcase .right .stat-item:last-child {
      border-bottom: none;
    }
    .ai-showcase .right .stat-label {
      color: #94a3b8;
    }
    .ai-showcase .right .stat-value {
      font-weight: 600;
      color: white;
    }
    .ai-showcase .right .stat-value i {
      color: #34d399;
      margin-right: 0.3rem;
    }

    /* testimonials / social proof */
    .testimonial-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
      gap: 2rem;
      margin: 3rem 0 4rem 0;
    }
    .testimonial-card {
      background: white;
      padding: 1.8rem;
      border-radius: 1.8rem;
      box-shadow: 0 4px 15px rgba(0,0,0,0.01);
      border: 1px solid #edf2f7;
    }
    .testimonial-card .stars {
      color: #fbbf24;
      letter-spacing: 3px;
      margin-bottom: 0.8rem;
    }
    .testimonial-card p {
      font-style: italic;
      color: #1e293b;
      font-weight: 450;
      margin-bottom: 1rem;
    }
    .testimonial-card .user {
      display: flex;
      align-items: center;
      gap: 0.8rem;
    }
    .testimonial-card .user i {
      font-size: 2rem;
      color: #94a3b8;
    }
    .testimonial-card .user .name {
      font-weight: 600;
      font-size: 0.95rem;
    }
    .testimonial-card .user .role {
      font-size: 0.8rem;
      color: #64748b;
    }

    /* CTA */
    .cta-section {
      background: #f1f5f9;
      border-radius: 3rem;
      padding: 4rem 2rem;
      text-align: center;
      margin: 3rem 0 4rem 0;
    }
    .cta-section h2 {
      font-size: 2.8rem;
      font-weight: 700;
      margin-bottom: 0.8rem;
    }
    .cta-section p {
      color: #334155;
      max-width: 500px;
      margin: 0 auto 2rem auto;
      font-size: 1.2rem;
    }
    .cta-section .btn-primary {
      font-size: 1.2rem;
      padding: 1rem 3.5rem;
    }

    /* footer */
    .footer {
      border-top: 1px solid #e2e8f0;
      padding: 2.5rem 0;
      display: flex;
      flex-wrap: wrap;
      justify-content: space-between;
      align-items: center;
      color: #475569;
      font-size: 0.95rem;
    }
    .footer .socials {
      display: flex;
      gap: 1.2rem;
    }
    .footer .socials i {
      font-size: 1.4rem;
      color: #64748b;
      transition: color 0.2s;
    }
    .footer .socials i:hover {
      color: #2563eb;
    }

    /* responsive */
    @media (max-width: 800px) {
      .hero-content h1 {
        font-size: 2.8rem;
      }
      .navbar {
        flex-direction: column;
        gap: 1rem;
      }
      .nav-links {
        flex-wrap: wrap;
        justify-content: center;
        gap: 1.2rem;
      }
      .ai-showcase {
        flex-direction: column;
        text-align: center;
        padding: 2.5rem 1.5rem;
      }
      .ai-showcase .left p {
        margin: 0 auto;
      }
      .badge-group {
        justify-content: center;
      }
    }
    @media (max-width: 500px) {
      .hero-stats {
        flex-direction: column;
        gap: 0.5rem;
      }
    }
  </style>
</head>
<body>

<div class="container">
  <!-- NAV -->
  <nav class="navbar">
    <div class="logo">
      <i class="fas fa-brain"></i>
      <span>ZeeCV</span>
    </div>
    <div class="nav-links">
      <a href="#">Features</a>
      <a href="#">Templates</a>
      <a href="#">Pricing</a>
      <a href="#" class="btn-outline">Log in</a>
      <a href="#" class="btn-primary" style="padding: 0.6rem 1.8rem;">Get started</a>
    </div>
  </nav>

  <!-- HERO -->
  <section class="hero">
    <div class="hero-content">
      <h1>Build your <span>AI-powered</span> CV in minutes</h1>
      <p>ZeeCV leverages advanced AI and smart analytics to craft a resume that stands out. Tailored, modern, and data‑driven.</p>
      <div class="hero-actions">
        <a href="#" class="btn-primary"><i class="fas fa-magic"></i> Start with AI</a>
        <a href="#" style="color: #2563eb; font-weight: 600; text-decoration: none; display: inline-flex; align-items: center; gap: 0.4rem;">See templates <i class="fas fa-arrow-right"></i></a>
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
    <a href="#" class="btn-primary"><i class="fas fa-rocket"></i> Create my CV now</a>
  </div>

  <!-- FOOTER -->
  <footer class="footer">
    <div>© 2026 ZeeCV — AI CV builder</div>
    <div class="socials">
      <i class="fab fa-twitter"></i>
      <i class="fab fa-linkedin-in"></i>
      <i class="fab fa-github"></i>
      <i class="fab fa-youtube"></i>
    </div>
  </footer>
</div>
<!-- end container -->

</body>
</html>