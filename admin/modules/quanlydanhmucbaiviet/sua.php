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
<?php
    $sql_sua_danhmucbaiviet = "SELECT * FROM tbl_danhmucbaiviet WHERE id_baiviet='$_GET[idbaiviet]' LIMIT 1 ";
    $query_sua_danhmucbaiviet = mysqli_query($mysqli,$sql_sua_danhmucbaiviet);
?>

<h3>Sửa danh mục bai viet</h3>
<table border="1" width="50%" style="border-collapse:collapse;" >
    <form method="POST" action="modules/quanlydanhmucbaiviet/xuly.php?idbaiviet=<?php echo $_GET['idbaiviet'] ?>" >
        <?php 
        while($dong = mysqli_fetch_array($query_sua_danhmucbaiviet)){
        ?>
        <tr>
            <td>Tên danh mục bài viết</td>
            <td><input type="text" name="tendanhmucbaiviet" value="<?php echo $dong['tendanhmuc_baiviet'] ?>"></td>

         </tr>
         <tr>
            <td>Thứ tự </td>
            <td><input type="text" name="thutu" value="<?php echo $dong['thutu'] ?>"></td>

        </tr>
        <tr>
            <!-- <td colspan="2"><input type="submit" value="Cập nhật danh mục bài viết" name="suadanhmucbaiviet" ></td> -->
            <td colspan="2"><button type="submit" name="suadanhmucbaiviet" class="btn btn-primary">Cập nhật danh mục bài viết</button></td>

        </tr>
        <?php
        }
        ?>
    </form>
</table>