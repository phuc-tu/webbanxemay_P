<?php
$id = $_GET['id'];
$sql_sua = "SELECT * FROM tbl_dangky WHERE id_dangky=?";
$stmt = $mysqli->prepare($sql_sua);
$stmt->bind_param("i", $id);
$stmt->execute();
$query_sua = $stmt->get_result();
$row = $query_sua->fetch_assoc();
$stmt->close();
?>

<div class="content-header">
    <h2><i class="fas fa-user-edit"></i> Sửa thông tin tài khoản</h2>
</div>

<div class="form-container">
    <form method="POST" action="modules/quanlytaikhoan/xuly.php">
        <input type="hidden" name="id_dangky" value="<?php echo $row['id_dangky']; ?>">
        
        <div class="form-grid">
            <div class="form-group">
                <label><i class="fas fa-user"></i> Họ tên <span class="required">*</span></label>
                <input type="text" name="tenkhachhang" value="<?php echo htmlspecialchars($row['tenkhachhang']); ?>" required>
            </div>

            <div class="form-group">
                <label><i class="fas fa-envelope"></i> Email <span class="required">*</span></label>
                <input type="email" name="email" value="<?php echo htmlspecialchars($row['email']); ?>" required>
            </div>

            <div class="form-group">
                <label><i class="fas fa-phone"></i> Điện thoại <span class="required">*</span></label>
                <input type="text" name="dienthoai" value="<?php echo htmlspecialchars($row['dienthoai']); ?>" required>
            </div>

            <div class="form-group full-width">
                <label><i class="fas fa-map-marker-alt"></i> Địa chỉ</label>
                <textarea name="diachi" rows="3"><?php echo htmlspecialchars($row['diachi']); ?></textarea>
            </div>
            <!-- KHÔNG hiển thị mật khẩu cũ hay giá trị hash !!! -->
            <div class="form-group full-width">
                <label><i class="fas fa-lock"></i> Mật khẩu mới (để trống nếu không đổi)</label>
                <input type="password" name="matkhau" placeholder="Nhập mật khẩu mới nếu muốn đổi">
                <small>Để trống nếu không muốn thay đổi mật khẩu</small>
            </div>
        </div>

        <div class="form-actions">
            <button type="submit" name="suataikhoan" class="btn btn-primary">
                <i class="fas fa-save"></i> Lưu thay đổi
            </button>
            <a href="index.php?action=quanlytaikhoan&query=lietke" class="btn btn-secondary">
                <i class="fas fa-times"></i> Hủy
            </a>
        </div>
    </form>
</div>

<style>
.form-container {
    background: white;
    border-radius: 10px;
    padding: 30px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    max-width: 800px;
}
.form-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
}
.form-group {
    display: flex;
    flex-direction: column;
}
.form-group.full-width {
    grid-column: 1 / -1;
}
.form-group label {
    margin-bottom: 8px;
    font-weight: 600;
    color: #333;
    font-size: 14px;
}
.form-group label i {
    margin-right: 5px;
    color: #667eea;
}
.required {
    color: #e74c3c;
}
.form-group input, .form-group textarea {
    padding: 12px;
    border: 2px solid #ddd;
    border-radius: 8px;
    font-size: 14px;
    transition: all 0.3s;
}
.form-group input:focus, .form-group textarea:focus {
    border-color: #667eea;
    outline: none;
    box-shadow: 0 0 0 3px rgba(102,126,234,0.1);
}
.form-group small {
    margin-top: 5px;
    color: #999;
    font-size: 12px;
}
.form-actions {
    display: flex;
    gap: 15px;
    margin-top: 30px;
}
.btn {
    padding: 12px 30px;
    border: none;
    border-radius: 8px;
    font-size: 14px;
    font-weight: 600;
    cursor: pointer;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    transition: all 0.3s;
}
.btn-primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
}
.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(102,126,234,0.4);
}
.btn-secondary {
    background: #95a5a6;
    color: white;
}
.btn-secondary:hover {
    background: #7f8c8d;
}
</style>