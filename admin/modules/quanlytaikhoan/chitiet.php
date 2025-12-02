<?php
include('../../config/config.php');
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$sql = "SELECT * FROM tbl_dangky WHERE id_dangky = ?";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$stmt->close();
?>

<div class="content-header">
    <h2><i class="fas fa-user"></i> Thông tin khách hàng #<?= $row['id_dangky']; ?></h2>
</div>
<?php if($row): ?>
<table class="table-details">
    <tr><th>Tên khách hàng</th><td><?= htmlspecialchars($row['tenkhachhang']); ?></td></tr>
    <tr><th>Email</th><td><?= htmlspecialchars($row['email']); ?></td></tr>
    <tr><th>Điện thoại</th><td><?= htmlspecialchars($row['dienthoai']); ?></td></tr>
    <tr><th>Địa chỉ</th><td><?= htmlspecialchars($row['diachi']); ?></td></tr>
    <tr><th>Trạng thái</th><td><?= $row['trang_thai']==1 ? 'Hoạt động' : 'Bị khóa'; ?></td></tr>
    <tr>
      <th>Ngày đăng ký</th>
      <td>
        <?php
        if(empty($row['ngay_dangky']) || $row['ngay_dangky']=="0000-00-00 00:00:00")
            echo "Chưa cập nhật";
        else
            echo date("d/m/Y H:i", strtotime($row['ngay_dangky']));
        ?>
      </td>
    </tr>
    <?php if($row['trang_thai']==0 && !empty($row['ly_do_khoa'])): ?>
    <tr><th>Lý do khóa</th><td><?= htmlspecialchars($row['ly_do_khoa']); ?></td></tr>
    <?php endif; ?>
</table>
<?php else: ?>
<div style="padding:20px;color:#e74c3c;">Không tìm thấy khách hàng!</div>
<?php endif; ?>