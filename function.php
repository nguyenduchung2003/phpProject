<?php
     
	include 'connectdb.php';
     if (session_status() == PHP_SESSION_NONE) {
          session_start();
      }
     // session_start();
    // Begin Login function
	// function isLogin(){
	// 	// hàm kiểm tra đã đăng nhập chưa
     //      if(isset($_SESSION['user'])){
     //           return true;
     //      }else{
     //           return false;
     //      } 
          
	// }
     if (!function_exists('isLogin')) {
          function isLogin() {
               if(isset($_SESSION['user'])){
                    return true;
               }else{
                    return false;
               }
          }
      }
    // begin checkLogin
//     if (!function_exists('checkLogin')) {
     
     function checkLogin($username, $password)
	{
      
          global $conn;
          $hashedPassword = md5($password);
          $sql_check = "SELECT * FROM account WHERE username = '" . $username . "' AND  password = '" . $hashedPassword . "'";
          $result =  mysqli_query($conn,$sql_check);
          $check = false ;
          if($result && mysqli_num_rows($result) > 0){
              while($row = mysqli_fetch_array( $result )) {   
                   $check = false;
                    $_SESSION['user'] = ['username' => $username,'hashedPassword' => $hashedPassword, 'id' => $row['idUser'],'role' => $row['role'], 'isLogin' =>true];
              }
           }
           else {
               $check = true;
           }
         
           return $check;
		// hàm kiểm tra tài khoản nhập đã đúng chưa
	}
//  }
    
    // end checkLogin
    
?> 