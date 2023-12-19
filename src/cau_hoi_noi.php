<?php 
    // include '../function.php'; 
    include '../connectdb.php';
    include_once '../function.php';
     if (!isLogin()) {
    header('Location: dang_nhap.php');
    exit();
}
//     session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Thêm câu hỏi</title>
	<!-- Begin bootstrap cdn -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="	sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
	<!-- End bootstrap cdn -->
     <style>
          /* #inputFieldsContainerAll{
               display: flex;
               
              
          }
          #inputFieldsContainer{
               display: flex;
          } */
     </style>
</head>
<body>
    <?php 
        // include 'navbar.php';
    ?>
	<main style="min-height: 100vh; max-width: 100%;">
			<div id="action" style="margin: 20px 0 0 13%;">
            <p class="h3">Khóa học 
                <!-- tên khóa học -->
            </p>
            <?php 
            $a=  $_GET['id_khoa_hoc'];
            if($a){
               echo ' <a href="bien_tap.php?id_khoa_hoc='.$a.'" class="btn btn-primary">Trở lại</a>' ;
            }
            else {
               header('Location: khoa_hoc.php');
               exit();
            }
           
            ?>
			
           <form action="" method="POST" enctype="multipart/form-data">
			</div>
            <div style="margin: 20px 13%;">
                <div class="form-group">
                    <label for="name_quiz"><span style="color: red;">*</span>Nhập tên câu hỏi</label>
                    <input class="form-control"  type="text" name="ten_cau_hoi" id="" value="<?php echo isset($_POST['ten_cau_hoi']) ? $_POST['ten_cau_hoi'] : '' ?>">
                </div>
                <div class="form-group">
                    <label for="name_quiz">Ảnh cho câu hỏi</label>
                    <input class="form-control"  type="file" name="file_tai_len" id="" value="<?php echo isset($_POST['file_tai_len']) ? $_POST['file_tai_len'] : '' ?>">
                </div>

                
                <div class="form-group">
                    <label for="name_quiz">Dạng câu hỏi</label>
                    <select class="form-control" name="dang_cau_hoi" id="dang_cau_hoi">
                         <option value="Select">Select</option>
                    </select>
                </div>
                <div style='margin: 20px 0 0 0;' class='input-group mb-3'>   
              
                <!-- <input name='da' type='text' class='form-control' placeholder='Nhập đáp án' value=""> -->
                  <input name='slda' type='number' class='form-control' placeholder='Nhập số lượng câu hỏi và đáp án' value="<?php echo isset($_POST['slda']) ? $_POST['slda'] : '' ?>" >
             
                </div>
                <input type="submit" class="btn btn-primary" name="btnSlDa" value="Xác nhận">
                <!-- <div id="inputFieldsContainerAll">
                <div id="inputFieldsContainer">
          
                </div>
                </div> -->
              
               <div>
              

               </div>
               
                <?php
                
                    if(isset($_POST['btn'])){
                        $a =  $_GET['id_khoa_hoc'];
                        $ten_cau_hoi = $_POST['ten_cau_hoi'];
                        $trangthai = 0;
                        ($_SESSION['user']['id'] == "3") ? $trangthai = 1 : $trangthai = 0;
                        global $conn;
                        $soLuongDa = $_POST['slda'];
                        $dang_cau_hoi = $_POST['dang_cau_hoi'];
                        // $da = $_POST['da'];
                        $file_tai_len = "";
                        if (isset($_FILES['file_tai_len']) && $_FILES['file_tai_len']['error'] === 0) {
                            $file_tai_len = $_FILES['file_tai_len']['name'];
                            move_uploaded_file($_FILES['file_tai_len']['tmp_name'], 'uploads/' . $file_tai_len);
                        }
                    
                        if (empty($ten_cau_hoi) || empty($soLuongDa)) {
                            echo ('<div class="alert alert-warning text-center" role="alert">Thêm câu hỏi thất bại</div>');
                        } else {
                            $sql = "INSERT INTO cauhoi (cauhoi, anh, dangcauhoi, trangthai, idUser, idKhoaHoc)
                                    VALUES ('" . $ten_cau_hoi . "','" . $file_tai_len . "','" . $dang_cau_hoi . "','" . $trangthai . "','" . $_SESSION["user"]["id"] . "','" . $a . "')";
                            $result = mysqli_query($conn, $sql);
                    
                            if (!$result) {
                                echo "Lỗi insert cauhoi: " . mysqli_error($conn);
                            } else {
                                // Get the last inserted ID
                                $lastIdQuery = "SELECT MAX(id_cauhoi) AS LastId FROM cauhoi";
                                $resultIds = mysqli_query($conn, $lastIdQuery);
                    
                                if ($resultIds) {
                                    $row = mysqli_fetch_assoc($resultIds);
                                    $lastId = $row['LastId'];
                                    
                                    for ($i = 1; $i <= $soLuongDa; $i++) {
                                        $dapAnValue = $_POST['dap_an_' . $i];
                                        $cauHoiValue = $_POST['cau_hoi_' . $i];
                                        $dapAnCorrect = trim($dapAnValue . "-" . $cauHoiValue);
                                        $checkDapAnValue = 1;
                    
                                        $sql2 = "INSERT INTO dapan (dapan, dapandung, id_cauhoi) VALUES ('$dapAnCorrect', '$checkDapAnValue', '$lastId')";
                    
                                        $result2 = mysqli_query($conn, $sql2);
                    
                                        if (!$result2) {
                                            echo "Lỗi dap an: " . mysqli_error($conn);
                                        }
                                    }
                                    echo ('<div class="alert alert-success text-center" role="alert">Thêm câu hỏi thành công</div>');
                                } else {
                                    echo "Lỗi truy vấn id max: " . mysqli_error($conn);
                                }
                            }
                        }
                    }



                    // mẫu thông báo thêm câu hỏi thành công và thất bại
                    // <div class="alert alert-warning text-center" role="alert">Thêm câu hỏi thất bại</div>
                    // <div class="alert alert-success text-center" role="alert">Thêm câu hỏi thành công</div>
                 
                    ?>

    

     
               <?php
                   if (isset($_POST['btnSlDa'])) {
                    $soLuongDa = $_POST['slda'];
                
                    for ($i = 1; $i <= $soLuongDa; $i++) {
 
                    //     echo '<form method="post"></form>';
                         echo "<div >";
                         echo '<input type="text" class="form-control" placeholder="Câu hỏi ' . $i . '" name="cau_hoi_'. $i .'">';
                         echo '<input type="text" class="form-control" placeholder="Đáp án ' . $i . '" name="dap_an_'. $i .'">'; 
                         echo '<br>'; 
                         echo "</div>";
                         // echo '</form>';

                         
                    }
                }
               ?>
          <div style="margin: 20px 0 0 0;" class="d-grid">
                    <input class="btn btn-primary btn-block" name="btn" type="submit" value="Thêm câu hỏi">
                </div>
               
            </div>
            </form>
         
	</main>
     <div class="alert-primary text-center p-2" style="margin-top: 15px;" role="alert">ProjectPHP - K71</div>

</body>

</html>