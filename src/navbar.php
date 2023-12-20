<?php 
session_start();
 ?>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">ProjectPHP K71</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavDropdown">
      <ul class="navbar-nav">
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle active" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
             Tài khoản 
             <?php echo $_SESSION['user']['username'];?>
             
          </a>
          <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
          <?php echo $_SESSION['user']['role'] == "admin" ? '<li><a class="dropdown-item" href="quan_li_tk.php">Quản lí tài khoản</a></li>' : ''; ?>

          <li><a class="dropdown-item" href="doi_mat_khau.php">Đổi mật khẩu</a></li>
           <li><a class="dropdown-item" href="dang_xuat.php">Đăng xuất</a></li>
          </ul>
        </li>
      </ul>
    </div>
  </div>
</nav>