<?php
if (session_status() === PHP_SESSION_NONE) session_start();
if (!isset($_SESSION['dangnhap']) || !isset($_SESSION['admin_status'])) {
    header('Location: ../../login.php'); // sửa đúng đường dẫn login, thường là ../../login.php với file nằm trong modules/quanlydanhmucbaiviet/
    exit();
}
// Chỉ admin mới có quyền (admin_status == 0)
if ($_SESSION['admin_status'] != 0) {
    echo 'Bạn không có quyền truy cập chức năng này!';
    exit();
}
?>
<h3>Thêm danh mục bài viết</h3>
<table border="1" width="50%" style="border-collapse:collapse;" >
    <form method="POST" action="modules/quanlydanhmucbaiviet/xuly.php" >
    <tr>
        <td>Tên danh mục bài viết</td>
        <td><input type="text" name="tendanhmucbaiviet"></td>

    </tr>
    <tr>
        <td>Thứ tự </td>
        <td><input type="text" name="thutu"></td>
    </tr>
    <tr>
        <!-- <td colspan="2"><input type="submit" value="Thêm danh mục bài viết" name="themdanhmucbaiviet" ></td> -->
        <td colspan="2"><button type="submit" name="themdanhmucbaiviet" class="btn btn-primary">Thêm danh mục bài viết</button></td>

    </tr>
    </form>
</table>