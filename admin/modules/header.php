<?php
if (session_status() === PHP_SESSION_NONE) session_start();

if (isset($_GET['dangxuat']) && $_GET['dangxuat'] == 1) {
    session_unset(); // Xóa toàn bộ biến session
    session_destroy(); // Hủy phiên session
    header('Location: login.php');
    exit();
}
?>
<div class="header">
    <p>
        <a style="color:white;line-height:50px;" href="index.php?dangxuat=1">
            Đăng xuất: <?php if (isset($_SESSION['dangnhap'])) echo $_SESSION['dangnhap']; ?>
        </a>
    </p>
</div>