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
    .s-item-outer{
       position: relative;
      display: flex;
      justify-content: center;
      align-items: center;
      gap: 10px; /* spacing between boxes */
    }
    .s-item-outer .s-item{
      display:flex;
      justify-content: center;
      align-items: center;
      background:rgb(230, 230, 230);
     
      padding: 5px;
      border-radius: 10px;
    }
    .s-item-outer .s-item img{
      border-radius: 10px;
    }

        </style>
        <div class="s-item-outer social-btns">
            <div class="s-item">
              <div class=" google-overlay-btn"
                  style="position: relative; overflow: hidden;">
                <a href="javascript:void(0)">
                  <img src="{{ asset('assets/icons/google.png') }}">
                </a>

                {{-- Invisible GSI button capturing clicks --}}
                <div style="position:absolute; inset:0; opacity:0.001; z-index:2; overflow:hidden;">
                  <div id="g_id_onload"
                      data-client_id="{{ config('services.google.client_id') }}"
                      data-callback="handleGoogleResponse"
                      data-context="signin"
                      data-auto_select="false"></div>
                  <div class="g_id_signin"
                      data-type="standard"
                      data-size="large"
                      data-theme="outline"
                      data-text="signin_with"
                      data-shape="rectangular"
                      data-logo_alignment="left"
                      data-width="300"></div>
                </div>
              </div>
            </div>

    
            <div class="s-item">
                <div class="" onclick="redirectMeToUrl('{{ route('linkedin.auth') }}')">
                  <a href="javascript:void">
              <img src="{{ asset('assets/icons/linkedin.png') }}" >
            </a>
                </div>
            </div>
            <div class="s-item">
                <div class="" onclick="redirectMeToUrl('{{ route('facebook.auth') }}')">
                  <a href="javascript:void">
              <img src="{{ asset('assets/icons/facebook.png') }}" >
            </a>
                </div>
            </div>
        </div>
      

