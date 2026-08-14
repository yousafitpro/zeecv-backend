<footer class="zeecv_footer">
    <div class="zeecv_footer_container">

        <!-- Main Footer -->
        <div class="zeecv_footer_main">

            <!-- Brand -->
            <div class="zeecv_footer_brand">
                <a href="{{ url('/') }}" class="zeecv_footer_logo">
                    <span class="zeecv_logo_mark">Z</span>
                    <span>ZeeCV</span>
                </a>

                <p class="zeecv_footer_description">
                    Create professional, ATS-friendly resumes and stand out
                    with confidence in your next career opportunity.
                </p>

                {{-- <div class="zeecv_footer_social">
                    <a href="#" aria-label="LinkedIn">
                        <i class="fab fa-linkedin-in"></i>
                    </a>

                    <a href="#" aria-label="Facebook">
                        <i class="fab fa-facebook-f"></i>
                    </a>

                    <a href="#" aria-label="Instagram">
                        <i class="fab fa-instagram"></i>
                    </a>

                    <a href="#" aria-label="X">
                        <i class="fab fa-x-twitter"></i>
                    </a>
                </div> --}}
            </div>


            <!-- Product -->
            <div class="zeecv_footer_column">
                <h4>Product</h4>

                <ul>
                    <li>
                        <a href="{{ url('/') }}">
                            Resume Builder
                        </a>
                    </li>

                    {{-- <li>
                        <a href="{{ url('/ai-resume') }}">
                            AI Resume
                        </a>
                    </li> --}}

                    <li>
                        <a href="{{ route('home.templates') }}">
                            Resume Templates
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('home.jobs') }}">
                            Find Jobs
                        </a>
                    </li>
                </ul>
            </div>


            <!-- Resources -->
            <div class="zeecv_footer_column">
                <h4>Resources</h4>

                <ul>
                    <li>
                        <a href="{{ url('/jobs') }}">
                            Career Blog
                        </a>
                    </li>

                    {{-- <li>
                        <a href="{{ url('/resume-tips') }}">
                            Resume Tips
                        </a>
                    </li> --}}

                    {{-- <li>
                        <a href="{{ url('/faq') }}">
                            FAQs
                        </a>
                    </li> --}}

                    {{-- <li>
                        <a href="{{ url('/contact') }}">
                            Contact Us
                        </a>
                    </li> --}}
                </ul>
            </div>


            <!-- Company -->
            <div class="zeecv_footer_column">
                <h4>Company</h4>

                <ul>
                    <li>
                        <a href="{{ url('/about') }}">
                            About ZeeCV
                        </a>
                    </li>

                    <li>
                        <a href="{{ url('page-view/privacy-policy') }}">
                            Privacy Policy
                        </a>
                    </li>

                    <li>
                        <a href="{{ url('/terms') }}">
                            Terms & Conditions
                        </a>
                    </li>
                </ul>
            </div>

        </div>


        <!-- Footer Bottom -->
        <div class="zeecv_footer_bottom">

            <div class="zeecv_footer_copyright">
                © {{ date('Y') }} ZeeCV. All rights reserved.
            </div>

            <div class="zeecv_footer_bottom_links">
                <a href="{{ url('/privacy-policy') }}">
                    Privacy
                </a>

                <a href="{{ url('/terms') }}">
                    Terms
                </a>

                {{-- <a href="{{ url('/contact') }}">
                    Contact
                </a> --}}
            </div>

        </div>

    </div>
</footer>


<style>

.zeecv_footer {
    background: #0f172a;
    color: #ffffff;
    margin-top: 80px;
    font-family: Inter, Arial, sans-serif;
}

.zeecv_footer_container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 24px;
}


/* Main Footer */

.zeecv_footer_main {
    display: grid;
    grid-template-columns: 2fr 1fr 1fr 1fr;
    gap: 70px;
    padding: 70px 0 55px;
}


/* Brand */

.zeecv_footer_brand {
    max-width: 360px;
}

.zeecv_footer_logo {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    color: #ffffff;
    text-decoration: none;
    font-size: 25px;
    font-weight: 800;
    letter-spacing: -0.5px;
}

.zeecv_logo_mark {
    width: 38px;
    height: 38px;
    border-radius: 10px;
    background: #2563eb;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: 19px;
    font-weight: 800;
}

.zeecv_footer_description {
    color: #94a3b8;
    font-size: 14px;
    line-height: 1.8;
    margin: 20px 0 25px;
}


/* Social */

.zeecv_footer_social {
    display: flex;
    align-items: center;
    gap: 10px;
}

.zeecv_footer_social a {
    width: 38px;
    height: 38px;
    border: 1px solid #334155;
    border-radius: 9px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #cbd5e1;
    text-decoration: none;
    transition: all 0.2s ease;
}

.zeecv_footer_social a:hover {
    background: #2563eb;
    border-color: #2563eb;
    color: #ffffff;
    transform: translateY(-2px);
}


/* Columns */

.zeecv_footer_column h4 {
    margin: 3px 0 20px;
    color: #ffffff;
    font-size: 15px;
    font-weight: 700;
}

.zeecv_footer_column ul {
    list-style: none;
    margin: 0;
    padding: 0;
}

.zeecv_footer_column li {
    margin-bottom: 13px;
}

.zeecv_footer_column a {
    color: #94a3b8;
    text-decoration: none;
    font-size: 14px;
    transition: color 0.2s ease;
}

.zeecv_footer_column a:hover {
    color: #ffffff;
}


/* Bottom */

.zeecv_footer_bottom {
    border-top: 1px solid #1e293b;
    min-height: 70px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 20px;
}

.zeecv_footer_copyright {
    color: #64748b;
    font-size: 13px;
}

.zeecv_footer_bottom_links {
    display: flex;
    gap: 25px;
}

.zeecv_footer_bottom_links a {
    color: #64748b;
    font-size: 13px;
    text-decoration: none;
    transition: color 0.2s ease;
}

.zeecv_footer_bottom_links a:hover {
    color: #ffffff;
}


/* Tablet */

@media (max-width: 900px) {

    .zeecv_footer_main {
        grid-template-columns: 1.5fr 1fr 1fr;
        gap: 40px;
    }

    .zeecv_footer_brand {
        grid-column: span 3;
        max-width: 500px;
    }
}


/* Mobile */

@media (max-width: 600px) {

    .zeecv_footer {
        margin-top: 50px;
    }

    .zeecv_footer_main {
        grid-template-columns: 1fr 1fr;
        gap: 35px 25px;
        padding: 50px 0 35px;
    }

    .zeecv_footer_brand {
        grid-column: span 2;
    }

    .zeecv_footer_bottom {
        padding: 20px 0;
        flex-direction: column;
        align-items: flex-start;
    }

    .zeecv_footer_bottom_links {
        gap: 18px;
    }
}

</style>