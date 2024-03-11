<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
  <!-- Left navbar links -->
  <ul class="navbar-nav">
    <li class="nav-item">
      <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
    </li>
    <li class="nav-item d-none d-sm-inline-block">
      <a href="{{ route('home') }}" class="nav-link">الصفحة الرئيسية</a>
    </li>
  </ul>

  <!-- Right navbar links -->
  <ul class="navbar-nav mr-auto-navbav">
    <li class="nav-item d-none d-sm-inline-block">
      <a href="{{ route('auth.logout') }}" class="nav-link">تسجيل الخروج</a>
    </li>
  </ul>
</nav>
<!-- /.navbar -->