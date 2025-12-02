<?php
error_reporting(E_ALL & ~E_WARNING & ~E_NOTICE);
ini_set('display_errors', 0);
session_start();
if (!isset($_SESSION['dangnhap'])) {
    header('Location:login.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Admin Panel - 3TH MOTORBIKES SHOP</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- CSS -->
    <link rel="stylesheet" href="css/styleadmin.css">

    <!-- jQuery -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">

    <!-- Morris Chart -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">

    <!-- CKEditor -->
    <script src="https://cdn.ckeditor.com/4.22.1/full/ckeditor.js"></script>
</head>
<body>

<?php
include("config/config.php");
include("modules/header.php");

// Routing
$action = isset($_GET['action']) ? $_GET['action'] : '';
$query  = isset($_GET['query'])  ? $_GET['query']  : '';

if (isset($_GET['dangxuat']) && $_GET['dangxuat'] == 1) {
    unset($_SESSION['dangnhap']);
    header('Location:login.php');
    exit();
}

if ($action != '' && $query != '') {
    $file = "modules/".$action."/".$query.".php";

    if (file_exists($file)) {
        include($file);
    } else {
        echo '<div class="content-area">
                <div style="background:#ffebee;padding:20px;border-radius:10px;color:#c62828;">
                <i class="fas fa-exclamation-triangle"></i>
                <strong>Lỗi:</strong> File không tồn tại: '.$file.'
                </div>
              </div>';
    }
} else {
    include("modules/dashboard.php");
}

include("modules/footer.php");
?>

<!-- Sidebar Toggle -->
<script>
function toggleSidebar() {
    const sidebar = document.getElementById('adminSidebar');
    const mainWrapper = document.getElementById('mainWrapper');

    sidebar.classList.toggle('collapsed');
    mainWrapper.classList.toggle('expanded');

    localStorage.setItem(
        'sidebarState',
        sidebar.classList.contains('collapsed') ? 'collapsed' : 'expanded'
    );
}

window.addEventListener('DOMContentLoaded', function() {
    if (localStorage.getItem('sidebarState') === 'collapsed') {
        document.getElementById('adminSidebar').classList.add('collapsed');
        document.getElementById('mainWrapper').classList.add('expanded');
    }
});
</script>

<!-- CKEditor -->
<script>
CKEDITOR.replace('tomtat');
CKEDITOR.replace('noidung');
CKEDITOR.replace('thongtinlienhe');
CKEDITOR.replace('gioithieu');
</script>

<!-- Morris Chart -->
<script>
$(document).ready(function() {

    thongke();

    var chart = new Morris.Area({
        element: 'chart',
        xkey: 'date',
        ykeys: ['order', 'sales', 'quantity'],
        labels: ['Đơn hàng', 'Doanh thu', 'Số lượng bán ra'],
        resize: true
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

<!-- Preview Image -->
<script>
function imagePreview(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            $('#preview').html('<img src="'+e.target.result+'" width="300">');
        }
        reader.readAsDataURL(input.files[0]);
    }
}

$("#image").change(function() {
    imagePreview(this);
});
</script>

</body>
</html>
