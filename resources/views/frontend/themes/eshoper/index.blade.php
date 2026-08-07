@extends('frontend.themes.eshoper.layout')
@section('content')
    <style>
    .hero-logo {
        margin-bottom: 2rem;
    }

    .hero-logo img {
        width: 240px;
        height: auto;
    }

    @media (max-width: 768px) {
        .hero-logo img {
            width: 180px;
        }
    }

        @font-face {
            font-family: 'Bebas Neue';
            src: url(./fonts/BebasNeue.otf);
        }

        :root {
            --primary: #29a5ab;
            --primary-dark: #1f8c8f;
            --secondary: #4a4a4a; /* Neutral Accent */
            --secondary-light: #e0e0e0; /* Light accent for borders/text */
            --white: #ffffff;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Roboto', sans-serif;
            line-height: 1.6;
            -webkit-font-smoothing: antialiased;
        }

        /* Hero Section */
        .hero {
background: url("{{$dataUri}}");
background-repeat: no-repeat;
background-size: cover;       /* fills the area without tiling */
background-position: center;  /* keeps image centered */
min-height: 100vh;
display: flex;
align-items: center;
position: relative;
color: var(--white);
padding: 4rem 0;
overflow: hidden;
        }

        .hero::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.05'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
            opacity: 0.1;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 2rem;
            position: relative;
            z-index: 1;
        }

        .hero-content {
            text-align: center;
            max-width: 800px;
            margin: 0 auto;
        }

        .hero-title {
            font-family: 'Bebas Neue', sans-serif;
            font-size: 4.5rem;
            margin-bottom: 1.5rem;
            line-height: 1.1;
            animation: fadeInDown 1s ease;
        }

        .hero-subtitle {
            font-size: 1.8rem;
            margin-bottom: 3rem;
            font-weight: 300;
            opacity: 0.9;
            animation: fadeInUp 1s ease 0.3s;
            animation-fill-mode: both;
        }

        .cta-button {
            display: inline-block;
            background: var(--secondary);
            color: var(--white);
            text-decoration: none;
            padding: 1.2rem 2.4rem;
            border-radius: 50px;
            font-weight: bold;
            font-size: 1.2rem;
            text-transform: uppercase;
            margin-top: 2rem;
            border: 3px solid var(--secondary-light);
            transition: all 0.3s ease;
        }

        .cta-button:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
            background: var(--primary);
            border-color: var(--white);
        }

        /* Features Section */
        .features {
            background: #fff;
            padding: 6rem 0;
        }

        .section-header {
            text-align: center;
            margin-bottom: 4rem;
        }

        .section-title {
            font-family: 'Bebas Neue', sans-serif;
            font-size: 3.5rem;
            color: var(--primary);
            margin-bottom: 1rem;
        }

        .section-divider {
            width: 100px;
            height: 4px;
            background: var(--primary);
            margin: 1rem auto;
        }

        .section-subtitle {
            font-size: 1.2rem;
            color: #666;
            max-width: 600px;
            margin: 0 auto;
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 2rem;
        }

        .feature-card {
            background: #fff;
            padding: 2.5rem;
            border-radius: 15px;
            text-align: center;
            transition: all 0.3s ease;
            border: 2px solid #f0f0f0;
        }

        .feature-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.1);
            border-color: var(--primary);
        }

        .feature-icon i {
            color: var(--primary);
        }
        .badge-icon i {
            font-size: 1.5rem;
            color: #fff;
            line-height: 1.5;
        }

        .contact-info i {
            margin-right: 0.8rem;
            color: currentColor;
            width: 20px;
        }

        .social-link i {
            font-size: 1.2rem;
        }


        .feature-card h3 {
            color: var(--primary);
            font-size: 1.5rem;
            margin-bottom: 1rem;
            font-family: 'Bebas Neue', sans-serif;
        }

        .feature-card p {
            color: #666;
            font-size: 1.1rem;
            line-height: 1.6;
        }

        @keyframes fadeInDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @media (max-width: 768px) {
            .hero-title {
                font-size: 3.5rem;
            }
            .hero-subtitle {
                font-size: 1.5rem;
            }
            .features {
                padding: 4rem 0;
            }
            .section-title {
                font-size: 2.5rem;
            }
            .features-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>

    <!-- Hero Section -->
    <section class="hero">
        <div class="container">
            <div class="hero-content">

                <div class="hero-logo">
                    {{-- <img src="{{asset('themes/eshoper/images/home/hero.webp')}}" style="width: 100%" alt="ScalifyPro Logo"> --}}
                </div>

                <h1 class="hero-title">Scale Your Business with Next-Gen Affiliate Marketing</h1>
                <p class="hero-subtitle">We help publishers turn their traffic into real profits.</p>

                <a href="{{route('signup')}}" class="cta-button">Get Started Now</a>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title">Why Choose ScalifyPro</h2>
                <div class="section-divider"></div>
                <p class="section-subtitle">Discover the advantages that make ScalifyPro the ideal choice for modern publishers.</p>
            </div>

            <div class="features-grid">

                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fa fa-rocket fa-2x"></i>
                    </div>
                    <h3>High-Converting Offers</h3>
                    <p>Access exclusive, high-performance campaigns, selected to maximize your earning potential.</p>
                </div>

                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fa fa-user fa-2x"></i>
                    </div>
                    <h3>Strategic Support</h3>
                    <p>A team of experts by your side and a community to connect and grow with us.</p>
                </div>

                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fa fa-cog fa-2x"></i>
                    </div>
                    <h3>Advanced Technology</h3>
                    <p>An intuitive platform, precise real-time tracking, and cutting-edge tools to optimize your performance.</p>
                </div>
            </div>
        </div>
    </section>
    <!-- How It Works Section -->
    <section class="how-it-works" style="background: #f8f9fa;">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title">How It Works</h2>
                <div class="section-divider"></div>
                <p class="section-subtitle">Getting started with ScalifyPro is simple and fast.</p>
            </div>

            <div class="steps-grid">
                <div class="step-card">
                    <div class="step-number">1</div>
                    <div class="step-content">
                        <h3>Sign Up</h3>
                        <p>Complete the registration and, upon approval, get immediate access to our platform.</p>
                    </div>
                </div>

                <div class="step-card">
                    <div class="step-number">2</div>
                    <div class="step-content">
                        <h3>Choose Offers</h3>
                        <p>Browse our catalog of campaigns and select the ones that best suit your audience.</p>
                    </div>
                </div>

                <div class="step-card">
                    <div class="step-number">3</div>
                    <div class="step-content">
                        <h3>Promote</h3>
                        <p>Use our links and marketing materials to promote offers on your channels.</p>
                    </div>
                </div>

                <div class="step-card">
                    <div class="step-number">4</div>
                    <div class="step-content">
                        <h3>Earn</h3>
                        <p>Receive timely and transparent payments for every conversion you generate.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <style>
        /* How It Works Section */
        .how-it-works {
            background: #fff;
            padding: 6rem 0;
        }

        .steps-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 2rem;
            margin-top: 3rem;
        }

        .step-card {
            display: flex;
            align-items: flex-start;
            padding: 2rem;
            background: #fff;
            border-radius: 15px;
            border: 2px solid #f0f0f0;
            transition: all 0.3s ease;
        }

        .step-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.1);
            border-color: var(--primary);
        }

        .step-number {
            background: var(--primary);
            color: #fff;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            font-weight: bold;
            margin-right: 1.5rem;
            flex-shrink: 0;
        }

        .step-content h3 {
            color: var(--primary);
            font-family: 'Bebas Neue', sans-serif;
            font-size: 1.5rem;
            margin-bottom: 0.5rem;
        }

        .step-content p {
            color: #666;
            font-size: 1rem;
            line-height: 1.6;
            margin: 0;
        }

        @media (max-width: 768px) {
            .how-it-works {
                padding: 4rem 0;
            }

            .step-card {
                padding: 1.5rem;
            }
        }
    </style>
    <!-- FAQ Section -->
    <section class="faq">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title">Frequently Asked Questions</h2>
                <div class="section-divider"></div>
                <p class="section-subtitle">Everything you need to know to get started with ScalifyPro.</p>
            </div>

            <div class="faq-grid">
                <div class="faq-item">
                    <div class="faq-question">
                        <h3>How do I get started with ScalifyPro?</h3>
                        <span class="faq-icon">+</span>
                    </div>
                    <div class="faq-answer">
                        <p>Applications to ScalifyPro are manually reviewed to ensure network quality. A brief verification may be required. Once approved, you'll get full access to all our offers.</p>
                    </div>
                </div>

                <div class="faq-item">
                    <div class="faq-question">
                        <h3>When and how are payments processed?</h3>
                        <span class="faq-icon">+</span>
                    </div>
                    <div class="faq-answer">
                        <p>Payments for validated conversions are processed weekly. We support various payment methods, including Wire Transfer and PayPal, with a minimum threshold of $50.</p>
                    </div>
                </div>

                <div class="faq-item">
                    <div class="faq-question">
                        <h3>What kind of support do you offer?</h3>
                        <span class="faq-icon">+</span>
                    </div>
                    <div class="faq-answer">
                        <p>We offer comprehensive support through our dedicated affiliate managers, a private Telegram community, and training materials to help you optimize your campaigns.</p>
                    </div>
                </div>

                <div class="faq-item">
                    <div class="faq-question">
                        <h3>What are the requirements to become a publisher?</h3>
                        <span class="faq-icon">+</span>
                    </div>
                    <div class="faq-answer">
                        <p>We look for partners with a quality website, blog, or social media presence and a basic understanding of digital marketing. We do not require minimum traffic volumes to get started.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Final CTA Section -->
    <section class="final-cta">
        <div class="container">
            <div class="cta-content">
                <h2>Ready to Scale Your Success?</h2>
                <p>Join the publishers who are building the future with ScalifyPro.</p>
                <div class="cta-buttons">
                    <a href="{{route('signup')}}" class="cta-button primary">Become a Publisher</a>
                    <a href="mailto:info@scalifypro.net" class="cta-button secondary">Contact Us</a>
                </div>
                <div class="trust-badges">
                    <div class="badge">
                        <div class="badge-icon">
                            <i class="fa fa-shield"></i>
                        </div>
                        <span>Timely Payments</span>
                    </div>
                    <div class="badge">
                        <div class="badge-icon">
                            <i class="fa fa-user"></i>
                        </div>
                        <span>Dedicated Support</span>
                    </div>
                    <div class="badge">
                        <div class="badge-icon">
                            <i class="fa fa-lock"></i>
                        </div>
                        <span>Secure Platform</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <style>
        /* FAQ Section */
        .faq {
            background: #fff;
            padding: 6rem 0;
        }

        .faq-grid {
            max-width: 800px;
            margin: 3rem auto 0;
        }

        .faq-item {
            background: #fff;
            border: 2px solid #f0f0f0;
            border-radius: 15px;
            margin-bottom: 1rem;
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .faq-item:hover {
            border-color: var(--primary);
        }

        .faq-question {
            padding: 1.5rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .faq-question h3 {
            font-family: 'Bebas Neue', sans-serif;
            color: var(--primary);
            font-size: 1.3rem;
            margin: 0;
        }

        .faq-icon {
            color: var(--primary);
            font-size: 1.5rem;
            font-weight: bold;
            transition: all 0.3s ease;
        }

        .faq-answer {
            padding: 0 1.5rem 1.5rem;
            color: #666;
            line-height: 1.6;
            display: none;
        }

        .faq-item.active .faq-question {
            background: #f8f9fa;
        }

        .faq-item.active .faq-icon {
            transform: rotate(45deg);
        }

        .faq-item.active .faq-answer {
            display: block;
        }

        /* Final CTA Section */
        .final-cta {
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            padding: 6rem 0;
            position: relative;
            color: #fff;
            text-align: center;
        }

        .final-cta::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.05'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
            opacity: 0.1;
        }

        .cta-content {
            position: relative;
            z-index: 1;
        }

        .cta-content h2 {
            font-family: 'Bebas Neue', sans-serif;
            font-size: 3.5rem;
            margin-bottom: 1rem;
        }

        .cta-content p {
            font-size: 1.2rem;
            margin-bottom: 2rem;
            opacity: 0.9;
        }

        .cta-buttons {
            margin-bottom: 3rem;
        }

        .cta-buttons .cta-button.primary {
            background: var(--white);
            color: var(--primary);
            border-color: var(--white);
        }

        .cta-buttons .cta-button.primary:hover {
            background: var(--secondary-light);
            border-color: var(--secondary-light);
        }

        .cta-button.secondary {
            background: transparent;
            border: 3px solid #fff;
            margin-left: 1rem;
        }

        .cta-button.secondary:hover {
            background: var(--white);
            color: var(--primary);
        }

        .trust-badges {
            display: flex;
            justify-content: center;
            gap: 2rem;
            margin-top: 3rem;
        }

        .badge {
            display: flex;
            align-items: center;
            background: rgba(255, 255, 255, 0.1);
            padding: 0.8rem 1.5rem;
            border-radius: 50px;
            backdrop-filter: blur(10px);
        }

        .badge-icon {
            width: 40px;
            height: 40px;
            margin-right: 1rem;
        }

        .badge span {
            font-size: 0.9rem;
            white-space: nowrap;
        }

        @media (max-width: 768px) {
            .faq, .final-cta {
                padding: 4rem 0;
            }

            .cta-content h2 {
                font-size: 2.5rem;
            }

            .trust-badges {
                flex-direction: column;
                align-items: center;
                gap: 1rem;
            }

            .cta-buttons {
                display: flex;
                flex-direction: column;
                gap: 1rem;
            }

            .cta-button.secondary {
                margin-left: 0;
            }
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // FAQ Toggle
            const faqItems = document.querySelectorAll('.faq-item');

            faqItems.forEach(item => {
                const question = item.querySelector('.faq-question');

                question.addEventListener('click', () => {
                    // Close other items
                    faqItems.forEach(otherItem => {
                        if (otherItem !== item) {
                            otherItem.classList.remove('active');
                        }
                    });

                    // Toggle current item
                    item.classList.toggle('active');
                });
            });
        });
    </script>


    <style>
        /* Footer Styles */
        .footer {
            background: var(--primary-dark);
            color: #fff;
        }

        .footer-main {
            padding: 5rem 0 3rem;
        }

        .footer-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 3rem;
        }

        .footer-col h3 {
            font-family: 'Bebas Neue', sans-serif;
            font-size: 1.5rem;
            margin-bottom: 1.5rem;
            color: var(--white);
        }

        .company-description {
            margin: 1.5rem 0;
            line-height: 1.6;
            opacity: 0.9;
        }

        .social-links {
            display: flex;
            gap: 1rem;
        }

        .social-link {
            color: #fff;
            opacity: 0.8;
            transition: all 0.3s ease;
        }

        .social-link:hover {
            opacity: 1;
            transform: translateY(-3px);
        }

        .footer-links {
            list-style: none;
            padding: 0;
        }

        .footer-links li {
            margin-bottom: 1rem;
        }

        .footer-links a {
            color: #fff;
            text-decoration: none;
            opacity: 0.8;
            transition: all 0.3s ease;
        }

        .footer-links a:hover {
            opacity: 1;
            padding-left: 5px;
        }

        .contact-info {
            list-style: none;
            padding: 0;
        }

        .contact-info li {
            display: flex;
            align-items: flex-start;
            margin-bottom: 1rem;
            opacity: 0.8;
        }

        .contact-info svg {
            margin-right: 0.8rem;
            margin-top: 3px;
            flex-shrink: 0;
        }

        .footer-bottom {
            background: rgba(0, 0, 0, 0.2);
            padding: 1.5rem 0;
        }

        .footer-bottom-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .copyright {
            opacity: 0.8;
            font-size: 0.9rem;
        }

        @media (max-width: 768px) {
            .footer-main {
                padding: 3rem 0 2rem;
            }

            .footer-grid {
                gap: 2rem;
            }

            .footer-bottom-content {
                flex-direction: column;
                text-align: center;
                gap: 1rem;
            }
        }
    </style>
@endsection
