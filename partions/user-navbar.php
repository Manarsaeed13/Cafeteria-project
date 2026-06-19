<nav class="navbar navbar-expand-lg main-navbar">
  <div class="container-fluid">
    <div class="brand">
      <?php if(basename($_SERVER['PHP_SELF']) == 'my-order.php'): ?>
        <i class="fa-solid fa-bars menu-icon" id="sidebarToggleBtn"></i>
      <?php endif; ?>
      <a href="#" class="logo">
        <i class="fa-solid fa-mug-hot"></i>
        <span class="logo-text">CAFETERIA</span>
      </a>
    </div>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse justify-content-center" id="navbarContent">
      <ul class="navbar-nav">
        <?php if(basename($_SERVER['PHP_SELF']) == 'my-order.php'): ?>
          <li class="nav-item"><a class="nav-link" href="home.php">Home</a></li>
          <li class="nav-item"><a class="nav-link active" href="my-order.php">My Orders</a></li>
        <?php endif; ?>
      </ul>
    </div>
    <?php if(basename($_SERVER['PHP_SELF']) == 'my-order.php'): ?>
    <div class="d-flex align-items-center gap-3">
      <img src="images/user.jpeg" class="guest-img">
      <strong class="d-none d-sm-inline" style="color:#FBF5DD;">Ahmed Mohamed</strong>
    </div>
    <?php endif; ?>
  </div>
</nav>

<style>
  .main-navbar { width: 85%; margin: 30px auto; background: #0D530E; border-radius: 28px; padding: 20px 35px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); }
  .brand { display: flex; align-items: center; gap: 15px; }
  .menu-icon { font-size: 24px; color: #FBF5DD; cursor: pointer; transition: transform 0.2s; }
  .menu-icon:hover { transform: scale(1.1); }
  .logo { display: flex; align-items: center; gap: 10px; text-decoration: none; }
  .logo i { color: #FBF5DD; font-size: 28px; }
  .logo-text { color: #FBF5DD; font-size: 22px; font-weight: 700; letter-spacing: 0.5px; }
  .navbar-nav { gap: 30px; }
  .nav-link { color: #FBF5DD !important; font-weight: 600; position: relative; transition: 0.3s; font-size: 17px; }
  .nav-link.active::after { content: ""; position: absolute; left: 0; bottom: -10px; width: 100%; height: 3px; background: #FBF5DD; border-radius: 10px; }
  .guest-img { width: 45px; height: 45px; border-radius: 50%; object-fit: cover; }
</style>