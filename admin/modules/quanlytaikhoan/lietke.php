<!-- CODE HIỂN THỊ DANH SÁCH TÀI KHOẢN AN TOÀN - KHÔNG HIỆN MẬT KHẨU -->

<table class="admin-table" id="customerTable">
    <thead>
        <tr>
            <th>ID</th>
            <th>Tên khách hàng</th>
            <th>Email</th>
            <th>Điện thoại</th>
            <th>Trạng thái</th>
            <th>Đơn hàng</th>
            <th>Ngày đăng ký</th>
            <th>Thao tác</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $sql = "SELECT dk.*, COUNT(c.id_cart) as so_don 
                FROM tbl_dangky dk 
                LEFT JOIN tbl_cart c ON dk.id_dangky = c.id_khachhang 
                GROUP BY dk.id_dangky 
                ORDER BY dk.id_dangky DESC";
        $result = mysqli_query($mysqli, $sql);
        if(mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_array($result)) {
        ?>
        <tr class="<?php echo $row['trang_thai']==0 ? 'row-locked' : ''; ?>">
            <td><strong>#<?php echo $row['id_dangky']; ?></strong></td>
            <td><?php echo htmlspecialchars($row['tenkhachhang']); ?></td>
            <td><?php echo htmlspecialchars($row['email']); ?></td>
            <td><?php echo htmlspecialchars($row['dienthoai']); ?></td>
            <td>
                <?php if($row['trang_thai']==1): ?>
                    <span class="badge badge-success">Hoạt động</span>
                <?php else: ?>
                    <span class="badge badge-danger">Bị khóa</span>
                <?php endif; ?>
            </td>
            <td>
                <?php if($row['so_don']>0): ?>
                    <span class="badge badge-info"><?php echo $row['so_don']; ?> đơn</span>
                <?php else: ?>
                    <span class="badge badge-secondary">Chưa mua</span>
                <?php endif; ?>
            </td>
            <td><?php echo date('d/m/Y', strtotime($row['ngay_dangky'])); ?></td>
            <td class="action-btns">
                <a href="index.php?action=quanlytaikhoan&query=chitiet&id=<?php echo $row['id_dangky']; ?>"
                   class="btn-view" title="Xem chi tiết">
                    <i class="fas fa-eye"></i>
                </a>
                <a href="index.php?action=quanlytaikhoan&query=sua&id=<?php echo $row['id_dangky']; ?>"
                   class="btn-edit" title="Sửa">
                    <i class="fas fa-edit"></i>
                </a>
                <!-- RESET password, KHÔNG hiện hay copy mật khẩu -->
                <a href="index.php?action=quanlytaikhoan&query=reset&id=<?php echo $row['id_dangky']; ?>"
                   class="btn-resetpw" title="Đặt lại mật khẩu">
                    <i class="fas fa-key"></i>
                </a>
                <a href="modules/quanlytaikhoan/xuly.php?xoa=<?php echo $row['id_dangky']; ?>"
                   onclick="return confirm('Xóa tài khoản này sẽ xóa toàn bộ đơn hàng liên quan! Bạn có chắc chắn?')"
                   class="btn-delete" title="Xóa">
                    <i class="fas fa-trash"></i>
                </a>
            </td>
        </tr>
        <?php
            }
        } else {
            echo '<tr><td colspan="8" style="text-align:center;padding:30px;color:#999;">Chưa có tài khoản nào</td></tr>';
        }
        ?>
    </tbody>
</table>