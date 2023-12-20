<?php include_once("../connectdb.php"); ?>
<?php include_once 'navbar.php';
include_once '../function.php';
if (!isLogin()) {
    header('Location: dang_nhap.php');
    exit();
}?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Xem trước</title>
	<!-- Begin bootstrap cdn -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="	sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
	<!-- End bootstrap cdn -->
     <style>
         .x {
          display: flex;
          flex-direction: column-reverse;
          justify-content: center;
          align-items: center;
         }
        
        
     </style>
</head>
<body>
	
	<main style="min-height: 100vh; width: 100%;">
		<div class="" style="text-align: center;">
			<h2>Khóa học</h2>
               <?php
               $a=  $_GET['id_khoa_hoc'];
               $id_cauhoi = $_GET['id_cau_hoi'];
               if(!$a){
                    header('Location: khoa_hoc.php');
                    exit();
               }
               else if(!$id_cauhoi){
                    header('Location: bien_tap.php');
                    exit();
               }
               global $conn;
               $sql ="SELECT * FROM khoahoc";
               $result =  mysqli_query($conn,$sql);
               if($result){
                   while($row = mysqli_fetch_array( $result )) {   
                    if($row['idKhoaHoc'] == $a){
                     echo(' <h5 class="card-title">'.$row['tenKhoaHoc'].'</h5>')  ; 
                    };
                
                }
            }
            echo ' <a href="bien_tap.php?id_khoa_hoc='.$a.'" class="btn btn-primary">Trở lại</a>' 

                ?> 
     
    
                
		</div>
		<div class="row row-cols-1 row-cols-md-3 g-4 x" style="margin: 0 auto; width: 80%;">
		<!-- begin khóa học -->
          <table class="table table-striped">
          <tr>
                    
                    <th>Câu hỏi</th>               
          </tr>
        
                   <?php
                   global $conn;
                   $sql = "SELECT *
                           FROM cauhoi 
                           JOIN dapan ON cauhoi.id_cauhoi = dapan.id_cauhoi
                           WHERE cauhoi.id_cauhoi = $id_cauhoi AND cauhoi.idKhoaHoc = $a";
               
                   $result =  mysqli_query($conn, $sql);
                   $checkUpdate=  $_GET['update'];
                   if ($result) {
                    if (mysqli_num_rows($result) > 0) {
                        $stt = 1;
                
                        $questionRow = mysqli_fetch_array($result);
                  
                        if($questionRow['dangcauhoi'] == "Select"){
                         echo ('<div class="alert alert-warning text-center" role="alert">Vui lòng sửa đáp án theo cú pháp đáp án - câu hỏi</div>');

                        }
                        echo '<tr>';
                        echo '<td>';
                        if ($checkUpdate == "true") {
                         echo '<form method="POST" enctype="multipart/form-data">';
                         echo '<label for="name_quiz"><span style="color: red;">*</span>Nhập tên câu hỏi</label>';
                         echo '<input class="form-control" type="text" name="ten_cau_hoi" id="name_quiz" value="' . (isset($_POST['ten_cau_hoi']) ? $_POST['ten_cau_hoi'] : $questionRow['cauhoi'] ) . '">';

                            echo("<br>");
                          
                            echo '<label for="name_quiz">Ảnh cho câu hỏi</label>
                                   <input class="form-control" type="file" name="file_tai_len" id="">';
                                   $file_tai_len_display = (isset($_FILES['file_tai_len']['name']) ? $_FILES['file_tai_len']['name'] : $questionRow['anh']);
                       
                             
                              if (!empty($file_tai_len_display)) {
                                   echo '<img src="uploads/' . $file_tai_len_display . '" alt="Question Image" style="max-width: 100px;">';
                               }
                              
                              echo '  <tr>
                    
                              <th>Đáp án</th> 

                                 </tr>';
                                  $i = 1;
                                  mysqli_data_seek($result, 0);
                                  while ($row = mysqli_fetch_array($result)) {
                                        
                                      echo '<tr>';
                                      echo '<td>';
                         
                                        echo '<input type="text" class="form-control" name="dap_an_' . $i . '" value="' . (isset($_POST['dap_an_' . $i . '']) ? $_POST['dap_an_' . $i . ''] : $row["dapan"] ) . '" />';
                                        echo '<input type="checkbox" ' . (($row['dapandung'] == 1) ? 'checked' : '') . '  name="check_dap_an_' . $i . '"  value="' . (isset($_POST["check_dap_an_' . $i . '"]) ? $_POST["check_dap_an_' . $i . '"] : $row['id_dapan'] ).'">';

                                      echo 'Đáp án  : '. (isset($_POST['dap_an_' . $i . '']) ? $_POST['dap_an_' . $i . ''] : $row["dapan"] );
                                      echo '</td>';
                                      echo '</tr>';
                                      $i++;
                                  }

                                   
                              echo '<input type="submit" value="Save" name="btnSave" class="btn btn-primary btnSubmit">';
                              echo "</form>";


                          
                              }
                          else {
                            if (!empty($questionRow['anh'])) {
                                echo 'Câu hỏi : ' . $questionRow['cauhoi'] . ' <img src="uploads/' . $questionRow['anh'] . '" alt="Question Image" style="max-width: 100px;">';
                            } else {
                                echo 'Câu hỏi :' . $questionRow['cauhoi'];
                            }
                            $i = 1;
                            echo '  <tr>
                    
                            <th>Đáp án</th>               
                               </tr>';
                            mysqli_data_seek($result, 0);
                            while ($row = mysqli_fetch_array($result)) {
                                  
                                echo '<tr>';
                                echo '<td>';
                                echo '<input disabled type="checkbox" ' . (($row['dapandung'] == 1) ? 'checked' : '') . ' name="answer[]" value="' . $row['id_dapan'] . '">';
                                echo 'Đáp án  : ' . $row['dapan'];
                                echo '</td>';
                                echo '</tr>';
                                $i++;
                            }
                        }
                
                        echo '</td>';
                        echo '</tr>';
               
                    } else {
                        echo '<tr><td colspan="2">Không có câu hỏi nào</td></tr>';
                    }
                }
                mysqli_free_result($result);
              
                ?>
</table>

		</div>
        
 
          
          <div class="alert-primary text-center p-2 position-absolute-bottom" style="margin-top: 15px;" role="alert">ProjectPHP - K71</div>
	</main>
	
</body>
                <?php
           
                      if(isset($_POST['btnSave'])){
                      
                         $a = $_GET['id_khoa_hoc'];
                         $ten_cau_hoi = $_POST['ten_cau_hoi'];
                         $id_cauhoi = $_GET['id_cau_hoi'];
                        
                         global $conn;
                         $pictureData = "SELECT anh FROM cauhoi WHERE id_cauhoi='" . $id_cauhoi . "'";
                         $resultPicture = mysqli_query($conn, $sql);
                         if ($resultPicture) {
                              $row = mysqli_fetch_assoc($resultPicture);
                              if ($row) {
                                  $file_tai_len = $row['anh'];
                                
                              } else {
                                   $file_tai_len = "";
                              }
                          } else {
                              echo "Query error: " . mysqli_error($conn);
                          }
                    
                  
                         if (isset($_FILES['file_tai_len']) && $_FILES['file_tai_len']['error'] === 0) {
                             $file_tai_len = $_FILES['file_tai_len']['name'];
                             move_uploaded_file($_FILES['file_tai_len']['tmp_name'], 'uploads/' . $file_tai_len);
                         }
                         
                     
                         if (empty($ten_cau_hoi)) {
                             echo ('<div class="alert alert-warning text-center" role="alert">Thêm câu hỏi thất bại</div>');
                         } else {
                              $sql = "UPDATE cauhoi SET cauhoi='" . $ten_cau_hoi . "', anh='" . $file_tai_len . "' WHERE id_cauhoi='" . $id_cauhoi . "'";

                             $result = mysqli_query($conn, $sql);
                     
                             if (!$result) {
                                 echo "Lỗi insert cauhoi: " . mysqli_error($conn);
                             } else {
                               
                                 $lastIdQuery = "SELECT * FROM dapan
                                   JOIN cauhoi ON cauhoi.id_cauhoi = dapan.id_cauhoi
                                   WHERE dapan.id_cauhoi='" . $id_cauhoi . "'";
                                 $resultIds = mysqli_query($conn, $lastIdQuery);
                             
                                 if ($resultIds) {
                                   $soLuongDa = mysqli_num_rows($resultIds);
                                  
                                   for ($i = 1; $i <= $soLuongDa; $i++) {
                                     
                                       $row = mysqli_fetch_assoc($resultIds);
                                     
                                       
                                       if ($row) {
                                       print_r($row);
                                      
                                           $dapAnValue = trim($_POST['dap_an_' . $i]);
                                           $checkDapAnValue = isset($_POST['check_dap_an_' . $i]) ? 1 : 0;
                               
                                           $sql2 = "UPDATE dapan SET dapan='$dapAnValue', dapandung='$checkDapAnValue' WHERE id_dapan='" . $row['id_dapan'] . "'";
                                           $result2 = mysqli_query($conn, $sql2);
                               
                                           if (!$result2) {
                                               echo "Lỗi dap an: " . mysqli_error($conn);
                                           }
                                       
                                        //    header("Refresh:0");
                                         
                                       } else {
                                           echo "Không có đủ dữ liệu để cập nhật.";
                                       }
                                   }
                                   echo '<script>alert("Sửa câu hỏi thành công");</script>';
                                   

                                  
                                 } 
                                 
                                 else {
                                     echo "Lỗi truy vấn id max: " . mysqli_error($conn);
                                 }
                                 
                             }
                         }
                     }
                ?>
	
</html>