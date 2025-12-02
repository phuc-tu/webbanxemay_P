<?php
include('../../config/config.php');
session_start();

// SỬA TÀI KHOẢN
if(isset($_POST['suataikhoan'])) {
    $id = $_POST['id_dangky'];
    $tenkhachhang = mysqli_real_escape_string($mysqli, $_POST['tenkhachhang']);
    $email = mysqli_real_escape_string($mysqli, $_POST['email']);
    $dienthoai = mysqli_real_escape_string($mysqli, $_POST['dienthoai']);
    $diachi = mysqli_real_escape_string($mysqli, $_POST['diachi']);

    // Đổi mật khẩu: DÙNG HASH an toàn! KHÔNG md5!
    if(!empty($_POST['matkhau'])) {
        // Bảo mật nâng cao: dùng password_hash và chuẩn bị trước truy vấn
        $matkhau = password_hash($_POST['matkhau'], PASSWORD_DEFAULT);
        $sql_update = "UPDATE tbl_dangky SET 
                       tenkhachhang=?, 
                       email=?, 
                       dienthoai=?, 
                       diachi=?, 
                       matkhau=?
                       WHERE id_dangky=?";
        $stmt = $mysqli->prepare($sql_update);
        $stmt->bind_param("sssssi", $tenkhachhang, $email, $dienthoai, $diachi, $matkhau, $id);
        $stmt->execute();
        $stmt->close();
    } else {
        $sql_update = "UPDATE tbl_dangky SET 
                       tenkhachhang=?, 
                       email=?, 
                       dienthoai=?, 
                       diachi=?
                       WHERE id_dangky=?";
        $stmt = $mysqli->prepare($sql_update);
        $stmt->bind_param("ssssi", $tenkhachhang, $email, $dienthoai, $diachi, $id);
        $stmt->execute();
        $stmt->close();
    }
    header('Location:../../index.php?action=quanlytaikhoan&query=lietke');
    exit();
}

// KHÓA TÀI KHOẢN
elseif(isset($_POST['khoataikhoan'])) {
    $id = $_POST['id_khoa'];
    $ly_do_khoa = mysqli_real_escape_string($mysqli, $_POST['ly_do_khoa']);

    $sql_khoa = "UPDATE tbl_dangky SET 
                 trang_thai=0, 
                 ly_do_khoa=?, 
                 ngay_khoa=NOW() 
                 WHERE id_dangky=?";
    $stmt = $mysqli->prepare($sql_khoa);
    $stmt->bind_param("si", $ly_do_khoa, $id);
    $stmt->execute();
    $stmt->close();

    header('Location:../../index.php?action=quanlytaikhoan&query=lietke');
    exit();
}

// MỞ KHÓA TÀI KHOẢN
elseif(isset($_GET['mokhoa'])) {
    $id = $_GET['mokhoa'];

    $sql_mokhoa = "UPDATE tbl_dangky SET 
                   trang_thai=1, 
                   ly_do_khoa=NULL, 
                   ngay_khoa=NULL 
                   WHERE id_dangky=?";
    $stmt = $mysqli->prepare($sql_mokhoa);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();

    header('Location:../../index.php?action=quanlytaikhoan&query=lietke');
    exit();
}

// XÓA TÀI KHOẢN
elseif(isset($_GET['xoa'])) {
    $id = $_GET['xoa'];

    // Xóa đơn hàng liên quan trước
    $sql_cart = "SELECT code_cart FROM tbl_cart WHERE id_khachhang=?";
    $stmt = $mysqli->prepare($sql_cart);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result_cart = $stmt->get_result();
    while($row = $result_cart->fetch_assoc()) {
        $code = $row['code_cart'];
        $sql_del_detail = "DELETE FROM tbl_cart_details WHERE code_cart=?";
        $stmt_detail = $mysqli->prepare($sql_del_detail);
        $stmt_detail->bind_param("s", $code);
        $stmt_detail->execute();
        $stmt_detail->close();
    }
    $stmt->close();

    $sql_del_cart = "DELETE FROM tbl_cart WHERE id_khachhang=?";
    $stmt_cart = $mysqli->prepare($sql_del_cart);
    $stmt_cart->bind_param("i", $id);
    $stmt_cart->execute();
    $stmt_cart->close();

    // Xóa tài khoản
    $sql_xoa = "DELETE FROM tbl_dangky WHERE id_dangky=?";
    $stmt_xoa = $mysqli->prepare($sql_xoa);
    $stmt_xoa->bind_param("i", $id);
    $stmt_xoa->execute();
    $stmt_xoa->close();

    header('Location:../../index.php?action=quanlytaikhoan&query=lietke');
    exit();
}
?>