
<?php
if (session_status() === PHP_SESSION_NONE) session_start();
if (!isset($_SESSION['dangnhap']) || !isset($_SESSION['admin_status'])) {
    header('Location: ../../login.php');
    exit();
}
if ($_SESSION['admin_status'] != 0) {
    echo 'Bạn không có quyền truy cập chức năng này!';
    exit();
}
include("../config/config.php");
// Đảm bảo đường dẫn đúng tới config DB
?>
<h3>DANH SÁCH USER ĐĂNG KÝ</h3>
<table border="1" width="100%" style="border-collapse:collapse;">
    <tr style="background: #c3d69b">
        <th>ID</th>
        <th>Tên khách hàng</th>
        <th>Email</th>
        <th>Địa chỉ</th>
        <th>Điện thoại</th>
        <th>Mật khẩu (mã hóa)</th>
        <th>Thao tác</th>
    </tr>
    <?php
    $sql = "SELECT * FROM tbl_dangky ORDER BY id_dangky DESC";
    $query = mysqli_query($mysqli, $sql);
    while($row = mysqli_fetch_array($query)){
    ?>
    <tr>
        <td><?php echo $row['id_dangky']; ?></td>
        <td><?php echo htmlspecialchars($row['tenkhachhang']); ?></td>
        <td><?php echo htmlspecialchars($row['email']); ?></td>
        <td><?php echo htmlspecialchars($row['diachi']); ?></td>
        <td><?php echo htmlspecialchars($row['dienthoai']); ?></td>
        <td style="font-family:monospace;"><?php echo htmlspecialchars($row['matkhau']); ?></td>
        <td>
            <a href="index.php?action=quanlitk&query=sua&id=<?php echo $row['id_dangky']; ?>">Sửa</a> | 
            <a href="modules/quanlitk/xuly.php?xoa=<?php echo $row['id_dangky']; ?>" onclick="return confirm('Xoá tài khoản này?');">Xoá</a>
        </td>
    </tr>
    <?php } ?>
</table>