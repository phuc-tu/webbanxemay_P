<?php
if (session_status() === PHP_SESSION_NONE) session_start();
if (!isset($_SESSION['dangnhap']) || !isset($_SESSION['admin_status'])) {
    header('Location: ../../login.php');
    exit();
}
?>
<!-- CODE chức năng ở dưới -->
<h3>Thêm danh mục</h3>
<table border="1" width="50%" style="border-collapse:collapse;" >
    <form method="POST" action="modules/quanlydanhmucsanpham/xuly.php" >
    <tr>
        <td>Tên danh mục</td>
        <td><input type="text" name="tendanhmuc"></td>

    </tr>
    <tr>
        <td>Thứ tự </td>
        <td><input type="text" name="thutu"></td>
    </tr>
    <tr>
        <!-- <td colspan="2"><input type="submit" value="Thêm danh mục sản phẩm" name="themdanhmuc" ></td> -->
        <td colspan="2"><button type="submit" name="themdanhmuc" class="btn btn-primary">Thêm danh mục sản phẩm</button></td>

    </tr>
    </form>
</table>