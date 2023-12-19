<?php include '../index.php';
     require("../connectdb.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Đăng ký</title>
	<!-- Begin bootstrap cdn -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="	sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
	<!-- End bootstrap cdn -->

</head>
<body>


	<!-- <div class="alert alert-danger text-center" role="alert">Mẫu:Tài khoản hoặc mật khẩu không chính xác</div> -->
	<main style="min-height: 100vh; margin-top: 10%;">
		<div class="d-flex justify-content-center"><h1>Đăng ký</h1></div>
		<div class="d-flex justify-content-center">
			<form class="w-25" method="POST">
				<div class="mb-3">
				  <label for="username" class="form-label">Username</label>
				  <input type="text" class="form-control" id="username" name="username" placeholder="Nhập username" value="<?php echo isset($_POST['username']) ? $_POST['username'] : '' ?>" >
				</div>
				<div class="mb-3">
				    <label for="inputPassword" class="col-sm-2 col-form-label">Password</label>
				    <div class="col">
				      <input type="password" class="form-control" id="inputPassword" placeholder="Nhập Password" name="password" value="<?php echo isset($_POST['password']) ? $_POST['password'] : '' ?>">
				    </div>
				</div>
                    <div class="mb-3">
				    <label for="inputPasswordConfirm" class=" col-form-label">Password Confirm</label>
				    <div class="col">
				      <input type="password" class="form-control" id="inputPasswordConfirm" placeholder="Nhập Password Confirm" name="passwordConfirm" value="<?php echo isset($_POST['passwordConfirm']) ? $_POST['passwordConfirm'] : '' ?>">
				    </div>
				</div>
				<input type="submit" class="btn btn-primary" name="submitRegister" value="Đăng ký">
                    <input type="submit" class="btn btn-primary" name="submitLogin" value="Đăng nhập">
			  </form>
		</div>

          <?php
         
          if (isset($_POST['submitRegister'])) {
              
       $username = $_POST['username'];
       $password = $_POST['password'];
       $hashedPassword = md5($password);
       $passwordConfirm = $_POST['passwordConfirm'];
     
       if (!$username && !$password && !$passwordConfirm) {
           echo '<script>alert("Bạn cần phải nhập đầy đủ các thông tin ");</script>';
       } elseif (!$username) {
          echo '<script>alert("Tài khoản không được để trống ");</script>';
          //  echo '<p id = "error"> Tài khoản không được để trống </p>';
       } elseif (!$password) {
          echo '<script>alert("Mật khẩu không được để trống ");</script>';
          //  echo '<p id = "error"> Mật khẩu không được để trống </p>';
       } elseif (!$passwordConfirm) {
          echo '<script>alert("Mật khẩu nhập lại không được để trống");</script>';
          //  echo '<p id = "error"> Mật khẩu nhập lại không được để trống </p>';
       } elseif ($password != $passwordConfirm) {
          echo '<script>alert("Mật khẩu không trùng nhau");</script>';
          //  echo '<p id = "error"> Mật khẩu không trùng nhau </p>';
       }
       else {
          global $conn;
          $sql_check = "SELECT * FROM account WHERE username = '" . $username . "'";
          $result =  mysqli_query($conn,$sql_check);
          if ($result && mysqli_num_rows($result) > 0) {
               echo '<script>alert("Tài khoản đã tồn tại");</script>';
               // echo '<p id="error">Tài khoản đã tồn tại</p>';
           }
          else {
               $sql = "INSERT INTO account (username,password,role)
               VALUES ('$username', '$hashedPassword','user')";
               mysqli_query($conn,$sql);
               header('Location: dang_nhap.php');
          }
       }
     }

   if (isset($_POST['submitLogin'])) {
       header('Location: dang_nhap.php');
   }

?>

		
	</main>
	<?php
     //  include 'footer.php';
       ?>
</body>

	
</html>