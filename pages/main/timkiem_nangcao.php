<?php
if (session_status() == PHP_SESSION_NONE) session_start();
include(__DIR__.'/../../admin/config/config.php'); // kết nối CSDL

// Nhận giá từ
$gia_tu = isset($_REQUEST['gia_tu']) ? intval($_REQUEST['gia_tu']) : 0;
$gia_den = isset($_REQUEST['gia_den']) ? intval($_REQUEST['gia_den']) : 0;
$dieu_kien = [];
if ($gia_tu > 0) $dieu_kien[] = "giasp >= $gia_tu";
if ($gia_den > 0 && $gia_den > $gia_tu) $dieu_kien[] = "giasp <= $gia_den";
$sql_where = count($dieu_kien) ? "AND ".implode(' AND ', $dieu_kien) : "";
?>

<div style="display:flex; gap:32px; margin-top:24px;">
    <!-- Sidebar Lọc Giá Nhanh -->
    <div style="min-width:220px;">
        <h4>Lọc giá nhanh</h4>
        <ul style="list-style:none; padding-left:0;">
            <?php
            $khoang = 5000000; // 5 triệu
            $min = 10000000;   // 10 triệu
            $max = 100000000;  // 100 triệu
            for ($gia = $min; $gia < $max; $gia += $khoang) {
                $gia2 = $gia + $khoang - 1;
                $active = ($gia_tu == $gia && $gia_den == $gia2) ? 'style="font-weight:bold;color:blue;"' : '';
                echo "<li style='margin:8px 0'>
                    <a $active href='index.php?quanly=timkiem_nangcao&gia_tu=$gia&gia_den=$gia2'>
                        ".number_format($gia / 1000000, 0)." - ".number_format(($gia2 + 1) / 1000000, 0)." triệu
                    </a>
                </li>";
            }
            ?>
        </ul>
    </div>
    <div style="flex:1;">
        <h3>Tìm kiếm sản phẩm theo khoảng giá</h3>
        <form action="index.php?quanly=timkiem_nangcao" method="POST" style="padding:12px 0;">
            <label>Giá từ:</label>
            <input type="number" name="gia_tu" min="0" step="5000000" placeholder="Nhập bội số 5.000.000 VNĐ" value="<?= $gia_tu > 0 ? $gia_tu : '' ?>">
            <label>đến:</label>
            <input type="number" name="gia_den" min="0" step="5000000" placeholder="Nhập bội số 5.000.000 VNĐ" value="<?= $gia_den > 0 ? $gia_den : '' ?>">
            <button type="submit" name="timkiem_nangcao">Tìm kiếm</button>
        </form>
        <?php
        // KẾT QUẢ DẠNG GRID THẺ SẢN PHẨM (không bảng)
        if (count($dieu_kien) > 0) {
            $sql = "SELECT * FROM tbl_sanpham, tbl_danhmuc WHERE tbl_sanpham.id_danhmuc = tbl_danhmuc.id_danhmuc $sql_where";
            $query = mysqli_query($mysqli, $sql);
            $rowcount = mysqli_num_rows($query);

            if ($rowcount > 0) {
                echo '<h4 style="margin-bottom:20px;">Kết quả tìm kiếm sản phẩm';
                if($gia_tu > 0) echo ' từ <b>'.number_format($gia_tu,0,',','.').' VNĐ</b>';
                if($gia_den > 0) echo ' đến <b>'.number_format($gia_den,0,',','.').' VNĐ</b>';
                echo '</h4>';
                echo '<div class="row">';
                while ($row = mysqli_fetch_array($query)) {
                    ?>
                    <div class="col-md-3" style="margin-bottom:22px;">
                        <a href="index.php?quanly=sanpham&id=<?php echo $row['id_sanpham'] ?>">
                            <img class="img img-responsive" width="100%" height="250px"
                                src="admin/modules/quanlysp/uploads/<?php echo $row['hinhanh'] ?>" alt="<?php echo $row['tensanpham'] ?>">
                            <p class="title_product" style="font-weight:bold; margin:10px 0 5px 0; text-align:center;">
                                <?php echo $row['tensanpham'] ?>
                            </p>
                            <p class="price_product" style="font-weight:bold;color:red; text-align:center;">
                                Giá: <?php echo number_format($row['giasp'], 0, ',', '.') . ' VNĐ' ?>
                            </p>
                            <p style="text-align:center;color:#d1d1d1;"><?php echo $row['tendanhmuc'] ?></p>
                        </a>
                    </div>
                    <?php
                }
                echo '</div>';
            } else {
                echo "<h4>Không tìm thấy sản phẩm nào phù hợp!</h4>";
            }
        }
        ?>
    </div>
</div>