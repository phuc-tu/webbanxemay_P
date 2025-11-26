<?php
include("../../config/config.php"); // Đảm bảo đúng đường dẫn
if (!isset($_GET['id'])) {
    echo "Không xác định tài khoản cần sửa!";
    exit();
}
$id = intval($_GET['id']);
$sql = "SELECT * FROM tbl_dangky WHERE id_dangky=$id LIMIT 1";
$query = mysqli_query($mysqli, $sql);
$row = mysqli_fetch_array($query);

// Xử lý cập nhật khi submit form
if (isset($_POST['update'])) {
    $ten = $_POST['tenkhachhang'];
    $email = $_POST['email'];
    $diachi = $_POST['diachi'];
    $dienthoai = $_POST['dienthoai'];
    // Không cập nhật mật khẩu nếu không nhập mới
    if (!empty($_POST['matkhau'])) {
        $matkhau = md5($_POST['matkhau']);
        $sql_update = "UPDATE tbl_dangky SET tenkhachhang='$ten', email='$email', diachi='$diachi', dienthoai='$dienthoai', matkhau='$matkhau' WHERE id_dangky=$id";
    } else {
        $sql_update = "UPDATE tbl_dangky SET tenkhachhang='$ten', email='$email', diachi='$diachi', dienthoai='$dienthoai' WHERE id_dangky=$id";
    }
    mysqli_query($mysqli, $sql_update);
    header("Location: ../../index.php?action=quanlitk&query=lietke");
    exit();
}
?>
<h3>Sửa tài khoản khách hàng</h3>
<form method="POST">
    <p>Tên khách hàng<br>
        <input type="text" name="tenkhachhang" value="<?php echo htmlspecialchars($row['tenkhachhang']); ?>" required></p>
    <p>Email<br>
        <input type="email" name="email" value="<?php echo htmlspecialchars($row['email']); ?>" required></p>
    <p>Địa chỉ<br>
        <input type="text" name="diachi" value="<?php echo htmlspecialchars($row['diachi']); ?>"></p>
    <p>Điện thoại<br>
        <input type="text" name="dienthoai" value="<?php echo htmlspecialchars($row['dienthoai']); ?>"></p>
    <p>Mật khẩu mới (để trống nếu không đổi)<br>
        <input type="password" name="matkhau"></p>
    <button type="submit" name="update">Cập nhật</button>
    <a href="../../index.php?action=quanlitk&query=lietke">Quay lại</a>
</form>