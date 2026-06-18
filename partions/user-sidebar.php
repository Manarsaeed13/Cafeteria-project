<div class="sidebar-overlay" id="sidebarOverlay"></div>

<div class="sidebar" id="mainSidebar">
  <button class="sidebar-close-btn" id="sidebarCloseBtn">
    <i class="fa-solid fa-xmark"></i>
  </button>
  <div class="logo">
    <i class="fa-solid fa-mug-hot"></i>
    <h2>Cafe</h2>
  </div>
  <ul class="menu">
    <li><a href="home.php"><i class="fa-solid fa-house"></i><span>Home</span></a></li>
    <li><a href="my-order.php" class="active"><i class="fa-solid fa-bag-shopping"></i><span>Orders</span></a></li>
    <li><a href="#"><i class="fa-solid fa-user"></i><span>My Profile</span></a></li>
  </ul>
</div>

<style>
  .sidebar { position: fixed; top: 0; left: -280px; width: 260px; height: 100%; background: #0D530E; z-index: 1050; transition: left 0.35s cubic-bezier(0.4, 0, 0.2, 1); padding: 40px 0 30px; box-shadow: 4px 0 20px rgba(0,0,0,0.15); display: flex; flex-direction: column; }
  .sidebar.open { left: 0; }
  .sidebar .logo { display: flex; align-items: center; gap: 12px; padding: 0 28px 30px; border-bottom: 1px solid rgba(255,255,255,0.15); margin-bottom: 20px; }
  .sidebar .logo i { color: #FBF5DD; font-size: 30px; }
  .sidebar .logo h2 { color: #FBF5DD; font-size: 22px; font-weight: 700; margin: 0; letter-spacing: 1px; }
  .sidebar .menu { list-style: none; padding: 0 16px; margin: 0; flex: 1; }
  .sidebar .menu li { margin-bottom: 6px; }
  .sidebar .menu li a { display: flex; align-items: center; gap: 14px; padding: 13px 18px; color: rgba(251, 245, 221, 0.8); text-decoration: none; border-radius: 12px; font-size: 15px; font-weight: 500; transition: all 0.2s ease; }
  .sidebar .menu li a:hover { background: rgba(255,255,255,0.12); color: #FBF5DD; }
  .sidebar .menu li a.active { background: rgba(255,255,255,0.18); color: #FBF5DD; font-weight: 600; }
  .sidebar .menu li a i { font-size: 18px; width: 22px; text-align: center; }
  .sidebar-close-btn { position: absolute; top: 18px; right: 18px; background: rgba(255,255,255,0.15); border: none; color: #FBF5DD; width: 34px; height: 34px; border-radius: 50%; font-size: 16px; cursor: pointer; display: flex; align-items: center; justify-content: center; transition: background 0.2s; }
  .sidebar-close-btn:hover { background: rgba(255,255,255,0.28); }
  .sidebar-overlay { position: fixed; inset: 0; background: rgba(0,0,0,0.45); z-index: 1040; opacity: 0; pointer-events: none; transition: opacity 0.35s ease; }
  .sidebar-overlay.show { opacity: 1; pointer-events: all; }
</style>

<script>
  document.getElementById('sidebarToggleBtn')?.addEventListener('click', function() {
    document.getElementById('mainSidebar').classList.add('open');
    document.getElementById('sidebarOverlay').classList.add('show');
  });
  document.getElementById('sidebarCloseBtn')?.addEventListener('click', function() {
    document.getElementById('mainSidebar').classList.remove('open');
    document.getElementById('sidebarOverlay').classList.remove('show');
  });
  document.getElementById('sidebarOverlay')?.addEventListener('click', function() {
    document.getElementById('mainSidebar').classList.remove('open');
    document.getElementById('sidebarOverlay').classList.remove('show');
  });
</script>