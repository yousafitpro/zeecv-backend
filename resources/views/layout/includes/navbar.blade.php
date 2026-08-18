<style>
  /* Navigation Container Styles */
  .custom-navbar {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(10px);
    padding: 1rem 0;
    transition: all 0.3s ease;
  }

  .brand-logo {
    max-height: 60px;
    width: auto;
    transition: transform 0.2s ease;
  }

  .brand-logo:hover {
    transform: scale(1.03);
  }

  /* Nav Links Styling */
  .custom-navbar .nav-link {
    font-family: 'Plus Jakarta Sans', sans-serif;
    color: #475569 !important;
    font-weight: 500;
    font-size: 1.1rem;
    padding: 0.5rem 1rem !important;
    transition: color 0.2s ease, transform 0.2s ease;
  }

  .custom-navbar .nav-link:hover {
    color: #2563eb !important;
  }

  /* Buttons Styling */
  .btn-nav-outline {
    border: 1.5px solid #2563eb;
    background: transparent;
    color: #2563eb;
    font-weight: 600;
    font-size: 1rem;
    padding: 0.55rem 1.6rem;
    border-radius: 10px;
    transition: all 0.25s ease;
    display: inline-block;
    text-align: center;
  }

  .btn-nav-outline:hover {
    background: rgba(37, 99, 235, 0.08);
    color: #1d4ed8;
    text-decoration: none;
    border-color: #1d4ed8;
  }

  .btn-nav-primary {
    background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
    color: #ffffff !important;
    font-weight: 600;
    font-size: 1rem;
    padding: 0.55rem 1.6rem;
    border-radius: 10px;
    border: none;
    box-shadow: 0 4px 14px rgba(37, 99, 235, 0.35);
    transition: all 0.25s ease;
    display: inline-block;
    text-align: center;
  }

  .btn-nav-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 22px rgba(37, 99, 235, 0.45);
    color: #ffffff;
    text-decoration: none;
  }

  /* Mobile Toggler & Collapsible Menu Styling */
  .custom-navbar .navbar-toggler {
    border: none;
    padding: 0.4rem 0.6rem;
  }

  .custom-navbar .navbar-toggler:focus {
    outline: none;
    box-shadow: none;
  }

  /* =============================================
     USER AVATAR DROPDOWN
  ============================================= */
  .user-avatar-wrapper {
    display: flex;
    align-items: center;
    gap: 8px;
    cursor: pointer;
    padding: 4px 8px 4px 4px;
    border-radius: 40px;
    transition: all 0.2s ease;
    border: 2px solid transparent;
    text-decoration: none;
  }

  .user-avatar-wrapper:hover {
    border-color: #2563eb;
    background: rgba(37, 99, 235, 0.05);
    text-decoration: none;
  }

  .user-avatar {
    width: 38px;
    height: 38px;
    border-radius: 50%;
    object-fit: cover;
    border: 2px solid #e2e8f0;
    transition: border-color 0.2s ease;
    background: #f1f5f9;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 600;
    color: #475569;
    font-size: 14px;
  }

  .user-avatar-wrapper:hover .user-avatar {
    border-color: #2563eb;
  }

  .user-name {
    font-size: 14px;
    font-weight: 600;
    color: #1e293b;
    max-width: 120px;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
  }

  .user-dropdown-arrow {
    color: #94a3b8;
    font-size: 12px;
    transition: transform 0.2s ease;
  }

  .user-avatar-wrapper[aria-expanded="true"] .user-dropdown-arrow {
    transform: rotate(180deg);
  }

  /* =============================================
     USER DROPDOWN MENU
  ============================================= */
  .user-dropdown-menu {
    min-width: 240px;
    padding: 8px;
    margin-top: 12px;
    border: 1px solid #e5e7eb;
    border-radius: 14px;
    background: #ffffff;
    box-shadow: 0 15px 40px rgba(15, 23, 42, 0.12);
    right: 0;
    left: auto;
  }

  .user-dropdown-menu .dropdown-header {
    padding: 10px 12px 6px;
    border-bottom: 1px solid #f1f5f9;
    margin-bottom: 4px;
  }

  .user-dropdown-menu .dropdown-header .user-email {
    font-size: 12px;
    color: #94a3b8;
    word-break: break-all;
  }

  .user-dropdown-menu .dropdown-item {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 10px 12px;
    border-radius: 10px;
    color: #334155;
    font-size: 14px;
    font-weight: 500;
    transition: all 0.2s ease;
  }

  .user-dropdown-menu .dropdown-item i {
    width: 20px;
    color: #94a3b8;
    font-size: 15px;
    transition: color 0.2s ease;
  }

  .user-dropdown-menu .dropdown-item:hover {
    background: #f8fafc;
    color: #2563eb;
  }

  .user-dropdown-menu .dropdown-item:hover i {
    color: #2563eb;
  }

  .user-dropdown-menu .dropdown-divider {
    margin: 4px 0;
    border-color: #f1f5f9;
  }

  .user-dropdown-menu .dropdown-item.text-danger {
    color: #ef4444 !important;
  }

  .user-dropdown-menu .dropdown-item.text-danger:hover {
    background: #fef2f2;
    color: #dc2626 !important;
  }

  .user-dropdown-menu .dropdown-item.text-danger:hover i {
    color: #dc2626 !important;
  }

  /* =============================================
     RESUME DROPDOWN
  ============================================= */
  .custom-navbar .resume-dropdown {
    min-width: 280px;
    padding: 8px;
    margin-top: 12px;
    border: 1px solid #e5e7eb;
    border-radius: 14px;
    background: #ffffff;
    box-shadow: 0 15px 40px rgba(15, 23, 42, 0.12);
  }

  .custom-navbar .resume-dropdown .dropdown-item {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 12px;
    border-radius: 10px;
    color: #334155;
    white-space: normal;
    transition: all 0.2s ease;
  }

  .custom-navbar .resume-dropdown .dropdown-item:hover {
    background: #f8fafc;
    color: #2563eb;
  }

  .resume-menu-icon {
    width: 40px;
    height: 40px;
    min-width: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 10px;
    background: #eff6ff;
    color: #2563eb;
    font-size: 17px;
  }

  .resume-dropdown .dropdown-item strong {
    display: block;
    font-size: 15px;
    font-weight: 600;
    color: #1e293b;
    line-height: 1.3;
  }

  .resume-dropdown .dropdown-item small {
    display: block;
    margin-top: 3px;
    color: #64748b;
    font-size: 12px;
    line-height: 1.3;
  }

  .resume-dropdown .dropdown-item:hover strong {
    color: #2563eb;
  }

  .custom-navbar .dropdown-toggle::after {
    margin-left: 6px;
    vertical-align: middle;
  }

  /* =============================================
     MOBILE RESPONSIVE
  ============================================= */
  @media (max-width: 991.98px) {
    .custom-navbar .navbar-collapse {
      background: #ffffff;
      padding: 1.5rem;
      border-radius: 12px;
      margin-top: 1rem;
      box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
    }

    .navbar-toggler {
      zoom: 1.5;
    }

    .navbar-brand {
      margin-left: 20px;
    }

    .custom-navbar .nav-item a {
      font-family: 'Plus Jakarta Sans', sans-serif;
      font-size: 20px !important;
    }

    .custom-navbar .resume-dropdown {
      min-width: 100%;
      margin-top: 5px;
      border: none;
      box-shadow: none;
      background: #f8fafc;
    }

    .custom-navbar .resume-dropdown .dropdown-item {
      padding: 12px 10px;
    }

    /* User dropdown on mobile */
    .user-dropdown-menu {
      min-width: 100%;
      margin-top: 5px;
      border: none;
      box-shadow: none;
      background: #f8fafc;
      padding: 4px 0;
    }

    .user-dropdown-menu .dropdown-item {
      padding: 10px 8px;
    }

    .user-avatar-wrapper {
      padding: 8px 12px;
      border-radius: 12px;
      background: #f8fafc;
      width: 100%;
      justify-content: flex-start;
    }

    .user-name {
      font-size: 16px;
      max-width: none;
    }

    .user-dropdown-arrow {
      margin-left: auto;
    }
  }

  @media (max-width: 480px) {
    .custom-navbar {
      padding: 0.5rem 0;
    }

    .brand-logo {
      max-height: 40px;
    }

    .navbar-brand {
      margin-left: 10px;
    }

    .user-avatar {
      width: 32px;
      height: 32px;
      font-size: 12px;
    }

    .user-name {
      font-size: 14px;
    }
  }
</style>

<!-- =============================================
     COOKIE CONSENT
============================================= -->
<div id="zeecv_cookie_consent" class="zeecv_cookie_consent">
    <div class="zeecv_cookie_inner">
        <div class="zeecv_cookie_text">
            We use cookies to improve your experience, analyze traffic,
            and provide better services.
            <a href="{{ url('page-view/cookie-policy') }}" target="_blank">
                Privacy Policy
            </a>
        </div>
        <div class="zeecv_cookie_actions">
            <button type="button" id="zeecv_cookie_reject" class="zeecv_cookie_btn zeecv_cookie_reject">
                Reject
            </button>
            <button type="button" id="zeecv_cookie_accept" class="zeecv_cookie_btn zeecv_cookie_accept">
                Accept
            </button>
        </div>
    </div>
</div>

<style>
/* =========================================
   Cookie Consent
========================================= */
.zeecv_cookie_consent {
    position: fixed;
    left: 0;
    right: 0;
    bottom: 0;
    height: 40px;
    background: #0f172a;
    color: #ffffff;
    z-index: 999999;
    display: none;
    box-shadow: 0 -2px 10px rgba(0, 0, 0, 0.15);
    font-family: Inter, Arial, sans-serif;
}

.zeecv_cookie_inner {
    width: 100%;
    max-width: 1200px;
    height: 100%;
    margin: 0 auto;
    padding: 0 20px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 20px;
    box-sizing: border-box;
}

.zeecv_cookie_text {
    font-size: 12px;
    color: #cbd5e1;
    line-height: 1.4;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.zeecv_cookie_text a {
    color: #60a5fa;
    text-decoration: none;
    margin-left: 5px;
}

.zeecv_cookie_text a:hover {
    color: #93c5fd;
    text-decoration: underline;
}

.zeecv_cookie_actions {
    display: flex;
    align-items: center;
    gap: 8px;
    flex-shrink: 0;
}

.zeecv_cookie_btn {
    height: 28px;
    padding: 0 13px;
    border-radius: 5px;
    font-family: inherit;
    font-size: 12px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s ease;
}

.zeecv_cookie_reject {
    background: transparent;
    border: 1px solid #475569;
    color: #cbd5e1;
}

.zeecv_cookie_reject:hover {
    background: #1e293b;
    border-color: #64748b;
    color: #ffffff;
}

.zeecv_cookie_accept {
    background: #2563eb;
    border: 1px solid #2563eb;
    color: #ffffff;
}

.zeecv_cookie_accept:hover {
    background: #1d4ed8;
    border-color: #1d4ed8;
}

@media (max-width: 700px) {
    .zeecv_cookie_consent {
        height: auto;
        min-height: 40px;
    }
    .zeecv_cookie_inner {
        padding: 7px 12px;
        gap: 10px;
    }
    .zeecv_cookie_text {
        white-space: normal;
        font-size: 11px;
        line-height: 1.4;
    }
    .zeecv_cookie_actions {
        gap: 5px;
    }
    .zeecv_cookie_btn {
        height: 27px;
        padding: 0 10px;
        font-size: 11px;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const cookieBanner = document.getElementById('zeecv_cookie_consent');
    const acceptButton = document.getElementById('zeecv_cookie_accept');
    const rejectButton = document.getElementById('zeecv_cookie_reject');

    const consent = localStorage.getItem('zeecv_cookie_consent');

    if (consent === null) {
        cookieBanner.style.display = 'block';
    }

    acceptButton.addEventListener('click', function () {
        localStorage.setItem('zeecv_cookie_consent', 'accepted');
        cookieBanner.style.display = 'none';
    });

    rejectButton.addEventListener('click', function () {
        localStorage.setItem('zeecv_cookie_consent', 'rejected');
        cookieBanner.style.display = 'none';
    });
});
</script>

<!-- =============================================
     NAVIGATION
============================================= -->
<nav class="navbar navbar-expand-lg custom-navbar fixed-top">
  <div class="container">
    <!-- Brand Logo -->
    <a class="navbar-brand py-0" href="{{ url('/') }}">
      <img src="{{ asset('app-icons/logo.png') }}" class="brand-logo" alt="ZeeCV Logo">
    </a>

    <!-- Mobile Toggler Button -->
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#mainNavbar" 
            aria-controls="mainNavbar" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon d-flex align-items-center justify-content-center">
        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#1e293b" stroke-width="2">
          <path d="M4 6h16M4 12h16M4 18h16"/>
        </svg>
      </span>
    </button>

    <!-- Navbar Links & Buttons -->
    <div class="collapse navbar-collapse" id="mainNavbar">
      <ul class="navbar-nav ml-auto align-items-lg-center">
        
        <li class="nav-item">
          <a class="nav-link" href="{{ route('home.post_a_job') }}">Post a job</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{ route('home.jobs') }}">Jobs</a>
        </li>
        @if(!auth()->check())
        <li class="nav-item">
          <a class="nav-link" href="{{ route('home.about') }}">About</a>
        </li>
        
        <li class="nav-item">
          <a class="nav-link" href="{{ route('pages.page.blogs.list') }}">Blog</a>
        </li>
        @endif

        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="resumeDropdown" role="button" 
             data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Resume
          </a>
          <div class="dropdown-menu dropdown-menu-right resume-dropdown" aria-labelledby="resumeDropdown">
            <a class="dropdown-item" href="{{ route('home.about') }}">
              <span class="resume-menu-icon">
                <i class="fas fa-file-alt"></i>
              </span>
              <span>
                <strong>Resume Creator</strong>
                <small>Create a professional resume</small>
              </span>
            </a>
            <a class="dropdown-item" href="{{ route('home.templates') }}">
              <span class="resume-menu-icon">
                <i class="fas fa-layer-group"></i>
              </span>
              <span>
                <strong>Templates</strong>
                <small>Choose your resume template</small>
              </span>
            </a>
            <a class="dropdown-item" href="{{ route('home.features') }}">
              <span class="resume-menu-icon">
                <i class="fas fa-star"></i>
              </span>
              <span>
                <strong>Features</strong>
                <small>All options available</small>
              </span>
            </a>
          </div>
        </li>

        @if(auth()->check())
          <!-- =============================================
               USER DROPDOWN (LOGGED IN)
          ============================================== -->
          <li class="nav-item dropdown">
            <a class="user-avatar-wrapper " href="#" id="userDropdown" 
               role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <span class="user-avatar">
                @if(auth()->user()->avatar)
                  <img src="{{ auth()->user()->avatar() }}" alt="Avatar" style="width:100%;height:100%;border-radius:50%;object-fit:cover;">
                @else
                  {{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 1)) }}
                @endif
              </span>
              <span class="user-name">{{ auth()->user()->name ?? 'User' }}</span>
              <i class="fas fa-chevron-down user-dropdown-arrow"></i>
            </a>

            <div class="dropdown-menu dropdown-menu-right user-dropdown-menu" aria-labelledby="userDropdown">
              <div class="dropdown-header">
                <div style="font-weight:600;color:#1e293b;font-size:14px;">
                  {{ auth()->user()->name ?? 'User' }}
                </div>
                <div class="user-email">{{ auth()->user()->email ?? '' }}</div>
              </div>

           

              <a class="dropdown-item" href="{{ route('home.user.profile') }}">
                <i class="fas fa-user-circle"></i>
                My Profile
              </a>

              {{-- <a class="dropdown-item" href="">
                <i class="fas fa-briefcase"></i>
                My Jobs
              </a>
              --}}

              <a class="dropdown-item" href="{{ route('home.user.resumes') }}">
                <i class="fas fa-file-alt"></i>
                My Resumes
              </a> 
              <div class="dropdown-divider"></div>

              <a class="dropdown-item text-danger" href="{{url('logout')}}" 
                 onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="fas fa-sign-out-alt"></i>
                Logout
              </a>

              <form id="logout-form" action="{{url('logout')}}" method="POST" style="display: none;">
                @csrf
              </form>
            </div>
          </li>
        @else
          <!-- =============================================
               ACTION BUTTONS (LOGGED OUT)
          ============================================== -->
          <li class="nav-item my-2 my-lg-0 ml-lg-3">
            <a href="{{ url('login') }}" class="btn-nav-outline w-100">Log in</a>
          </li>
          <li class="nav-item my-2 my-lg-0 ml-lg-2">
            <a href="{{ url('signup') }}" class="btn-nav-primary w-100">Sign up</a>
          </li>
        @endif

      </ul>
    </div>
  </div>
</nav>