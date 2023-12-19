<?php 
	include_once 'function.php';
	// dùng hàm kiểm tra đăng nhập trong file funciton
	// nếu đăng nhập rồi thì truy cập vào trang khóa học
	// còn chưa đăng nhập thì điều hướng ra trang đăng nhập
     if(isset($_POST['submitLogin'])){
          $username = $_POST['username'];
          $password = $_POST['password'];
          
          if(!checkLogin($username, $password)){
               
              header('Location: khoa_hoc.php');
          } else {
              echo '<div class="alert alert-danger text-center" role="alert">Tài khoản hoặc mật khẩu không chính xác</div>';
          }
      }
      
      if(isLogin()){
          header('Location: khoa_hoc.php');
      }
      
 ?>