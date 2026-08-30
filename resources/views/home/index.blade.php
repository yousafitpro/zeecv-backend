@extends('layout.home')

@section('meta_tags')
<title>ZeeCV - AI Resume Builder & Job Board | Free</title>
<meta name="description" content="ZeeCV helps you build a professional CV with AI and find jobs from top companies. Create your resume and apply for free today.">
@endsection

@section('content')

<style>
    /* ==========================================
       JOB PREVIEW SECTION
    ========================================== */
    .job-preview-section {
        padding: 60px 20px;
        background: #f8fafc;
    }

    .job-preview-section .section-title {
        text-align: center;
        font-size: 2.2rem;
        font-weight: 700;
        margin-bottom: 10px;
        color: #0f172a;
    }

    .job-preview-section .section-sub {
        text-align: center;
        color: #64748b;
        font-size: 1.1rem;
        max-width: 600px;
        margin: 0 auto 40px;
    }

    .job-preview-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 20px;
        max-width: 1200px;
        margin: 0 auto;
    }

    .job-preview-card {
        background: white;
        border-radius: 16px;
        padding: 24px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.04);
        border: 1px solid #eef2f6;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .job-preview-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 30px rgba(0,0,0,0.08);
    }

    .job-preview-card .job-title {
        font-size: 1.1rem;
        font-weight: 700;
        color: #0f172a;
        margin-bottom: 4px;
    }

    .job-preview-card .job-company {
        color: #475569;
        font-size: 0.95rem;
        font-weight: 500;
    }

    .job-preview-card .job-meta {
        display: flex;
        gap: 16px;
        margin-top: 12px;
        flex-wrap: wrap;
        font-size: 0.85rem;
        color: #64748b;
    }

    .job-preview-card .job-meta i {
        margin-right: 4px;
        color: #2563eb;
    }

    .job-preview-card .job-tag {
        display: inline-block;
        background: #eef2ff;
        color: #2563eb;
        font-size: 0.7rem;
        font-weight: 600;
        padding: 3px 10px;
        border-radius: 30px;
        margin-top: 10px;
    }

    .view-all-jobs-btn {
        display: inline-block;
        margin: 30px auto 0;
        padding: 12px 32px;
        background: transparent;
        border: 2px solid #2563eb;
        color: #2563eb;
        border-radius: 40px;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.2s ease;
    }

    .view-all-jobs-btn:hover {
        background: #2563eb;
        color: white;
    }

    .text-center {
        text-align: center;
    }

    /* ==========================================
       EXISTING STYLES (keeping all original)
    ========================================== */
    .hero {
        display: flex;
        align-items: center;
        justify-content: space-between;
        max-width: 1200px;
        margin: 0 auto;
        padding: 50px 20px 40px;
        gap: 40px;
        flex-wrap: wrap;
    }

    .hero-content {
        flex: 1 1 500px;
    }

    .hero-content h1 {
        font-size: 3.2rem;
        font-weight: 800;
        line-height: 1.15;
        color: #0f172a;
        margin-bottom: 20px;
    }

    .hero-content h1 span {
        background: linear-gradient(135deg, #2563eb, #7c3aed);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .hero-content p {
        font-size: 1.15rem;
        color: #475569;
        max-width: 520px;
        line-height: 1.7;
        margin-bottom: 28px;
    }

    .hero-actions {
        display: flex;
        gap: 14px;
        flex-wrap: wrap;
        margin-bottom: 32px;
    }

    .start-with-ai-app-btn {
        background: #0f172a;
        color: white;
        padding: 12px 28px;
        border-radius: 40px;
        font-weight: 600;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 10px;
        transition: background 0.2s ease;
        border: none;
        font-size: 1rem;
    }

    .start-with-ai-app-btn:hover {
        background: #1e293b;
        color: white;
    }

    .download-app-btn {
        background: var(--primary);
        color: #0f172a;
        padding: 12px 28px;
        border-radius: 40px;
        font-weight: 600;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 10px;
        transition: background 0.2s ease;
        font-size: 1rem;
    }

    .download-app-btn:hover {
        background: #e2e8f0;
        color: #0f172a;
    }

    .hero-stats {
        display: flex;
        gap: 40px;
    }

    .hero-stats div {
        display: flex;
        flex-direction: column;
    }

    .hero-stats .number {
        font-size: 1.7rem;
        font-weight: 800;
        color: #0f172a;
    }

    .hero-stats .label {
        font-size: 0.85rem;
        color: #64748b;
    }

    .hero-image {
        flex: 1 1 380px;
        min-width: 280px;
    }

    .cv-preview-badge {
        margin-top: 12px;
        background: #f0fdf4;
        border: 1px solid #bbf7d0;
        color: #15803d;
        padding: 6px 14px;
        border-radius: 40px;
        font-size: 0.75rem;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .section-title {
        text-align: center;
        font-size: 2.4rem;
        font-weight: 700;
        color: #0f172a;
        margin: 70px 0 12px;
    }

    .section-sub {
        text-align: center;
        color: #64748b;
        font-size: 1.1rem;
        max-width: 600px;
        margin: 0 auto 40px;
        line-height: 1.6;
    }

    .features-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 25px;
        max-width: 1200px;
        margin: 0 auto 20px;
        padding: 0 20px;
    }

    .feature-card {
        background: white;
        border-radius: 20px;
        padding: 28px 22px;
        border: 1px solid #f1f5f9;
        transition: all 0.2s ease;
        text-align: center;
    }

    .feature-card:hover {
        border-color: #dbeafe;
        box-shadow: 0 8px 25px rgba(37, 99, 235, 0.06);
    }

    .feature-card .icon {
        font-size: 2rem;
        color: #2563eb;
        margin-bottom: 16px;
    }

    .feature-card h3 {
        font-size: 1.2rem;
        font-weight: 700;
        color: #0f172a;
        margin-bottom: 10px;
    }

    .feature-card p {
        color: #64748b;
        font-size: 0.95rem;
        line-height: 1.6;
        margin: 0;
    }

    .ai-showcase {
        display: flex;
        align-items: center;
        gap: 40px;
        max-width: 1200px;
        margin: 50px auto;
        padding: 40px 40px;
        background: #0f172a;
        border-radius: 32px;
        flex-wrap: wrap;
    }

    .ai-showcase .left {
        flex: 2 1 300px;
        color: white;
    }

    .ai-showcase .left h2 {
        font-size: 2rem;
        font-weight: 700;
        margin-bottom: 16px;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .ai-showcase .left p {
        color: #cbd5e1;
        font-size: 1rem;
        line-height: 1.7;
        max-width: 480px;
    }

    .badge-group {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        margin-top: 20px;
    }

    .ai-badge {
        background: rgba(255,255,255,0.08);
        padding: 6px 14px;
        border-radius: 40px;
        font-size: 0.8rem;
        font-weight: 500;
        color: #e2e8f0;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .ai-showcase .right {
        flex: 1 1 240px;
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 12px;
    }

    .stat-item {
        background: rgba(255,255,255,0.06);
        padding: 16px 14px;
        border-radius: 16px;
        text-align: center;
    }

    .stat-label {
        font-size: 0.7rem;
        text-transform: uppercase;
        letter-spacing: 0.04em;
        color: #94a3b8;
        display: block;
        margin-bottom: 4px;
    }

    .stat-value {
        font-weight: 700;
        font-size: 1rem;
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 4px;
    }

    .stat-value i {
        color: #34d399;
        font-size: 0.9rem;
    }

    .testimonial-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
        gap: 24px;
        max-width: 1200px;
        margin: 0 auto 30px;
        padding: 0 20px;
    }

    .testimonial-card {
        background: white;
        border-radius: 20px;
        padding: 24px 22px;
        border: 1px solid #f1f5f9;
    }

    .testimonial-card .stars {
        color: #f59e0b;
        font-size: 0.9rem;
        margin-bottom: 12px;
        letter-spacing: 2px;
    }

    .testimonial-card p {
        color: #1e293b;
        font-size: 0.95rem;
        line-height: 1.6;
        margin-bottom: 16px;
    }

    .testimonial-card .user {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .testimonial-card .user i {
        font-size: 2rem;
        color: #94a3b8;
    }

    .testimonial-card .user .name {
        font-weight: 700;
        color: #0f172a;
        font-size: 0.95rem;
    }

    .testimonial-card .user .role {
        font-size: 0.8rem;
        color: #64748b;
    }

    .cta-section {
        text-align: center;
        padding: 70px 20px;
        max-width: 700px;
        margin: 0 auto;
    }

    .cta-section h2 {
        font-size: 2.6rem;
        font-weight: 800;
        color: #0f172a;
        margin-bottom: 16px;
    }

    .cta-section p {
        color: #475569;
        font-size: 1.15rem;
        margin-bottom: 30px;
    }

    .btn-primary {
        background: #0f172a;
        color: white;
        padding: 14px 36px;
        border-radius: 40px;
        font-weight: 700;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 10px;
        transition: background 0.2s ease;
        font-size: 1.05rem;
    }

    .btn-primary:hover {
        background: #1e293b;
        color: white;
    }

    @media (max-width: 700px) {
        .hero-content h1 {
            font-size: 2.4rem;
        }
        .hero-stats {
            gap: 20px;
            flex-wrap: wrap;
        }
        .ai-showcase .right {
            grid-template-columns: 1fr 1fr;
        }
        .ai-showcase {
            padding: 30px 20px;
        }
        .section-title {
            font-size: 1.9rem;
        }
        .cta-section h2 {
            font-size: 2rem;
        }
    }
</style>

<!-- ==========================================
     HERO
========================================== -->
<section class="hero">
    <div class="hero-content">
        <h1>AI Resume Builder + <span>Job Board</span></h1>
        <p>
            ZeeCV helps you build an AI-powered CV <strong>and</strong> connects you with 
            <strong>thousands of jobs</strong> posted by companies worldwide. 
            Build your resume, apply instantly, and land your dream role — all in one place.
        </p>
        <div class="hero-actions">
            <a href="{{ url('signup') }}" class="start-with-ai-app-btn">
                <i class="fas fa-magic"></i> Build Your CV
            </a>
            <a href="{{ route('home.jobs') }}" class="download-app-btn">
                <i class="fas fa-briefcase"></i> Browse Jobs
            </a>
        </div>
        <div class="hero-stats">
            <div><span class="number">12k+</span><span class="label">CVs generated</span></div>
            <div><span class="number">8k+</span><span class="label">Jobs posted</span></div>
            <div><span class="number">96%</span><span class="label">interview rate</span></div>
        </div>
    </div>
    <div class="hero-image">
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

<!-- ==========================================
     FEATURES
========================================== -->
<h2 class="section-title">Everything you need to <span style="background: linear-gradient(135deg, #2563eb, #7c3aed); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;">land your next role</span></h2>
<p class="section-sub">From AI-powered resume building to a massive job board with thousands of active listings — ZeeCV is your all-in-one career platform.</p>

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
        <div class="icon"><i class="fas fa-briefcase"></i></div>
        <h3>Job board</h3>
        <p>Browse thousands of live job listings from companies actively hiring across all industries.</p>
    </div>
    <div class="feature-card">
        <div class="icon"><i class="fas fa-cloud-upload-alt"></i></div>
        <h3>One‑click apply</h3>
        <p>Apply to jobs directly with your ZeeCV resume. No more re‑typing your details over and over.</p>
    </div>
</div>

<!-- ==========================================
     JOB PREVIEW SECTION (NEW)
========================================== -->
<section class="job-preview-section">
    <h2 class="section-title" style="margin-top: 0;">🔥 Latest <span style="background: linear-gradient(135deg, #2563eb, #7c3aed); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;">jobs</span> from our board</h2>
    <p class="section-sub">Thousands of companies post jobs on ZeeCV every day. Here's what's trending right now.</p>

    <div class="job-preview-grid">
        <!-- Job 1 -->
        <div class="job-preview-card">
            <div class="job-title">Senior Full-Stack Engineer</div>
            <div class="job-company">TechVibe Inc.</div>
            <div class="job-meta">
                <span><i class="fas fa-map-marker-alt"></i> Remote</span>
                <span><i class="fas fa-clock"></i> Full-time</span>
            </div>
            <span class="job-tag">🔥 50+ applicants</span>
        </div>

        <!-- Job 2 -->
        <div class="job-preview-card">
            <div class="job-title">Product Marketing Manager</div>
            <div class="job-company">GrowthLabs</div>
            <div class="job-meta">
                <span><i class="fas fa-map-marker-alt"></i> New York, NY</span>
                <span><i class="fas fa-clock"></i> Full-time</span>
            </div>
            <span class="job-tag">⭐ Featured</span>
        </div>

        <!-- Job 3 -->
        <div class="job-preview-card">
            <div class="job-title">UX/UI Designer</div>
            <div class="job-company">DesignSphere</div>
            <div class="job-meta">
                <span><i class="fas fa-map-marker-alt"></i> London, UK</span>
                <span><i class="fas fa-clock"></i> Contract</span>
            </div>
            <span class="job-tag">📅 Posted 2 days ago</span>
        </div>
    </div>

    <div class="text-center">
        <a href="{{ route('home.jobs') }}" class="view-all-jobs-btn">
            View all jobs <i class="fas fa-arrow-right"></i>
        </a>
    </div>
</section>

<!-- ==========================================
     AI ADVANCED SHOWCASE
========================================== -->
<div class="ai-showcase">
    <div class="left">
        <h2><i class="fas fa-microchip"></i> Advanced AI engine</h2>
        <p>ZeeCV uses a fine‑tuned language model and predictive analytics to personalize every section. It learns from millions of successful resumes and real‑time job market data.</p>
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
        <div class="stat-item"><span class="stat-label">Jobs available</span><span class="stat-value"><i class="fas fa-briefcase"></i> 8,200+</span></div>
    </div>
</div>

<!-- ==========================================
     TESTIMONIALS
========================================== -->
<h2 class="section-title" style="font-size: 2.2rem;">Loved by job seekers &amp; employers</h2>

<div class="testimonial-grid">
    <div class="testimonial-card">
        <div class="stars"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i></div>
        <p>“ZeeCV’s AI rewrote my summary and I got 3 callbacks in a week. The job board made it so easy to apply.”</p>
        <div class="user"><i class="fas fa-user-circle"></i><div><div class="name">Maya Chen</div><div class="role">Marketing manager</div></div></div>
    </div>
    <div class="testimonial-card">
        <div class="stars"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i></div>
        <p>“The ATS scanner is a game changer. I landed my dream role at a FAANG company using ZeeCV.”</p>
        <div class="user"><i class="fas fa-user-circle"></i><div><div class="name">James Okafor</div><div class="role">Software engineer</div></div></div>
    </div>
    <div class="testimonial-card">
        <div class="stars"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i></div>
        <p>“We posted a job on ZeeCV and got 150+ qualified applicants in 48 hours. The best hiring decision we made.”</p>
        <div class="user"><i class="fas fa-user-circle"></i><div><div class="name">Sarah Thompson</div><div class="role">HR Director, CloudKit</div></div></div>
    </div>
</div>

<!-- ==========================================
     CTA
========================================== -->
<div class="cta-section">
    <h2>Find jobs &amp; build your <span style="background: linear-gradient(135deg, #2563eb, #7c3aed); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;">AI CV</span> today</h2>
    <p>Join thousands of professionals who upgraded their careers with ZeeCV's resume builder and job board.</p>
    <a href="{{ url('signup') }}" class="btn-primary"><i class="fas fa-rocket"></i> Get started — it's free</a>
</div>

@endsection