<?php
if (session_status() === PHP_SESSION_NONE) session_start();
if (!isset($_SESSION['dangnhap']) || !isset($_SESSION['admin_status'])) {
    header('Location: login.php'); // Đổi lại đúng path login nếu file nằm ở module/con
    exit();
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Admin Control Panel</title>
    <style>
        body {
            background: #f5f6fa;
            font-family: Arial, Helvetica, sans-serif;
            margin: 0;
        }
        .header {
            background: #fff;
            padding: 12px 0;
            text-align: center;
            font-size: 38px;
            color: #0d34a4;
            font-weight: bold;
            letter-spacing: 1px;
            box-shadow: 0 0 8px #eaeaea;
        }
        .menu {
            background: #319491;
            min-height: 48px;
            padding: 0 10px;
            box-shadow: 0 1px 6px #eaeaea;
        }
        .menu ul {
            list-style: none;
            margin: 0;
            padding: 0;
            display: flex;
            align-items: center;
        }
        .menu li {
            margin-right: 24px;
        }
        .menu li a {
            color: #fff;
            text-decoration: none;
            display: block;
            padding: 14px 16px;
            font-weight: bold;
            border-radius: 4px;
            transition: background 0.2s;
            font-size: 17px;
            background: #319491; /* Thêm nền mặc định cho mọi nút menu */
        }
        .menu li a:hover {
            background: #195f5f;
        }
        /* Nút đăng xuất khác biệt nếu muốn */
        .menu li.logout a {
            background: #237773;
            color: #fff !important;
        }
        .menu li.logout a:hover {
            background: #145d54;
        }
        /* Đưa mục đăng xuất ra phải */
        .menu li.logout {
            margin-left: auto;
        }
        .main {
            padding: 30px;
        }
        h2 {
            color: #1060CC;
            margin: 10px 0 20px 0;
        }
        .footer {
            margin-top:40px;
            text-align:center;
            color:#777;
            padding:18px 0;
            background: #f4f7f7;
            font-size:14px;
        }
    </style>
</head>
<body>
    <div class="header">

    </div>
    <div class="menu">
        <ul>
            <li><a href="index.php">Thống kê</a></li>
            <li><a href="index.php?action=quanlydanhmucsanpham&query=them">Quản lý danh mục sản phẩm</a></li>
            <li><a href="index.php?action=quanlysp&query=them">Quản lý sản phẩm</a></li>
            <li><a href="index.php?action=quanlydonhang&query=lietke">Quản lý đơn hàng</a></li>
            <?php if ($_SESSION['admin_status'] == 0): ?>
                <li><a href="index.php?action=quanlydanhmucbaiviet&query=them">Quản lý danh mục bài viết</a></li>
                <li><a href="index.php?action=quanlybaiviet&query=them">Quản lý bài viết</a></li>
                <li><a href="index.php?action=quanlyweb&query=capnhat">Quản lý website</a></li>
                <li><a href="index.php?action=quanlythongbao&query=thongbao">Quản lý thông báo</a></li>

            <?php endif; ?>
            <li class="logout">
                <a href="index.php?dangxuat=1">
                    Đăng xuất: <?php echo htmlspecialchars($_SESSION['dangnhap']); ?>
                </a>
            </li>
        </ul>
    </div>
    <div class="main">
        <h2>Chào mừng bạn đến trang quản trị!</h2>
        <!-- Nội dung dashboard hoặc module sẽ show ở đây -->
        <p>Bạn có thể chọn chức năng ở menu để quản lý hệ thống.</p>
    </div>
    <div class="footer">
        &copy; <?php echo date('Y'); ?> 3TH MOTORBIKES SHOP - Admin Control Panel
    </div>
</body>
</html>