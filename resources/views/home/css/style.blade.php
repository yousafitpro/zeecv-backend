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
.start-with-ai-app-btn {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 11px 18px;
    background: var(--primary);
    color: #fff !important;
    border-radius: 8px;
    text-decoration: none !important;
    font-weight: 600;
    transition: all 0.2s ease;
}
.download-app-btn {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 11px 18px;
    background: #111827;
    color: #fff !important;
    border-radius: 8px;
    text-decoration: none !important;
    font-weight: 600;
    transition: all 0.2s ease;
}

.download-app-btn:hover {
    background: #2563eb;
    transform: translateY(-1px);
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