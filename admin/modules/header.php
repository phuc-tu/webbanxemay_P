<?php
if (session_status() === PHP_SESSION_NONE) session_start();
if (!isset($_SESSION['dangnhap'])) {
    header('Location: login.php');
    exit();
}
?>

<!-- SIDEBAR -->
<div class="admin-sidebar" id="adminSidebar">
    <div class="sidebar-header">
        <a href="index.php" class="sidebar-logo">
            <i class="fas fa-motorcycle"></i>
            <div class="sidebar-logo-text">
                <h2>3TH SHOP</h2>
                <p>Admin Panel</p>
            </div>
        </a>
    </div>

    <nav class="sidebar-menu">
        <div class="menu-section-title">MAIN MENU</div>
        <ul>
            <li><a href="index.php"><i class="fas fa-chart-line"></i><span>Thống kê</span></a></li>
            <li><a href="index.php?action=quanlydanhmucsanpham&query=lietke"><i class="fas fa-list"></i><span>Danh mục SP</span></a></li>
            <li><a href="index.php?action=quanlysp&query=lietke"><i class="fas fa-motorcycle"></i><span>Sản phẩm</span></a></li>
            <li><a href="index.php?action=quanlydonhang&query=lietke"><i class="fas fa-shopping-cart"></i><span>Đơn hàng</span></a></li>
            <li><a href="index.php?action=quanlytaikhoan&query=lietke"><i class="fas fa-users"></i><span>Quản lý TK</span></a></li>
        </ul>

        <?php if (isset($_SESSION['admin_status']) && $_SESSION['admin_status'] == 0): ?>
        <div class="menu-section-title">CONTENT</div>
        <ul>
            <li><a href="index.php?action=quanlydanhmucbaiviet&query=lietke"><i class="fas fa-folder"></i><span>Danh mục bài viết</span></a></li>
            <li><a href="index.php?action=quanlybaiviet&query=lietke"><i class="fas fa-newspaper"></i><span>Bài viết</span></a></li>
        </ul>

        <div class="menu-section-title">SYSTEM</div>
        <ul>
            <li><a href="index.php?action=quanlyweb&query=capnhat"><i class="fas fa-cog"></i><span>Cài đặt</span></a></li>
            <li><a href="index.php?action=quanlythongbao&query=lietke"><i class="fas fa-bell"></i><span>Thông báo</span></a></li>
        </ul>
        <?php endif; ?>
    </nav>

    <div class="sidebar-user">
        <div class="user-profile">
            <div class="user-avatar">
                <?php echo strtoupper(substr($_SESSION['dangnhap'], 0, 1)); ?>
            </div>
            <div class="user-details">
                <h4><?php echo htmlspecialchars($_SESSION['dangnhap']); ?></h4>
                <p>Administrator</p>
            </div>
        </div>
        <a href="index.php?dangxuat=1" style="text-decoration: none;">
            <button class="logout-btn">
                <i class="fas fa-sign-out-alt"></i> <span>Đăng xuất</span>
            </button>
        </a>
    </div>
</div>

<!-- NÚT TOGGLE BÊN NGOÀI SIDEBAR -->
<button class="sidebar-toggle-external" onclick="toggleSidebar()" title="Thu gọn/Mở rộng">
    <i class="fas fa-angle-left"></i>
</button>

<!-- MAIN CONTENT WRAPPER -->
<div class="main-wrapper" id="mainWrapper">
    <div class="top-navbar">
        <div class="page-title">
            <h1>Dashboard</h1>
            <p>Chào mừng trở lại, <?php echo htmlspecialchars($_SESSION['dangnhap']); ?>! </p>
        </div>
        <div class="top-navbar-right">
            <div class="search-box">
                <i class="fas fa-search"></i>
                <input type="text" placeholder="Tìm kiếm...">
            </div>
            <div class="notification-icon">
                <i class="fas fa-bell"></i>
                <span class="notification-badge">3</span>
            </div>
        </div>
    </div>