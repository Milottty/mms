<?php include_once "header.php"?>





<nav class="navbar navbar-expand-lg navbar-dark" style="background-color: transparent; box-shadow: 0 2px 4px rgba(0,0,0,0.3);">
  <div class="container-fluid">
    <a class="navbar-brand fw-bold text-white" href="#">User Panel</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse justify-content-center" id="navbarNavDropdown">
      <ul class="navbar-nav mb-2 mb-lg-0">
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle text-white" href="#" id="cinemaDropdown" role="button" data-bs-toggle="dropdown">
            Cinemas
          </a>
          <ul class="dropdown-menu dropdown-menu-dark">
            <li><a class="dropdown-item" href="cinestar.php">Cinestar</a></li>
            <li><a class="dropdown-item" href="cineplex.php">Cineplex</a></li>
          </ul>
        </li>
        <li class="nav-item"><a class="nav-link text-white" href="movies.php">Movies</a></li>
        <li class="nav-item"><a class="nav-link text-white" href="bookings.php">Bookings</a></li>
      </ul>
    </div>


    <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle d-flex align-items-center text-white" href="#" id="userDropdown" data-bs-toggle="dropdown">
          <img src="<?= isset($_SESSION['profile_image']) ? $_SESSION['profile_image'] : 'img/default.png' ?>" width="30" height="30" class="rounded-circle me-2" alt="Profile">
          <span><?= htmlspecialchars($_SESSION['username'] ?? 'Guest') ?></span>
        </a>
        <ul class="dropdown-menu dropdown-menu-end dropdown-menu-dark">
          <li><a class="dropdown-item" href="settings.php">Settings</a></li>
          <li><a class="dropdown-item" href="user_dashboard.php">Profile</a></li>
          <li><a class="dropdown-item" href="watchlist.php">WatchList</a></li>
          <li>
            <hr class="dropdown-divider">
          </li>
          <li><a class="dropdown-item" href="logout.php" onclick="return confirm('Are you sure you want to logout?')">Logout</a></li>
        </ul>
      </li>
    </ul>
  </div>
</nav>

<?php include_once "footer.php"?>
