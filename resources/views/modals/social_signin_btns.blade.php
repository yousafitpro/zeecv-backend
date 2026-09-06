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
    .social-btns .linkedin-btn {
      cursor: pointer;
      border: 1px solid #e2e8f0;
      background: white !important;
      padding: 5px 10px;
      border-radius: 5px;
    
      //asdasd
    }
    .social-btns .linkedin-btn a{
      text-decoration: none;
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
    .social-btns img{
      width: 30px;
    }

        </style>
        <div class="row social-btns">
            <div class="col-md-6">
                <div class="social-login" >
                   <div id="g_id_onload"
    data-client_id="{{ config('services.google.client_id') }}"
    data-callback="handleGoogleResponse"
    data-context="signin"
    data-auto_select="false">
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
                <div class="social-btn linkedin-btn">
                  <a href="{{ route('linkedin.auth') }}">
              <img src="{{ asset('assets/icons/linkedin.png') }}" > Linkedin
            </a>
                </div>
            </div>
        </div>
      

