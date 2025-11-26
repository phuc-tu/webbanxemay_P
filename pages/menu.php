<!-- ========== NAVBAR ĐẸP – FULL CODE ========== -->

<style>
  .menuu {
    display: flex;
    align-items: center;
  }

  .navbar-nav .nav-link {
    padding: 10px 15px !important;
  }

  .search-box {
    display: flex;
    align-items: center;
    margin-right: 15px;
  }

  .search-box input {
    height: 38px;
  }

  .search-box button {
    height: 38px;
    width: 38px;
    display: flex;
    justify-content: center;
    align-items: center;
    border-radius: 50%;
    padding: 0;
  }

  .cart a i {
    font-size: 22px;
    margin-left: 15px;
    color: white;
  }

  #nav .icon {
    padding: 5px 10px;
    color: white;
  }

  #nav .subnav {
    display: none;
    position: absolute;
    background: #333;
    list-style: none;
    padding: 10px 0;
    margin: 0;
    border-radius: 6px;
  }

  #nav li:hover .subnav {
    display: block;
  }

  #nav .subnav li a {
    color: white;
    display: block;
    padding: 8px 20px;
  }

  #nav .subnav li a:hover {
    background: #444;
  }
</style>


<?php
$sql_danhmuc = "SELECT * FROM tbl_danhmuc ORDER BY id_danhmuc DESC";
$query_danhmuc = mysqli_query($mysqli, $sql_danhmuc);
?>

<?php
if (isset($_GET['dangxuat']) && $_GET['dangxuat'] == 1) {
  unset($_SESSION['dangky']);
}
?>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark menuu" style="width:100%; position:fixed; top:0; z-index:1000; padding:0 20px;">

  <!-- Logo -->
  <a class="navbar-brand" href="index.php">
    <img src="images/logo_style3.png" height="60px">
  </a>

  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">

    <!-- Menu trái -->
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active">
        <a class="nav-link" href="index.php"><i class="fa fa-house"></i> Trang chủ</a>
      </li>

      <li class="nav-item"><a class="nav-link" href="index.php?quanly=gioithieu">Giới thiệu</a></li>

      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" data-toggle="dropdown">Sản phẩm</a>
        <div class="dropdown-menu">
          <?php while ($row_danhmuc = mysqli_fetch_array($query_danhmuc)) { ?>
            <a class="dropdown-item" href="index.php?quanly=danhmucsanpham&id=<?= $row_danhmuc['id_danhmuc'] ?>">
              <?= $row_danhmuc['tendanhmuc'] ?>
            </a>
          <?php } ?>
        </div>
      </li>

      <li class="nav-item"><a class="nav-link" href="index.php?quanly=tintuc"><i class="fa fa-newspaper"></i> Tin tức</a></li>
      <li class="nav-item"><a class="nav-link" href="index.php?quanly=lienhe"><i class="fa fa-envelopes-bulk"></i> Liên hệ</a></li>
      <li class="nav-item"><a class="nav-link" href="index.php?quanly=timkiem_nangcao"><i class="fa fa-filter"></i> Tìm kiếm nâng cao</a></li>
    </ul>

    <!-- Ô tìm kiếm -->
    <form class="search-box" action="index.php?quanly=timkiem" method="POST">
      <input class="form-control" type="search" placeholder="Tìm kiếm..." name="tukhoa">
      <button class="btn btn-outline-success" type="submit" name="timkiem">
        <i class="fa-solid fa-magnifying-glass"></i>
      </button>
    </form>

    <!-- Giỏ hàng -->
    <li class="cart">
      <a href="index.php?quanly=giohang">
        <i class="fa-solid fa-cart-shopping"></i>
      </a>
    </li>

    <!-- User dropdown -->
    <ul id="nav">
      <li>
        <a class="icon" href="#"><i class="fa-solid fa-user"></i></a>
        <ul class="subnav">
          <?php if (isset($_SESSION['dangky'])) { ?>
            <li><a href="index.php?quanly=lichsudonhang">Lịch sử đơn hàng</a></li>
            <li><a href="index.php?quanly=thaydoimatkhau">Đổi mật khẩu</a></li>
            <li><a href="index.php?dangxuat=1">Đăng xuất</a></li>
          <?php } else { ?>
            <li><a href="index.php?quanly=dangky">Đăng ký | Đăng nhập</a></li>
          <?php } ?>
        </ul>
      </li>
    </ul>

    <!-- Xin chào -->
    <li style="display:inline-block; list-style:none; margin-left:5px;">
      <?php
      if (isset($_SESSION['dangky'])) {
        echo '<span style="color:white;">Xin chào: ' . $_SESSION['dangky'] . '</span>';
      }
      ?>
    </li>

  </div>
</nav>

<!-- ========== END NAVBAR ========== -->
