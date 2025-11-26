<?php
if (session_status() === PHP_SESSION_NONE) session_start();
header('Content-Type: application/json; charset=utf-8');
if (!isset($_SESSION['dangnhap']) || !isset($_SESSION['admin_status'])) {
    echo json_encode(['error' => 'Chưa đăng nhập!']);
    exit();
}
if ($_SESSION['admin_status'] != 0) {
    echo json_encode(['error' => 'Bạn không có quyền truy cập!']);
    exit();
}
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

// Truy vấn top 5 sản phẩm bán chạy nhất
$sql = "
SELECT
    sp.id_sanpham,
    sp.tensanpham,
    sp.hinhanh,
    SUM(cd.soluongmua) AS tong_ban
FROM tbl_cart_details cd
JOIN tbl_cart c ON c.code_cart = cd.code_cart
JOIN tbl_sanpham sp ON sp.id_sanpham = cd.id_sanpham
WHERE c.cart_status = 1
  AND DATE(c.cart_date) BETWEEN '$subdays' AND '$now'
GROUP BY sp.id_sanpham, sp.tensanpham, sp.hinhanh
ORDER BY tong_ban DESC
LIMIT 5
";
$sql_query = mysqli_query($mysqli, $sql);
if(!$sql_query){
    echo json_encode(['error' => mysqli_error($mysqli)]);
    exit();
}
$top5 = [];
while($row = mysqli_fetch_assoc($sql_query)){
    $top5[] = [
        'id'    => $row['id_sanpham'],
        'name'  => $row['tensanpham'],
        'image' => $row['hinhanh'],
        'sold'  => $row['tong_ban']
    ];
}
echo json_encode($top5);
exit();
?>