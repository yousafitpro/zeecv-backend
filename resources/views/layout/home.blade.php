<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="apple-touch-icon" sizes="180x180" href="{{asset('assets/favicon/apple-touch-icon.png')}}">
  <link rel="icon" type="image/png" sizes="32x32" href="{{asset('assets/favicon/favicon-32x32.png')}}">
  <link rel="icon" type="image/png" sizes="16x16" href="{{asset('assets/favicon/favicon-16x16.png')}}">
  <link rel="manifest" href="{{asset('assets/favicon/site.webmanifest')}}">
  <title>ZeeCV · AI CV Builder</title>
  <!-- Font Awesome (free icons) -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
@include('home.css.style')
</head>
<body>

<div class="container">
  <!-- NAV -->
  <nav class="navbar">
    <div class="logo">
      <i class="fas fa-brain"></i>
      <span>ZeeCV</span>
    </div>
    <div class="nav-links">
      <a href="#">Features</a>
      <a href="#">Templates</a>
      <a href="#">Pricing</a>
      <a href="#" class="btn-outline">Log in</a>
      <a href="#" class="btn-primary" style="padding: 0.6rem 1.8rem;">Get started</a>
    </div>
  </nav>

@yield('content')

  <!-- FOOTER -->
  <footer class="footer">
    <div>© 2026 ZeeCV — AI CV builder</div>
    <div class="socials">
      <i class="fab fa-twitter"></i>
      <i class="fab fa-linkedin-in"></i>
      <i class="fab fa-github"></i>
      <i class="fab fa-youtube"></i>
    </div>
  </footer>
</div>
<!-- end container -->

</body>
</html>