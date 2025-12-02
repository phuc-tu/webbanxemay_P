<?php
if (session_status() === PHP_SESSION_NONE) session_start();
header('Content-Type: application/json; charset=utf-8');

// ======= CHỈ BẬT KIỂM TRA QUYỀN KHI TRIỂN KHAI CHÍNH THỨC =======
// if (!isset($_SESSION['dangnhap']) || !isset($_SESSION['admin_status'])) {
//     echo json_encode(['error' => 'Chưa đăng nhập!']);
//     exit();
// }
// if ($_SESSION['admin_status'] != 0) {
//     echo json_encode(['error' => 'Bạn không có quyền truy cập!']);
//     exit();
// }
require('../../carbon/autoload.php');
include('../config/config.php');
use Carbon\Carbon;

$thoigian = $_POST['thoigian'] ?? '365ngay';

switch ($thoigian) {
    case '7ngay':
        $subdays = Carbon::now('Asia/Ho_Chi_Minh')->subDays(7)->toDateString();
        break;
    case '30ngay':
        $subdays = Carbon::now('Asia/Ho_Chi_Minh')->subDays(30)->toDateString();
        break;
    case '90ngay':
        $subdays = Carbon::now('Asia/Ho_Chi_Minh')->subDays(90)->toDateString();
        break;
    default:
        $subdays = Carbon::now('Asia/Ho_Chi_Minh')->subDays(365)->toDateString();
        break;
}
$now = Carbon::now('Asia/Ho_Chi_Minh')->toDateString();

// Tính doanh thu từ chi tiết đơn hàng, có JOIN sản phẩm
$sql = "
SELECT 
    DATE(c.cart_date) as date,
    COUNT(DISTINCT c.code_cart) as order_count,
    SUM(cd.soluongmua * sp.giasp) as sales,
    SUM(cd.soluongmua) as quantity
FROM tbl_cart c
LEFT JOIN tbl_cart_details cd ON c.code_cart = cd.code_cart
LEFT JOIN tbl_sanpham sp ON cd.id_sanpham = sp.id_sanpham
WHERE c.cart_status = 1
  AND DATE(c.cart_date) BETWEEN '$subdays' AND '$now'
GROUP BY DATE(c.cart_date)
ORDER BY DATE(c.cart_date) ASC
";
$query = mysqli_query($mysqli, $sql);

$data = [];
while($row = mysqli_fetch_assoc($query)){
    $data[] = [
        'date'     => $row['date'],
        'order'    => (int)$row['order_count'],
        'sales'    => (int)$row['sales'],
        'quantity' => (int)$row['quantity']
    ];
}
echo json_encode($data);
exit();
?>