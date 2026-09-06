        <style>
                /* Social buttons */
    .login_reg_modal .social-btn {
      border-radius: 10px;
      /* padding: 0.7rem; */
      font-weight: 500;
      font-size: 1rem;
      /* border: 1px solid #e2e8f0; */
      background-color: #ffffff;
      transition: background-color 0.2s, border-color 0.2s;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 10px;
      width: 100%;
      color: #1e293b;
      text-decoration: none;
    }
    .login_reg_modal .linkedin-btn {
      border: 1px solid #e2e8f0;
      background: white;
      padding: 5px 10px;
    }
    .login_reg_modal .social-btn:hover {
      background-color: #f8fafc;
      border-color: #cbd5e1;
    }
    .login_reg_modal .social-btn.google i {
      color: #ea4335;
    }
    .login_reg_modal .social-btn.facebook i {
      color: #1877f2;
    }
        </style>
        <div class="row">
            <div class="col-md-6">
                <div class="social-login" style="margin-top: -20px;">
                    <div id="g_id_onload"
                        data-client_id="{{ config('services.google.client_id') }}"
                        data-callback="handleGoogleResponse">
                    </div>
                    <div class="g_id_signin-wrapper">
                        <div class="g_id_signin social-btn google"
                            data-type="standard"
                            data-size="large"
                            data-theme="outline"
                            data-text="signin_with"
                            data-shape="rectangular"
                            data-logo_alignment="left"
                            data-width="100%">
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <a href="{{ route('linkedin.auth') }}" class="social-btn linkedin-btn">
              <i class="fab fa-linkedin fa-lg"></i> Linkedin
            </a>
            </div>
        </div>
      

