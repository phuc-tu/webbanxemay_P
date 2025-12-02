<?php
include('../../config/config.php');
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Xử lý đổi mật khẩu
$msg = "";
if (isset($_POST['reset_password']) && $id > 0) {
    $new_pass = trim($_POST['matkhau_moi']);
    if (!empty($new_pass)) {
        $hash = password_hash($new_pass, PASSWORD_DEFAULT);
        $sql = "UPDATE tbl_dangky SET matkhau=? WHERE id_dangky=?";
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param("si", $hash, $id);
        if ($stmt->execute()) {
            $msg = "Đặt lại mật khẩu thành công!";
        } else {
            $msg = "Lỗi cập nhật mật khẩu!";
        }
        $stmt->close();
    } else {
        $msg = "Vui lòng nhập mật khẩu mới!";
    }
}

// Lấy thông tin khách hàng
$sqlkh = "SELECT tenkhachhang FROM tbl_dangky WHERE id_dangky=?";
$stmtkh = $mysqli->prepare($sqlkh);
$stmtkh->bind_param("i", $id);
$stmtkh->execute();
$rowkh = $stmtkh->get_result()->fetch_assoc();
$stmtkh->close();
?>

<div class="content-header">
    <h2><i class="fas fa-key"></i> Đặt lại mật khẩu tài khoản #<?php echo $id; ?></h2>
</div>
<?php if(!empty($msg)): ?>
    <div style="padding:12px; background:#eafaf1; color:#229d66; margin-bottom:15px; border-radius:6px;">
        <?php echo $msg; ?>
    </div>
<?php endif; ?>
<?php if($rowkh): ?>
<form method="POST" autocomplete="off">
    <div class="form-group">
        <label for="kh-name">Tên khách hàng</label>
        <input id="kh-name" type="text" value="<?php echo htmlspecialchars($rowkh['tenkhachhang']); ?>" readonly style="background:#f5f5f5;">
    </div>
    <div class="form-group">
        <label for="matkhau_moi">Mật khẩu mới <span style="color:red">*</span></label>
        <input id="matkhau_moi" type="password" name="matkhau_moi" required placeholder="Nhập mật khẩu mới...">
    </div>
    <button type="submit" name="reset_password" class="btn btn-primary">
        <i class="fas fa-save"></i> Đặt lại mật khẩu
    </button>
    <a href="index.php?action=quanlytaikhoan&query=lietke" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Quay lại
    </a>
</form>
<?php else: ?>
    <div style="color:red;padding:20px;">Không tìm thấy khách hàng!</div>
<?php endif; ?>

<style>
.form-group {margin-bottom:17px;}
input[type="text"] {width: 100%; padding:10px; border-radius:6px; border:1px solid #ddd; font-size:15px; background:#f5f5f5;}
input[type="password"] {width: 100%; padding:10px; border-radius:6px; border:1px solid #ddd; font-size:15px; background:white;}
button, .btn {padding:10px 22px; border-radius:6px; margin:6px 2px; border:none; font-weight:600; cursor:pointer;}
.btn-primary {background: #667eea; color:#fff;}
.btn-secondary {background: #95a5a6; color:#fff;}
</style>