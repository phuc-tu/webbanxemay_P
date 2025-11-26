<?php
include("../../config/config.php"); // Đảm bảo đường dẫn đúng

if (isset($_GET['xoa'])) {
    $id = intval($_GET['xoa']);
    $sql_xoa = "DELETE FROM tbl_dangky WHERE id_dangky = $id";
    mysqli_query($mysqli, $sql_xoa);
    // Xóa xong quay lại trang liệt kê
    header("Location: ../../index.php?action=quanlitk&query=lietke");
    exit();
}
?>