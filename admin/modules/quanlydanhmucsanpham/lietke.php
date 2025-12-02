<?php
$sql_lietke_danhmuc = "SELECT * FROM tbl_danhmuc ORDER BY thutu ASC, id_danhmuc DESC";
$query_lietke_danhmuc = mysqli_query($mysqli, $sql_lietke_danhmuc);
?>

<style>
.content-wrapper {
    padding: 20px;
}
.page-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    padding: 30px;
    border-radius: 15px;
    margin-bottom: 30px;
    color: white;
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
}
.stats-card {
    background: white;
    border-radius: 15px;
    padding: 25px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.08);
    margin-bottom: 30px;
}
.btn-add-new {
    background: linear-gradient(45deg, #28a745, #20c997);
    border: none;
    padding: 12px 25px;
    border-radius: 8px;
    color: white;
    font-weight: 600;
    transition: all 0.3s ease;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 8px;
}
.btn-add-new:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(40, 167, 69, 0.4);
    color: white;
}
.table-custom {
    background: white;
    border-radius: 15px;
    overflow: hidden;
    box-shadow: 0 5px 15px rgba(0,0,0,0.08);
}
.table-custom thead {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
}
.table-custom th {
    border: none;
    padding: 15px;
    font-weight: 600;
    text-transform: uppercase;
    font-size: 12px;
    letter-spacing: 1px;
}
.table-custom td {
    border: none;
    padding: 15px;
    vertical-align: middle;
    border-bottom: 1px solid #f0f0f0;
}
.table-custom tbody tr:hover {
    background-color: #f8f9fa;
    transform: scale(1.01);
    transition: all 0.2s ease;
}
.btn-action {
    padding: 8px 12px;
    border-radius: 6px;
    border: none;
    margin: 0 2px;
    transition: all 0.3s ease;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-width: 35px;
    height: 35px;
}
.btn-edit {
    background: linear-gradient(45deg, #ffc107, #fd7e14);
    color: white;
}
.btn-delete {
    background: linear-gradient(45deg, #dc3545, #e91e63);
    color: white;
}
.btn-action:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(0,0,0,0.2);
    color: white;
}
.category-name {
    font-weight: 600;
    color: #2c3e50;
    font-size: 16px;
}
.category-id {
    background: linear-gradient(45deg, #6c5ce7, #a29bfe);
    color: white;
    padding: 5px 10px;
    border-radius: 20px;
    font-weight: 600;
    font-size: 12px;
}
.category-order {
    background: linear-gradient(45deg, #00b894, #00cec9);
    color: white;
    padding: 5px 12px;
    border-radius: 20px;
    font-weight: 600;
    font-size: 14px;
}
.empty-state {
    text-align: center;
    padding: 60px 20px;
    background: white;
    border-radius: 15px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.08);
}
.empty-icon {
    font-size: 64px;
    color: #ddd;
    margin-bottom: 20px;
}
</style>

<div class="content-wrapper">
    <!-- Page Header -->
    <div class="page-header">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h2 class="mb-2">
                    <i class="fas fa-list-alt me-3"></i>
                    Quản lý danh mục sản phẩm
                </h2>
                <p class="mb-0 opacity-75">Quản lý và phân loại sản phẩm theo danh mục</p>
            </div>
            <a href="index.php?action=quanlydanhmucsanpham&query=them" class="btn-add-new">
                <i class="fas fa-plus"></i>
                Thêm danh mục mới
            </a>
        </div>
    </div>

    <!-- Stats Card -->
    <div class="stats-card">
        <div class="row">
            <div class="col-md-3">
                <div class="text-center">
                    <i class="fas fa-layer-group text-primary" style="font-size: 2rem;"></i>
                    <h4 class="mt-2 mb-0"><?php echo mysqli_num_rows($query_lietke_danhmuc); ?></h4>
                    <small class="text-muted">Tổng danh mục</small>
                </div>
            </div>
            <div class="col-md-3">
                <div class="text-center">
                    <i class="fas fa-motorcycle text-success" style="font-size: 2rem;"></i>
                    <h4 class="mt-2 mb-0">
                        <?php 
                        $sql_count_products = "SELECT COUNT(*) as total FROM tbl_sanpham";
                        $result = mysqli_query($mysqli, $sql_count_products);
                        $count = mysqli_fetch_array($result);
                        echo $count['total'];
                        ?>
                    </h4>
                    <small class="text-muted">Tổng sản phẩm</small>
                </div>
            </div>
            <div class="col-md-3">
                <div class="text-center">
                    <i class="fas fa-eye text-info" style="font-size: 2rem;"></i>
                    <h4 class="mt-2 mb-0">
                        <?php 
                        $sql_active = "SELECT COUNT(*) as total FROM tbl_danhmuc WHERE tendanhmuc != ''";
                        $result_active = mysqli_query($mysqli, $sql_active);
                        $active = mysqli_fetch_array($result_active);
                        echo $active['total'];
                        ?>
                    </h4>
                    <small class="text-muted">Danh mục hoạt động</small>
                </div>
            </div>
            <div class="col-md-3">
                <div class="text-center">
                    <i class="fas fa-chart-line text-warning" style="font-size: 2rem;"></i>
                    <h4 class="mt-2 mb-0">100%</h4>
                    <small class="text-muted">Tỷ lệ hiển thị</small>
                </div>
            </div>
        </div>
    </div>

    <!-- Data Table -->
    <?php if(mysqli_num_rows($query_lietke_danhmuc) > 0): ?>
    <div class="table-custom">
        <table class="table table-hover mb-0">
            <thead>
                <tr>
                    <th width="10%">
                        <i class="fas fa-hashtag me-2"></i>ID
                    </th>
                    <th width="50%">
                        <i class="fas fa-tag me-2"></i>Tên danh mục
                    </th>
                    <th width="15%">
                        <i class="fas fa-sort-numeric-down me-2"></i>Thứ tự
                    </th>
                    <th width="25%">
                        <i class="fas fa-cogs me-2"></i>Thao tác
                    </th>
                </tr>
            </thead>
            <tbody>
                <?php
                while($row = mysqli_fetch_array($query_lietke_danhmuc)){
                    $sql_count_sp = "SELECT COUNT(*) as total FROM tbl_sanpham WHERE id_danhmuc = ".$row['id_danhmuc'];
                    $result_count = mysqli_query($mysqli, $sql_count_sp);
                    $count_sp = mysqli_fetch_array($result_count);
                ?>
                <tr>
                    <td>
                        <span class="category-id">#<?php echo $row['id_danhmuc'] ?></span>
                    </td>
                    <td>
                        <div class="category-name"><?php echo $row['tendanhmuc'] ?></div>
                        <small class="text-muted">
                            <i class="fas fa-box me-1"></i>
                            <?php echo $count_sp['total']; ?> sản phẩm
                        </small>
                    </td>
                    <td>
                        <span class="category-order"><?php echo $row['thutu'] ?></span>
                    </td>
                    <td>
                        <div class="d-flex gap-1">
                            <a href="index.php?action=quanlydanhmucsanpham&query=sua&iddanhmuc=<?php echo $row['id_danhmuc'] ?>" 
                               class="btn-action btn-edit" 
                               title="Chỉnh sửa danh mục">
                                <i class="fas fa-edit"></i>
                            </a>
                            <a href="modules/quanlydanhmucsanpham/xuly.php?iddanhmuc=<?php echo $row['id_danhmuc'] ?>" 
                               class="btn-action btn-delete" 
                               onclick="return confirm('⚠️ Bạn có chắc chắn muốn xóa danh mục &quot;<?php echo $row['tendanhmuc'] ?>&quot;?\n\n⚠️ Lưu ý: Tất cả sản phẩm trong danh mục này cũng sẽ bị ảnh hưởng!')" 
                               title="Xóa danh mục">
                                <i class="fas fa-trash"></i>
                            </a>
                        </div>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
    <?php else: ?>
    <div class="empty-state">
        <div class="empty-icon">
            <i class="fas fa-folder-open"></i>
        </div>
        <h4 class="mb-3">Chưa có danh mục nào</h4>
        <p class="text-muted mb-4">Bắt đầu bằng cách tạo danh mục đầu tiên cho cửa hàng của bạn</p>
        <a href="index.php?action=quanlydanhmucsanpham&query=them" class="btn-add-new">
            <i class="fas fa-plus me-2"></i>
            Tạo danh mục đầu tiên
        </a>
    </div>
    <?php endif; ?>
</div>

<script>
// Animation load hàng
document.addEventListener('DOMContentLoaded', function() {
    const rows = document.querySelectorAll('tbody tr');
    rows.forEach((row, index) => {
        row.style.opacity = '0';
        row.style.transform = 'translateY(20px)';
        setTimeout(() => {
            row.style.transition = 'all 0.5s ease';
            row.style.opacity = '1';
            row.style.transform = 'translateY(0)';
        }, index * 100);
    });
});

function confirmDelete(categoryName, categoryId) {
    if (confirm(`⚠️ Bạn có chắc chắn muốn xóa danh mục "${categoryName}"?\n\n⚠️ Lưu ý: Tất cả sản phẩm trong danh mục này cũng sẽ bị ảnh hưởng!`)) {
        window.location.href = `modules/quanlydanhmucsanpham/xuly.php?iddanhmuc=${categoryId}`;
    }
}
</script>
