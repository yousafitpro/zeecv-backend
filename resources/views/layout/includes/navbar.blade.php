<!-- Required Bootstrap 4 JavaScript Dependencies for Mobile Menu Toggle -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

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
    font-size: 1.1rem; /* Slightly reduced for better mobile fit */
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
/* Resume Dropdown */
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

/* Desktop dropdown arrow */
.custom-navbar .dropdown-toggle::after {
    margin-left: 6px;
    vertical-align: middle;
}

/* Mobile */
@media (max-width: 991.98px) {

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

}
  /* Mobile Dropdown Spacing */
  @media (max-width: 991.98px) {
    .custom-navbar .navbar-collapse {
      background: #ffffff;
      padding: 1.5rem;
      border-radius: 12px;
      margin-top: 1rem;
      box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
    }
    .navbar-toggler{
      zoom: 1.5;
    }
    .navbar-brand{
      margin-left: 20px;
    }
  }
   .custom-navbar .nav-item a{

    font-family: 'Plus Jakarta Sans', sans-serif;

    font-size: 20px !important;

 }
</style>

<nav class="navbar navbar-expand-lg custom-navbar fixed-top">
  <div class="container">
    <!-- Brand Logo -->
    <a class="navbar-brand py-0" href="{{ url('/') }}">
      <img src="{{ asset('app-icons/logo.png') }}" class="brand-logo" alt="ZeeCV Logo">
    </a>

    <!-- Mobile Toggler Button -->
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#mainNavbar" aria-controls="mainNavbar" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon d-flex align-items-center justify-content-center">
        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#1e293b" stroke-width="2"><path d="M4 6h16M4 12h16M4 18h16"/></svg>
      </span>
    </button>

    <!-- Navbar Links & Buttons -->
    <div class="collapse navbar-collapse" id="mainNavbar">
      <ul class="navbar-nav ml-auto align-items-lg-center">
  
        <li class="nav-item">
          <a class="nav-link" href="{{ route('home.about') }}">About</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{ route('home.jobs') }}">Jobs</a>
        </li>

        <li class="nav-item">
          <a class="nav-link" href="{{ route('pages.page.blogs.list') }}">Blog</a>
        </li>

        <li class="nav-item dropdown">
    <a class="nav-link dropdown-toggle"
       href="#"
       id="resumeDropdown"
       role="button"
       data-toggle="dropdown"
       aria-haspopup="true"
       aria-expanded="false">
        Resume
    </a>

    <div class="dropdown-menu dropdown-menu-right resume-dropdown"
         aria-labelledby="resumeDropdown">

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
                <i class="fas fa-layer-group"></i>
            </span>
            <span>
                <strong>Features</strong>
                <small>All options available</small>
            </span>
        </a>

    </div>
</li>
        {{-- <li class="nav-item">
          <a class="nav-link" href="{{ route('home.pricing') }}">Pricing</a>
        </li> --}}
        
        <!-- Action Buttons -->
        <li class="nav-item my-2 my-lg-0 ml-lg-3">
          <a href="{{ url('login') }}" class="btn-nav-outline w-100">Log in</a>
        </li>
        <li class="nav-item my-2 my-lg-0 ml-lg-2">
          <a href="{{ url('signup') }}" class="btn-nav-primary w-100">Create Resume</a>
        </li>
      </ul>
    </div>
  </div>
</nav>