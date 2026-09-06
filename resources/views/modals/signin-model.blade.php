    <!-- Custom CSS – scoped under .login_reg_modal -->
  <style>
    /* ----- UPPER CLASS: login_reg_modal ----- */
    .login_reg_modal .modal-content {
      border: none;
      border-radius: 16px;
      box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
    }

    .login_reg_modal .modal-body {
      padding: 2rem 2rem 1.8rem;
    }

    /* Close button (X) styling */
    .login_reg_modal .btn-close {
     border: none;
      position: absolute;
      top: 18px;
      right: 22px;
      background: none;
      font-size: 1.4rem;
      opacity: 0.5;
      transition: opacity 0.2s;
    }
    .login_reg_modal .btn-close:hover {
      opacity: 0.9;
    }

    /* Heading */
    .login_reg_modal .modal-title-custom {
      font-size: 1.8rem;
      font-weight: 700;
      margin-bottom: 1.5rem;
      letter-spacing: -0.3px;
    }

    /* Input field */
    .login_reg_modal .form-label {
      font-weight: 600;
      font-size: 0.95rem;
      color: #1e293b;
    }
    .login_reg_modal .form-control {
      border-radius: 10px;
      padding: 0.7rem 1rem;
      border: 1px solid #e2e8f0;
      background-color: #f8fafc;
      transition: border-color 0.2s, box-shadow 0.2s;
    }
    .login_reg_modal .form-control:focus {
      border-color: #4f46e5;
      box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.15);
      background-color: #ffffff;
    }

    /* Continue Button */
    .login_reg_modal .btn-primary {
      background-color: var(--primary);
      border: none;
      border-radius: 10px;
      padding: 0.75rem;
      font-weight: 600;
      font-size: 1.05rem;
      transition: background-color 0.2s, transform 0.1s;
    }
    .login_reg_modal .btn-primary:hover {
      background-color: #4338ca;
    }
    .login_reg_modal .btn-primary:active {
      transform: scale(0.98);
    }

    /* Divider with "or" */
    .login_reg_modal .divider-wrapper {
      display: flex;
      align-items: center;
      margin: 1.8rem 0;
    }
    .login_reg_modal .divider-wrapper hr {
      flex: 1;
      border: none;
      border-top: 1px solid #e2e8f0;
      margin: 0;
    }
    .login_reg_modal .divider-wrapper span {
      padding: 0 1rem;
      color: #94a3b8;
      font-weight: 500;
      font-size: 0.9rem;
      background-color: #ffffff;
      white-space: nowrap;
    }

    /* Social buttons */
    .login_reg_modal .social-btn {
      border-radius: 10px;
      padding: 0.7rem;
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

    /* Footer privacy text */
    .login_reg_modal .privacy-text {
      margin-top: 1.8rem;
      margin-bottom: 0;
      color: #94a3b8;
      font-size: 0.85rem;
      text-align: center;
      letter-spacing: 0.2px;
    }
    .login_reg_modal .privacy-text i {
      margin-right: 6px;
      font-size: 0.75rem;
    }
  </style>
  <!-- ============================================= -->
  <!-- ===== MODAL – scoped under login_reg_modal ===== -->
  <!-- ============================================= -->
  <div 
    class="login_reg_modal modal fade" 
    id="loginRegModal" 
    tabindex="-1" 
    aria-hidden="true"
  >
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">

        <!-- Modal Body -->
        <div class="modal-body">

          <!-- Close Button (X) -->
          <button 
            type="button" 
            class="btn-close" 
            data-dismiss="modal" 
            aria-label="Close"
          >
            <i class="fas fa-times"></i>
          </button>

          <!-- Heading -->
          <h2 class="modal-title-custom">Login / Register</h2>

          <form action="{{ route('signup') }}" method="get">
            <!-- Email Field -->
          <div class="mb-3">
            <label for="emailInput" class="form-label">Enter Email</label>
            <input 
              type="email" 
              name="email"
              class="form-control" 
              id="emailInput" 
              placeholder="Enter your Email ID"
            />
          </div>

          <!-- Continue Button -->
          <button type="submit" class="btn btn-primary w-100" style="background-color: var(--primary) !important">Continue</button>

          </form>
          <!-- Divider: "or" -->
          <div class="divider-wrapper">
            <hr />
            <span>or</span>
            <hr />
          </div>

          <!-- Social Buttons -->
          <div class="d-grid gap-3">
            <div class="social-login" style="margin-top: -20px;">
                    <div id="g_id_onload"
                        data-client_id="{{ config('services.google.client_id') }}"
                        data-callback="handleGoogleResponse">
                    </div>
                    <div class="g_id_signin-wrapper">
                        <div class="g_id_signin social-btn"
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
            {{-- <button class="social-btn google">
              <i class="fab fa-google fa-lg"></i> Google
            </button>
            <button class="social-btn facebook">
              <i class="fab fa-facebook fa-lg"></i> Facebook
            </button> --}}
          </div>

          <!-- Footer Text -->
          <p class="privacy-text">
            <i class="fas fa-lock"></i> All your activity will remain private
          </p>

        </div>
        <!-- /modal-body -->

      </div>
      <!-- /modal-content -->
    </div>
    <!-- /modal-dialog -->
  </div>
  <div 
    class="login_reg_modal modal fade" 
    id="loginModal" 
    tabindex="-1" 
    aria-hidden="true"
  >
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">

        <!-- Modal Body -->
        <div class="modal-body">

          <!-- Close Button (X) -->
          <button 
            type="button" 
            class="btn-close" 
            data-dismiss="modal" 
            aria-label="Close"
          >
            <i class="fas fa-times"></i>
          </button>

          <!-- Heading -->
          <h2 class="modal-title-custom">Login / Register</h2>

          <form action="{{ route('login') }}" method="get">
            <!-- Email Field -->
          <div class="mb-3">
            <label for="emailInput" class="form-label">Enter Email</label>
            <input 
              type="email" 
              name="email"
              class="form-control" 
              id="emailInput" 
              placeholder="Enter your Email ID"
            />
          </div>

          <!-- Continue Button -->
          <button type="submit" class="btn btn-primary w-100" style="background-color: var(--primary) !important">Continue</button>

          </form>
          <!-- Divider: "or" -->
          <div class="divider-wrapper">
            <hr />
            <span>or</span>
            <hr />
          </div>

          <!-- Social Buttons -->
         @include('modals.social_signin_btns')

          <!-- Footer Text -->
          <p class="privacy-text">
            <i class="fas fa-lock"></i> All your activity will remain private
          </p>

        </div>
        <!-- /modal-body -->

      </div>
      <!-- /modal-content -->
    </div>
    <!-- /modal-dialog -->
  </div>
  <!-- /modal -->