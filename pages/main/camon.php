<?php
include('admin/config/config.php');
// require('../../carbon/autoload.php');
// use Carbon\Carbon;
// use Carbon\CarbonInterval;
// $now = Carbon::now('Asia/Ho_Chi_Minh');

if (isset($_GET['vnp_Amount'])) {
    $vnp_respon = $_GET['vnp_ResponseCode'];
    if ($vnp_respon == '00') {
        $vnp_Amount = $_GET['vnp_Amount'];
        $vnp_BankCode = $_GET['vnp_BankCode'];
        $vnp_BankTranNo = $_GET['vnp_BankTranNo'];
        $vnp_OrderInfo = $_GET['vnp_OrderInfo'];
        $vnp_PayDate = $_GET['vnp_PayDate'];
        $vnp_TmnCode = $_GET['vnp_TmnCode'];
        $vnp_TransactionNo = $_GET['vnp_TransactionNo'];
        $vnp_CardType = $_GET['vnp_CardType'];

        $code_cart = $_SESSION['code_cart'];

        $insert_vnpay = "INSERT INTO tbl_vnpay(vnp_amount,vnp_bankcode,vnp_banktranno,vnp_cardtype,vnp_orderinfo,vnp_paydate,vnp_tmncode,vnp_transactionno,code_cart)
                VALUE('" . $vnp_Amount . "','" . $vnp_BankCode . "','" . $vnp_BankTranNo . "','" . $vnp_CardType . "','" . $vnp_OrderInfo . "','" . $vnp_PayDate . "','" . $vnp_TmnCode . "','" . $vnp_TransactionNo . "','" . $code_cart . "')";
        $cart_query = mysqli_query($mysqli, $insert_vnpay);
        unset($_SESSION['cart']);
        if ($cart_query) {
            echo '<h3>Giao dịch thành công</h3>';
            echo '<h3>Vui lòng vào trang <a href="index.php?quanly=donhangdadat">Lịch sử đơn hàng</a> để xem chi tiết đơn hàng của bạn</h3>';
            echo '<h2><i>Cảm ơn đã mua hàng!! Chúng tôi sẽ liên hệ với bạn trong thời gian sớm nhất</i></h2>';
        }
    }else{
        $code_cart = $_SESSION['code_cart'];
        $sql_xoa = "DELETE FROM tbl_cart WHERE code_cart='".$code_cart."' ";
        mysqli_query($mysqli,$sql_xoa);

        $sql_xoa_detail = "DELETE FROM tbl_cart_details WHERE code_cart='".$code_cart."' ";
        mysqli_query($mysqli,$sql_xoa_detail);
        echo '<h3>Giao dịch thất bại</h3>';
    }
} else {
    echo '<h2><i>Cảm ơn đã mua hàng!! Chúng tôi sẽ liên hệ với bạn trong thời gian sớm nhất</i></h2>';
}
?>