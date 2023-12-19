<?php
//  include '../index.php';
     require("../connectdb.php");
     include_once '../function.php';
if (!isLogin()) {
    header('Location: dang_nhap.php');
    exit();
}

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
		<div class="d-flex justify-content-center"><h1>Đổi mật khẩu</h1></div>
		<div class="d-flex justify-content-center">
			<form class="w-25" method="POST">
				<div class="mb-3">
				  <label for="OldPassword" class="form-label">Old Password </label>
				  <input type="text" class="form-control" id="OldPassword" name="OldPassword" placeholder="Nhập Old Password" value="<?php echo isset($_POST['OldPassword']) ? $_POST['OldPassword'] : '' ?>" >
				</div>
				<div class="mb-3">
				    <label for="inputPassword" class=" col-form-label">New Password</label>
				    <div class="col">
				      <input type="password" class="form-control" id="inputPassword" placeholder="Nhập New Password" name="NewPassword" value="<?php echo isset($_POST['NewPassword']) ? $_POST['NewPassword'] : '' ?>">
				    </div>
				</div>
                    <div class="mb-3">
				    <label for="inputPasswordConfirm" class=" col-form-label"> New Password Confirm</label>
				    <div class="col">
				      <input type="password" class="form-control" id="inputPasswordConfirm" placeholder="Nhập New Password Confirm" name="NewPasswordConfirm" value="<?php echo isset($_POST['NewPasswordConfirm']) ? $_POST['NewPasswordConfirm'] : '' ?>">
				    </div>
				</div>
				<input type="submit" class="btn btn-primary" name="submitOk" value="Đổi mật khẩu">
                    <input type="submit" class="btn btn-primary" name="submitCancel" value="Hủy">
			  </form>
		</div>

          <?php
         
          if (isset($_POST['submitOk'])) {
      
           $OldPassword = $_POST['OldPassword'];
          // $OldPassword = 1;
      
       $hashedPasswordOld = md5($OldPassword);
       $NewPassword = $_POST['NewPassword'];
       $hashedPassword = md5($NewPassword);
     //   echo( $hashedPassword);
       $NewPasswordConfirm = $_POST['NewPasswordConfirm'];
     //   echo($_SESSION['user']['hashedPassword']);
     //   echo($hashedPasswordOld);
       if (!$OldPassword && !$NewPassword && !$NewPasswordConfirm) {
           echo '<script>alert("Bạn cần phải nhập đầy đủ các thông tin ");</script>';
       } elseif (!$OldPassword) {
          echo '<script>alert("Mật khẩu cũ không được để trống ");</script>';
          //  echo '<p id = "error"> Tài khoản không được để trống </p>';
       } elseif (!$NewPassword) {
          echo '<script>alert("Mật khẩu mới không được để trống ");</script>';
          //  echo '<p id = "error"> Mật khẩu không được để trống </p>';
       } elseif (!$NewPasswordConfirm) {
          echo '<script>alert("Mật khẩu nhập lại không được để trống");</script>';
          //  echo '<p id = "error"> Mật khẩu nhập lại không được để trống </p>';
       } elseif ($NewPasswordConfirm != $NewPassword) {
          echo '<script>alert("Mật khẩu mới không trùng nhau");</script>';
          //  echo '<p id = "error"> Mật khẩu không trùng nhau </p>';
       }
       elseif( $_SESSION['user']['hashedPassword'] == $hashedPassword){
          echo '<script>alert("Mật khẩu cũ không được  trùng mật khẩu mới");</script>';
       }
       else {
          global $conn;
          $idUserNow = $_SESSION['user']['id'];
          $sql_check = "SELECT * FROM account WHERE password = '" . $hashedPasswordOld . "' AND idUser = '" . $idUserNow . "'";
          
          $result =  mysqli_query($conn,$sql_check);

          if ($result && mysqli_num_rows($result) <= 0) {
               echo '<script>alert("Mật khẩu cũ không chính xác");</script>';
               // echo '<p id="error">Tài khoản đã tồn tại</p>'; 
           }
          else {

               $sqlUpdate =  "UPDATE account
                SET password='" .$hashedPassword . "'
               WHERE password='" .$hashedPasswordOld . "' AND idUser = '" . $idUserNow . "'";
             
               mysqli_query($conn,$sqlUpdate);
               echo '<script>alert("Đổi mật khẩu thành công");</script>';
          }
       }
     }

   if (isset($_POST['submitCancel'])) {
       header('Location: khoa_hoc.php');
   }

?>

		
	</main>
	<?php
     //  include 'footer.php';
       ?>
</body>

	
</html>