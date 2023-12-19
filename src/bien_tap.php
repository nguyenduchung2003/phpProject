
<?php include '../connectdb.php';
// include 'footer.php'; 
// session_start(); 
include_once '../function.php';
if (!isLogin()) {
    header('Location: dang_nhap.php');
    exit();
}
if (session_status() == PHP_SESSION_NONE) {
     session_start();
 }
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Biên tập</title>
	<!-- Begin bootstrap cdn -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="	sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
	<!-- End bootstrap cdn -->
    <style>
        img{
            max-width: 400px;
        }
        a{
            text-decoration: none;
            color: white;
        }
        .formAction{
          display: flex;
          gap: 10px;
        }
        
        /* .delete{
          background-color:red;
          border: none;
          border-radius: 4px;
          color: white;
          padding: 5px;
          font-size: 14px;
        }
        .update{
          background-color:red;
          border: none;
          border-radius: 4px;
          color: white;
          padding: 5px;
          font-size: 14px;
        }
        .approve{
          background-color:green;
          border: none;
          border-radius: 4px;
          color: white;
          padding: 5px;
          font-size: 14px;
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
               
                <?php
                  $a=  $_GET['id_khoa_hoc'];
                  if($a){
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
                  else {
                     header('Location: khoa_hoc.php');
                     exit();
                  }
              
             
            }
           
                ?>
                <!--Tên khóa học  -->
            </p>
            <a href="khoa_hoc.php" class="btn btn-primary">Trở lại</a>
           
            <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown">
            Thêm câu hỏi
            </button>
            <ul class="dropdown-menu">
                <li>
                    <?php
                $a=  $_GET['id_khoa_hoc'];
                echo '<a class="dropdown-item" href="them_cau_hoi.php?id_khoa_hoc='.$a.' ">Câu hỏi điền,một đáp án,nhiều đáp án</a>';
                ?> 
                 </li>
                 <li>
                    <?php
                $a=  $_GET['id_khoa_hoc'];
                echo '<a class="dropdown-item" href="cau_hoi_noi.php?id_khoa_hoc='.$a.' ">Câu hỏi nối</a>';
                ?> 
                 </li>
            </ul>
           
               <?php
               //  $a=  $_GET['id_khoa_hoc'];
               //  echo '<a class="btn btn-primary " href="them_cau_hoi.php?id_khoa_hoc='.$a.' ">Thêm câu hỏi</a>';
                ?> 
              
           
        </div>
        <div class="d-flex flex-wrap flex-column align-items-center" style="padding: 1%;margin: 5% 0 0 0; ">
            <p class="h3">Danh sách câu hỏi</p>
            <table  class="table table-striped">
                <tr>
                    <th>STT</th>
                    <th>Tên câu hỏi</th>
                    <th>Loại câu hỏi</th>
                    <th>Đáp án</th>
                    <th>Tác giả</th>
                    <th>Trạng thái</th>
                    <th>Thao tác</th> 
                </tr>
                <!-- <tr>
                    <td align="center" colspan="6">Không có câu hỏi nào</td>
                </tr> -->
                <tbody>
        <?php
     ob_start();
        global $conn;
        $a = $_GET['id_khoa_hoc'];
        $sql = "SELECT *
        FROM cauhoi
        JOIN account ON cauhoi.idUser = account.idUser 
        JOIN dapan ON cauhoi.id_cauhoi = dapan.id_cauhoi
        WHERE cauhoi.idKhoaHoc = $a";
        $result = mysqli_query($conn, $sql);
        
        if ($result) {
            if (mysqli_num_rows($result) > 0) {
                $stt = 1;
               $arrayDapan = [];
               while ($row = mysqli_fetch_array($result)) {
             
                    if (!isset($arrayDapan[$row['id_cauhoi']])) {
                  
                        $arrayDapan[$row['id_cauhoi']] = [];
                    }
                    if ($row['dapandung'] == 1) {
                   
                        $arrayDapan[$row['id_cauhoi']][] = $row['dapan'];
                    }
               }
           
               mysqli_data_seek($result, 0);

                $displayedQuestions = []; 
                while ($row = mysqli_fetch_array($result)) {
                 
                
                    if (
                         ($row['idKhoaHoc'] == $a && $row['idUser'] == $_SESSION["user"]["id"] && $_SESSION["user"]["role"] == "user")
                         || ($row['idKhoaHoc'] == $a && $_SESSION["user"]["role"] == "admin")
                     ) {
                         echo '<tr>';
                         if ($row['dapandung'] == 1 && !in_array($row['id_cauhoi'], $displayedQuestions)) {
                             echo '<td>' . $stt . '</td>';
                             echo '<td>';
                             echo (!empty($row['anh'])) ? $row['cauhoi'] . ' <img src="uploads/' . $row['anh'] . '" alt="Question Image" style="max-width: 100px;">' : $row['cauhoi'];
                             echo '</td>';
                             echo '<td>' . $row['dangcauhoi'] . '</td>';
                             
                             $answerInfo = isset($arrayDapan[$row['id_cauhoi']]) ? implode('<br>', array_map(
                              function ($index, $answer)
                              {
                                 return "Đáp án thứ $index: $answer";
                             }, range(1, count($arrayDapan[$row['id_cauhoi']])), $arrayDapan[$row['id_cauhoi']])) : 'Không có đáp án đúng';
                             
                             echo '<td>' . $answerInfo . '</td>';
                             echo '<td>' . $row['username'] . '</td>';
                             echo '<td>' . ($row['trangthai'] == 1 ? 'Đã duyệt' : 'Chưa duyệt') . '</td>';
                             echo '<td>';
                             echo '<form method="post" action="" class="formAction">';
                             echo '<input type="hidden" name="row_id" value="' . $row['id_cauhoi'] . '">';
                             echo '<input class="btn btn-primary" type="submit" name="actionPreview" value="Xem trước"/>';
                             
                             if ($_SESSION["user"]["role"] == "admin" && $row['trangthai'] != 1) {
                                 echo '<input class="btn btn-success" type="submit" name="actionApprove" value="Duyệt" />';
                                 
                             }
                             if ( $row['trangthai'] != 1) {
                           
                               echo '<input class="btn btn-secondary" type="submit" name="actionUpdate" value="Update"/>';
                          }
                            
                         //     echo '<a href="xem_truoc.php" class="btn btn-secondary">Update</a>';
                             echo '<input class="btn btn-danger" type="submit" name="actionDelete" value="Xóa"/>';
                             echo '</form>';
                             echo '</td>';
                             $stt++;
                             $displayedQuestions[] = $row['id_cauhoi'];
                         }
                         echo '</tr>';
                     }
                    else if ($row['idUser'] == $_SESSION["user"]["id"] ) {
                         echo '<tr><td align="center" colspan="7">Không có câu hỏi nào</td></tr>'; 
                    }
                }
            } else {
                echo '<tr><td align="center" colspan="7">Không có câu hỏi nào</td></tr>';
            }
        
            mysqli_free_result($result);
        } else {
            echo '<tr><td align="center" colspan="7">Đã xảy ra lỗi</td></tr>';
        }
     
      
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
          if (isset($_POST["actionPreview"])) {
               $rowId = $_POST["row_id"];
               $a = $_GET['id_khoa_hoc'];
               header("Location: xem_truoc.php?id_khoa_hoc=$a&id_cau_hoi=$rowId&update=false");
          } elseif (isset($_POST["actionDelete"])) {
               $rowId = $_POST["row_id"];
               $sqlDelete = "DELETE FROM cauhoi WHERE id_cauhoi = '$rowId'";
               $resultDelete = mysqli_query($conn, $sqlDelete);
               header("Refresh:0");
             
          } elseif (isset($_POST["actionApprove"])) {
              $rowId = $_POST["row_id"];
      
              $sqlUpdate = "UPDATE cauhoi SET trangthai = 1 WHERE id_cauhoi = $rowId";
              $stmtUpdate = mysqli_query($conn, $sqlUpdate);
              header("Location: " . $_SERVER['REQUEST_URI']);
           
               
          }
          else if (isset($_POST["actionUpdate"])) {
               $rowId = $_POST["row_id"];
               $a = $_GET['id_khoa_hoc'];
               header("Location: xem_truoc.php?id_khoa_hoc=$a&id_cau_hoi=$rowId&update=true");
          }
         
      }
      ob_end_flush(); 
        ?>
    </tbody>
            </table>
            
        </div>
	</main>
     <div class="alert-primary text-center p-2" style="margin-top: 15px;" role="alert">ProjectPHP - K71</div>
</body>

	
</html>