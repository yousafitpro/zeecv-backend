          <div class="d-grid gap-3">
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
            <a href="{{ route('linkedin.auth') }}" class="social-btn facebook">
              <i class="fab fa-linkedin fa-lg"></i> Linkedin
            </a>
          </div>