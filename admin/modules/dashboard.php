<div class="content-area">
    <div class="welcome-card">
        <h2>👋 Chào mừng bạn đến trang quản trị!</h2>
        <p>Dashboard hiển thị tổng quan về hoạt động của website bán xe máy 3TH MOTORBIKES SHOP</p>
    </div>

    <!-- STATS CARDS -->
    <div class="stats-grid">
        <!-- Ví dụ 1 card -->
        <div class="stat-card">
            <div class="stat-icon blue">
                <i class="fas fa-shopping-cart"></i>
            </div>
            <div class="stat-details">
                <h4>Tổng đơn hàng</h4>
                <div class="stat-number">
                    <?php
                    $sql_donhang = "SELECT COUNT(*) as total FROM tbl_cart";
                    $query_donhang = mysqli_query($mysqli, $sql_donhang);
                    $row_donhang = mysqli_fetch_array($query_donhang);
                    echo number_format($row_donhang['total']);
                    ?>
                </div>
                <div class="stat-change positive">
                    <i class="fas fa-arrow-up"></i> 12% so với tháng trước
                </div>
            </div>
        </div>
        <!-- ... 3 stat-card khác cho sản phẩm, doanh thu, đơn chờ xử lý ... -->
    </div>

    <!-- CHARTS ROW -->
    <div class="charts-row">
        <!-- Thống kê bán hàng -->
        <div class="chart-card chart-large">
            <div class="chart-header">
                <div>
                    <h3 class="chart-title">📊 THỐNG KÊ BÁN HÀNG</h3>
                    <p class="chart-subtitle">Theo dõi doanh thu và đơn hàng - 
                        <span id="text-date" style="font-weight:600;color:#3498db;"></span>
                    </p>
                </div>
                <select class="select-date">
                    <option value="7ngay">7 ngày qua</option>
                    <option value="30ngay">30 ngày qua</option>
                    <option value="90ngay">90 ngày qua</option>
                    <option value="365ngay" selected>365 ngày qua</option>
                </select>
            </div>
            <div id="chart"></div>
        </div>

        <!-- Top sản phẩm -->
        <div class="chart-card chart-small">
            <div class="chart-header">
                <h3 class="chart-title">🏆 Top Sản Phẩm Bán Chạy</h3>
            </div>
            <div id="donut-chart"></div>
            <div class="legend-list">
                <?php
                $sql_top = "SELECT tbl_sanpham.tensanpham, SUM(tbl_cart_details.soluongmua) as total 
                            FROM tbl_cart_details 
                            INNER JOIN tbl_sanpham ON tbl_cart_details.id_sanpham = tbl_sanpham.id_sanpham 
                            GROUP BY tbl_cart_details.id_sanpham 
                            ORDER BY total DESC 
                            LIMIT 5";
                $query_top = mysqli_query($mysqli, $sql_top);
                $colors = ['#667eea', '#2ecc71', '#f39c12', '#e74c3c', '#9b59b6'];
                $index = 0;
                if ($query_top && mysqli_num_rows($query_top) > 0) {
                    while($row_top = mysqli_fetch_array($query_top)) {
                        $total = isset($row_top['total']) ?  (int)$row_top['total'] : 0;
                        $tensanpham = isset($row_top['tensanpham']) ? $row_top['tensanpham'] : 'N/A';
                ?>
                    <div class="legend-item">
                        <span class="legend-color" style="background: <?php echo $colors[$index]; ?>"></span>
                        <span class="legend-label"><?php echo htmlspecialchars($tensanpham); ?></span>
                        <span class="legend-value"><?php echo number_format($total); ?> sp</span>
                    </div>
                <?php
                        $index++;
                        if ($index >= 5) break;
                    }
                } else {
                    echo '<p style="text-align: center; color: #7f8c8d; padding: 20px;">Chưa có dữ liệu</p>';
                }
                ?>
            </div>
        </div>
    </div>

    <!-- Đơn hàng gần đây -->
    <div class="chart-card">
        <div class="chart-header">
            <h3 class="chart-title">📦 Đơn Hàng Gần Đây</h3>
            <a href="index.php?action=quanlydonhang&query=lietke" class="btn-view-all">Xem tất cả →</a>
        </div>
        <div class="table-responsive">
            <table class="modern-table">
                <thead>
                    <tr>
                        <th>Mã ĐH</th>
                        <th>Khách hàng</th>
                        <th>Số điện thoại</th>
                        <th>Tổng tiền</th>
                        <th>Thanh toán</th>
                        <th>Trạng thái</th>
                        <th>Ngày đặt</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql_recent = "SELECT * FROM tbl_cart ORDER BY cart_date DESC LIMIT 5";
                    $query_recent = mysqli_query($mysqli, $sql_recent);
                    
                    if ($query_recent && mysqli_num_rows($query_recent) > 0) {
                        while($row_recent = mysqli_fetch_array($query_recent)) {
                            $id_khachhang = (int)$row_recent['id_khachhang'];
                            $sql_customer = "SELECT tenkhachhang, dienthoai FROM tbl_dangky WHERE id_dangky = $id_khachhang";
                            $query_customer = mysqli_query($mysqli, $sql_customer);
                            $row_customer = mysqli_fetch_array($query_customer);
                            $customer_name = $row_customer ?  $row_customer['tenkhachhang'] : 'Khách vãng lai';
                            $customer_phone = $row_customer ? $row_customer['dienthoai'] : 'Chưa có';

                            $code_cart = $row_recent['code_cart'];
                            $sql_total = "SELECT SUM(cd.soluongmua * sp.giasp) as total
                                          FROM tbl_cart_details cd
                                          INNER JOIN tbl_sanpham sp ON cd.id_sanpham = sp.id_sanpham
                                          WHERE cd.code_cart = '$code_cart'";
                            $query_total = mysqli_query($mysqli, $sql_total);
                            $row_total = mysqli_fetch_array($query_total);
                            $total_amount = $row_total['total'] ? (float)$row_total['total'] : 0;

                            // Trạng thái
                            $status_class = '';
                            $status_text = '';
                            $cart_status = (int)$row_recent['cart_status'];
                            switch($cart_status) {
                                case 0: $status_class = 'status-pending'; $status_text = 'Chờ xử lý'; break;
                                case 1: $status_class = 'status-completed'; $status_text = 'Hoàn thành'; break;
                                default: $status_class = 'status-cancelled'; $status_text = 'Đã hủy';
                            }
                            // Phương thức thanh toán
                            $payment_method = '';
                            switch($row_recent['cart_payment']) {
                                case 'tienmat': $payment_method = '💵 Tiền mặt'; break;
                                case 'chuyenkhoan': $payment_method = '🏦 Chuyển khoản'; break;
                                case 'vnpay': $payment_method = '💳 VNPay'; break;
                                default: $payment_method = $row_recent['cart_payment'];
                            }
                            $cart_date = $row_recent['cart_date'];
                    ?>
                    <tr>
                        <td><strong>#<?php echo htmlspecialchars($code_cart); ?></strong></td>
                        <td><?php echo htmlspecialchars($customer_name); ?></td>
                        <td><?php echo htmlspecialchars($customer_phone); ?></td>
                        <td><strong><?php echo number_format($total_amount, 0, ',', '.'); ?>đ</strong></td>
                        <td><?php echo $payment_method; ?></td>
                        <td><span class="status-badge <?php echo $status_class; ?>"><?php echo $status_text; ?></span></td>
                        <td><?php echo date('d/m/Y H:i', strtotime($cart_date)); ?></td>
                        <td>
                            <a href="index.php?action=quanlydonhang&query=xemdonhang&code=<?php echo htmlspecialchars($code_cart); ?>" class="btn-action btn-view" title="Xem chi tiết">
                                <i class="fas fa-eye"></i>
                            </a>
                        </td>
                    </tr>
                    <?php 
                        }
                    } else {
                        echo '<tr><td colspan="8" style="text-align: center; padding: 30px; color: #7f8c8d;">Chưa có đơn hàng nào</td></tr>';
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- MORRIS CHART JS -->
    <script>
    $(document).ready(function() {
        thongke();

        var chart = new Morris.Area({
            element: 'chart',
            xkey: 'date',
            ykeys: ['order', 'sales', 'quantity'],
            labels: ['Đơn hàng', 'Doanh thu', 'Số lượng bán ra'],
            lineColors: ['#3498db','#2ecc71','#e67e22'],
            fillOpacity: 0.18,
            gridTextColor: '#666',
            gridTextSize: 14,
            resize: true,
            behaveLikeLine: true,
            pointFillColors: ['#2980b9','#27ae60','#e67e22'],
            pointStrokeColors: ['#fff'],
        });

        $('.select-date').change(function() {
            var thoigian = $(this).val();
            var text = '';

            if (thoigian === '7ngay') text = '7 ngày qua';
            else if (thoigian === '30ngay') text = '30 ngày qua';
            else if (thoigian === '90ngay') text = '90 ngày qua';
            else text = '365 ngày qua';

            $.ajax({
                url: "modules/thongke.php",
                method: "POST",
                dataType: "JSON",
                data: { thoigian: thoigian },
                success: function(data) {
                    chart.setData(data);
                    $('#text-date').text(text);
                }
            });
        });

        function thongke() {
            $.ajax({
                url: "modules/thongke.php",
                method: "POST",
                dataType: "JSON",
                success: function(data) {
                    chart.setData(data);
                    $('#text-date').text('365 ngày qua');
                }
            });
        }
    });
    </script>
</div>
<!-- CHÈN CSS FIX TRÀN MORRIS -->
<style>
.chart-card {background: #fff;border-radius:18px;box-shadow:0 8px 32px rgba(44,62,80,.08);margin-bottom:32px;padding:32px 24px;position:relative;overflow:hidden;}
.chart-header {display:flex;justify-content:space-between;align-items:center;margin-bottom:16px;}
#chart {min-height:300px;max-height:340px;height:320px;width:100%;overflow:hidden;}
.chart-card svg, #chart svg {max-height:320px !important;min-height:220px !important;width:100% !important;}
.morris-hover {border-radius:10px !important;background:#2d3436 !important;color:#fff !important;font-size:15px;padding:12px !important;box-shadow:0 2px 10px rgba(0,0,0,0.10);}
@media (max-width:900px){.chart-card{padding:18px 6px;}#chart{height:220px;min-height:220px;max-height:240px;}}
</style>