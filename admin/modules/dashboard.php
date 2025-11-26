<?php
if (session_status() === PHP_SESSION_NONE) session_start();
if (!isset($_SESSION['dangnhap']) || !isset($_SESSION['admin_status'])) {
    header('Location: ../login.php'); // Đường dẫn login nếu chưa đăng nhập
    exit();
}
// Chỉ admin (admin_status = 0)
if ($_SESSION['admin_status'] != 0) {
    echo 'Bạn không có quyền truy cập chức năng này!';
    exit();
}
?>
<div style="background:#fff;border-radius:8px;max-width:650px;margin:40px auto;padding:30px 35px;box-shadow:0 2px 16px #0002">
    <h3 style="color:#1976d2">Thống kê bán hàng</h3>
    <label>
        Mốc thời gian:
        <select class="select-date" style="padding:6px 12px;font-size:16px">
            <option value="7ngay">7 ngày qua</option>
            <option value="30ngay">30 ngày qua</option>
            <option value="90ngay">90 ngày qua</option>
            <option value="365ngay">365 ngày qua</option>
        </select>
    </label>

    <!-- (Nếu muốn hiển thị biểu đồ bằng js, thêm chart tại đây) -->
    <div id="chart" style="height:250px;margin:30px 0 10px 0"></div>

    <!-- VÙNG HIỆN TOP 5 SẢN PHẨM -->
    <div id="top5sp" style="margin-top:40px"></div>
</div>

<script>
// --- Lấy top 5 sản phẩm & render giao diện ---
function loadTop5() {
    let thoigian = document.querySelector('.select-date').value;
    fetch('modules/thongke.php', {
        method: 'POST',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        body: 'thoigian=' + encodeURIComponent(thoigian)
    })
    .then(res => res.json())
    .then(data => {
        let html = "<h4 style='margin-bottom: 15px;'>Top 5 sản phẩm bán chạy nhất</h4>";
        if(Array.isArray(data) && data.length > 0){
            html += `<table border="1" cellpadding="8" cellspacing="0" style="width:100%; border-collapse:collapse; text-align:center;">
                <thead style="background:#e3f2fd">
                    <tr>
                        <th>STT</th>
                        <th>Hình ảnh</th>
                        <th>Tên sản phẩm</th>
                        <th>Số lượng đã bán</th>
                    </tr>
                </thead>
                <tbody>`;
            data.forEach((sp, i) => {
                // ...existing code...
html += `<tr>
    <td>${i+1}</td>
    <td>
        <img src="uploads/${sp.image}" style="height:46px;max-width:72px;border-radius:6px;background:#fafafa;padding:2px;box-shadow:0 1px 4px #0002" />
    </td>
    <td style="font-weight:bold">${sp.name}</td>
    <td style="color:#e53935; font-weight:bold">${sp.sold}</td>
</tr>`;
// ...existing code...
            });
            html += `</tbody></table>`;
        } else if(data && data.error){
            html += `<div style="color:red;padding:10px;">Lỗi: ${data.error}</div>`;
        } else {
            html += "<div>Không có dữ liệu</div>";
        }
        document.getElementById('top5sp').innerHTML = html;
    })
    .catch(err => {
        document.getElementById('top5sp').innerHTML = "Lỗi khi lấy dữ liệu!";
    });
}
document.querySelector('.select-date').addEventListener('change', loadTop5);
window.onload = loadTop5;
</script>