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
     if(!isset($_SESSION['QuestionCorrect'])){
          $_SESSION['QuestionCorrect'] = [];
     }
     
}
else if (!isset($_GET['id_khoa_hoc'])) {
     header('Location: khoa_hoc.php');
 }
?>
<!DOCTYPE html>
<html lang="en">
<head>
     <meta charset="UTF-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <title>Thực hành - Trắc nghiệm</title>
     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="	sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
     <style>
          body {
               font-family: Arial, sans-serif;
               background-color: #f4f4f4;
               margin: 0;
               padding: 0;
          }

          header {
               background-color: #333;
               color: #fff;
               text-align: center;
               padding: 10px;
          }

          section {
               max-width: 750px;
               margin: 20px auto;
               background-color: #fff;
               padding: 20px;
               border-radius: 8px;
               box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
          }

          .question {
               margin-bottom: 15px;
          }

          .options {
               list-style-type: none;
               padding: 0;
          }
          li {
               list-style-type: none;
          }
          .options li {
               margin-bottom: 10px;
               
          }

          button {
               background-color: #333;
               color: #fff;
               padding: 10px 20px;
               border: none;
               border-radius: 4px;
               cursor: pointer;
          }
          .btnBack{
               background-color: #fff;
               padding: 10px 20px;
               border: none;
               border-radius: 4px;
               cursor: pointer;  
               
          }
          a{
               width: 100%;
               height: 100%;
               text-decoration: none;
               color: #333;
          }
          .answer{
               display: flex;
          }
       .incorrect-question {
          color: red;
       }
       .correct-question {
          color: green;
       }
     </style>
</head>
<body>
     <header>
          <h1>Trắc nghiệm</h1>
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
          <button class="btnBack"><a href="khoa_hoc.php">Trở lại</a></button>
     </header>

     <section>
          <form action="" method="POST">
          <?php 
         if (isset($_POST['btnNopBai'])){
    
   
          global $conn;
       
               $numberQuestionCorrect = 0;
   
         
              //CheckBox 
              $printedAnswers = []; 
              $selectedAnswersArray = [];
              $correctAnswers = [];
              foreach ($_POST as $key => $value) {
               if (strpos($key, 'checkBoxAnswer') !== false) {
                    $value = mysqli_real_escape_string($conn, $value);
                    $parts = explode('_', $key);
                    $idCauhoi = $parts[1];
                    $idDapan = $parts[2];
                  
                    $selectedAnswersArray[$idCauhoi][] = $idDapan;    
                    
                    if (!isset($printedAnswers[$idCauhoi])) {
                        
                        $sql = "SELECT *
                                 FROM cauhoi 
                                   JOIN dapan ON cauhoi.id_cauhoi = dapan.id_cauhoi
                                WHERE cauhoi.idKhoaHoc = $a 
                                AND dapan.id_cauhoi = $idCauhoi AND  dapan.dapandung = 1 AND cauhoi.dangcauhoi = 'CheckBox'";
            
                        $result = mysqli_query($conn, $sql);
            
                        if (!$result) {
                            echo "Error executing query: " . mysqli_error($conn);
                        } else {
                            
                          
                            while ($row = mysqli_fetch_assoc($result)) {
                                $correctAnswers[$row['id_cauhoi']][] = $row['id_dapan'];
                            }
                           
                            if (!isset($printedAnswers[$idCauhoi])) {
                                $printedAnswers[$idCauhoi] = true; 
                            }
                            
                        }
                        $printedAnswers[$idCauhoi] = false;
                        
                        
                    }
                }
             
              }
        
              foreach ($correctAnswers as $idCauhoi => $correct) {
               if (isset($selectedAnswersArray[$idCauhoi])) {
                   if (array_diff($correct, $selectedAnswersArray[$idCauhoi]) === array_diff($selectedAnswersArray[$idCauhoi], $correct)) {
                    
                    $_SESSION['QuestionCorrect'][] = $idCauhoi;
                       $numberQuestionCorrect++;
                   }
               }
           }
           
  
              //Điền
              
          foreach ($_POST as $key => $value) {
               if (strpos($key, 'textAnswer') !== false) {
                   $parts = explode('_', $key);
                   $questionNumber = end($parts);
           
               
                   $questionNumber = trim($questionNumber);
                   $value = trim($value);

                   $questionNumber = mysqli_real_escape_string($conn, $questionNumber);
                   $value = mysqli_real_escape_string($conn, $value);
                    
                   $sql = "SELECT *
                           FROM cauhoi 
                           JOIN dapan ON cauhoi.id_cauhoi = dapan.id_cauhoi
                           WHERE cauhoi.idKhoaHoc = $a 
                               AND dapan.id_cauhoi = $questionNumber 
                               AND dapan.dapan = '" . $value . "'"; 
           
                  
                   $result = mysqli_query($conn, $sql);
              
                   if (!$result) {
                       echo "Loi Error executing query: " . mysqli_error($conn);
                   } else {
                     
                       if (mysqli_num_rows($result) > 0) {
                         $row = mysqli_fetch_assoc($result);
                         $_SESSION['QuestionCorrect'][] = $row['id_cauhoi'];
                           $numberQuestionCorrect++;

                       } else {
                          echo "";
                       }
                   }
               }
           }
           
      


              //  Select
              $selectOptionQuestionArray = [];
              $selectOptionAnswerArray = [];
              $selectOptionUser = [];
              $valueQuestion =[];
              $valueAnswer =[];
              $printedAnswersSelect = []; 
              $correctAnswersSelect = [];
              
              foreach ($_POST as $key => $value) {
              
               if (strpos($key, 'selectQuestion') !== false) {
                   $parts = explode('_', $key);

                   $value = mysqli_real_escape_string($conn, $value);

                   $valueQuestion = explode('_', $value);
               
                   $answerselectQuestion = $parts[1];
                  
                   $idQuestionselectQuestion = $parts[1];
                   $idAnswerselectQuestion = $parts[2];
               } elseif (strpos($key, 'selectAnswer') !== false) {
                    $value = mysqli_real_escape_string($conn, $value);

                 
                   $valueAnswer = explode('_', $value);
                  
                   $parts = explode('_', $key);
           
                   $answerselectAnswer = $parts[0];
                   $idQuestionselectAnswer = $parts[1];
                   $idAnswerselectAnswer = $parts[2];
                   
               }

              
                       if(isset($idQuestionselectAnswer)){
                         $sql = "SELECT *
                         FROM cauhoi 
                           JOIN dapan ON cauhoi.id_cauhoi = dapan.id_cauhoi
                        WHERE cauhoi.idKhoaHoc = $a 
                        AND dapan.id_cauhoi = $idQuestionselectAnswer AND  dapan.dapandung = 1 AND cauhoi.dangcauhoi = 'Select'";
          
                     $result = mysqli_query($conn, $sql);
          
                    if (!$result) {
                    echo "Error executing query: " . mysqli_error($conn);
                    } else {
                    
                  
                     while ($row = mysqli_fetch_assoc($result)) {
                          $correctAnswersSelect[$row['id_cauhoi']][$row['id_dapan']] = $row['dapan'];
                      }
                      
                    
                }
                       }
               if (isset($idAnswerselectQuestion, $idAnswerselectAnswer) && $idAnswerselectQuestion == $idAnswerselectAnswer) {
                  
                 
                    if($valueQuestion[1] ==$valueAnswer[1] &&$valueQuestion[2] ==$valueAnswer[2] ){
                      $concatenatedString =''."$valueAnswer[0]".'-'."$valueQuestion[0]".'';   
                    }
                   $selectOptionUser[$idQuestionselectAnswer][$idAnswerselectAnswer] = $concatenatedString;
               }
           }
           foreach ($correctAnswersSelect as $idQuestionselectAnswer => $correct) {
               if (isset($selectOptionUser[$idQuestionselectAnswer])) {
                   if (array_diff($correct, $selectOptionUser[$idQuestionselectAnswer]) === array_diff($selectOptionUser[$idQuestionselectAnswer], $correct)) {
                    
                    $_SESSION['QuestionCorrect'][] = $idQuestionselectAnswer;
                       $numberQuestionCorrect++;
                   }
               }
          }
           echo("<br>");
           echo '<script type="text/javascript">alert("Số câu đúng là:' . $numberQuestionCorrect . '");</script>';
         

          }
                global $conn;
                 
                $sql = "SELECT *
                        FROM cauhoi 
                        JOIN dapan ON cauhoi.id_cauhoi = dapan.id_cauhoi
                        WHERE cauhoi.idKhoaHoc = $a AND cauhoi.trangthai =1"; 
                        $result =  mysqli_query($conn, $sql);
                        $displayedQuestions = []; 
                    if ($result) {
                         if (mysqli_num_rows($result) > 0) {
                             $stt = 1;
                    

                             while ($row = mysqli_fetch_array($result)) {
                              if (!in_array($row['id_cauhoi'], $displayedQuestions)){
                                   if($stt >1){
                                        echo '<hr>'; 
                                   }
                                  
                              // echo '<div class="question">';
                              echo '<div class="question ';
                      
                           
                              if (isset($_POST['btnNopBai']) && isset($_SESSION['QuestionCorrect']) && in_array($row['id_cauhoi'], $_SESSION['QuestionCorrect'])) {
                               
                                   echo 'correct-question'; 
                              } elseif(isset($_POST['btnNopBai'])) {
                             
                                   echo 'incorrect-question'; 
                              }
                              
                              echo '">';
                              
                               if (!empty($row['anh'])) {
                                   echo '<h3>';
                                   echo '
                                   Câu hỏi '."$stt".': ' . $row['cauhoi'] . '';
                                   echo '</h3>';
                                   echo '<img src="uploads/' . $row['anh'] . '" alt="Question Image" style="max-width: 100px;">';
                                  
                                    
                               } else {
                                   echo 'Câu hỏi '."$stt".':' . $row['cauhoi'];
                               }
                           
                             
                              
                              echo '</div>';
                          
                              $stt++;
                               }
                              echo '<div class="answer">';
                       ///////////////////////////////// checkbox        
                              if($row['dangcauhoi'] =="CheckBox"){
                                   $checkBoxAnswer =  "_" .$row['id_cauhoi'] . "_" . $row['id_dapan'];

                                   echo '<ul class="options">';
                                   echo '<li>';
                                   echo '<label>';
                                   echo '<input type="checkbox" name="checkBoxAnswer' . $checkBoxAnswer . '" value="' . $row['id_dapan'] . '" ';
                               
                                   
                                   if (isset($_POST['checkBoxAnswer' . $checkBoxAnswer]) && $_POST['checkBoxAnswer' . $checkBoxAnswer] == $row['id_dapan']) {
                                        echo 'checked'; 
                                    }
                               
                                   echo '> ' . $row['dapan'];
                                   echo '</label>';
                                   echo '</li>';
                                   echo '</ul>';
                                   
                              }
                               ///////////////////////////////// text      
                              else if($row['dangcauhoi']== "Điền"){
                              //      $textAnswer = 'textAnswer_' . $row['id_cauhoi'] ."_" . $row['id_dapan'];
                              //      echo "<div>Đáp án:</div>";
                              //      echo '<div class="options">';
                              //      echo '<label><input type="text" name="textAnswer_' . $textAnswer . '" value="' . (isset($_POST['textAnswer_' . $textAnswer]) ? $_POST['textAnswer_' . $textAnswer] : '') . '" /></label>';
                              //    echo '</div>';
                              $textAnswer = 'textAnswer_' . $row['id_cauhoi'] . "_" . $row['id_dapan'];
                              $questionId = $row['id_cauhoi']; // Added line to get the question ID
                          
                              echo "<div>Đáp án:</div>";
                              echo '<div class="options">';
                              echo '<label><input type="text" name="textAnswer_' . $textAnswer . '_' . $questionId . '" value="' . (isset($_POST['textAnswer_' . $textAnswer . '_' . $questionId]) ? $_POST['textAnswer_' . $textAnswer . '_' . $questionId] : '') . '" /></label>';
                              echo '</div>';
                             
                              }
                               ///////////////////////////////// select      
                              else if ($row['dangcauhoi']=="Select"){


                                        echo "<div>Câu hỏi:</div>";

                                        $questionOptionsQuery = "SELECT DISTINCT dapan FROM dapan WHERE id_cauhoi = " . $row['id_cauhoi'];
                                        $questionOptionsResult = mysqli_query($conn, $questionOptionsQuery);
                                    
                                        if ($questionOptionsResult) {
                                            $selectName = 'selectQuestion_' . $row['id_cauhoi'] ."_" . $row['id_dapan'];
                                    
                                            echo '<select name="' . $selectName . '">';
                                            while ($optionRow = mysqli_fetch_array($questionOptionsResult)) {
                                                $questionSelect = explode('-', $optionRow['dapan'])[1];
                                                $questionSelectId = explode('-', $optionRow['dapan'])[1] . '_' . $row['id_dapan'] . '_' . $row['id_cauhoi'];

                                                $selected = (isset($_POST[$selectName]) && $_POST[$selectName] == $questionSelectId) ? 'selected' : '';
                                                echo '<option value="' . $questionSelectId . '" ' . $selected . '>' . $questionSelect . '</option>';
                                            }
                                            echo '</select>';
                                        } else {
                                            echo 'Error fetching options';
                                        }
                                    
                                        echo "<div>Đáp án:</div>";
                                    
                                        $questionOptionsQuery = "SELECT DISTINCT dapan FROM dapan WHERE id_cauhoi = " . $row['id_cauhoi'];
                                        $questionOptionsResult = mysqli_query($conn, $questionOptionsQuery);
                                    
                                        if ($questionOptionsResult) {
                                            $selectName = 'selectAnswer_' . $row['id_cauhoi'] ."_". $row['id_dapan'];
                                    
                                            echo '<select name="' . $selectName . '">';
                                            while ($optionRow = mysqli_fetch_array($questionOptionsResult)) {
                                                $questionSelect = explode('-', $optionRow['dapan'])[0];
                                               
                                                $questionSelectId = explode('-', $optionRow['dapan'])[0] . '_' . $row['id_dapan'] . '_' . $row['id_cauhoi'];
                                                $selected = (isset($_POST[$selectName]) && $_POST[$selectName] == $questionSelectId) ? 'selected' : '';
                                                echo '<option value="' . $questionSelectId . '" ' . $selected . '>' . $questionSelect . '</option>';
                                            }
                                            echo '</select>';
                                        } else {
                                            echo 'Error fetching options';
                                        }
                                      
                              }
                              echo '</div>';
                             
                           
                              $displayedQuestions[] = $row['id_cauhoi'];
                              
                             }
                             
                         } else {
                             echo '<tr><td colspan="2">Không có câu hỏi nào</td></tr>';
                         }
                         
                    }
                 
               
                     mysqli_free_result($result);  
                     echo("<hr>");
          ?>
        
                    <div class="text-center">
                    <?php
                    
                    ?>
                    <input type="submit" name="btnNopBai" value="Nộp bài" class="btn btn-primary" <?php 
             
                    echo isset($_POST['btnNopBai']) ? 'disabled' : ''; ?> 
                    />

                
                    </div>
                 
      
       
          </form>
     </section>
     
    


</body>
<?php
   
// if (isset($_POST['btnNopBai'])){
    
   
//           global $conn;
       
//                $numberQuestionCorrect = 0;
   
         
//               //CheckBox 
//               $printedAnswers = []; 
//               $selectedAnswersArray = [];
//               $correctAnswers = [];
//               foreach ($_POST as $key => $value) {
//                if (strpos($key, 'checkBoxAnswer') !== false) {
//                     $value = mysqli_real_escape_string($conn, $value);
//                     $parts = explode('_', $key);
//                     $idCauhoi = $parts[1];
//                     $idDapan = $parts[2];
                  
//                     $selectedAnswersArray[$idCauhoi][] = $idDapan;    
                    
//                     if (!isset($printedAnswers[$idCauhoi])) {
                        
//                         $sql = "SELECT *
//                                  FROM cauhoi 
//                                    JOIN dapan ON cauhoi.id_cauhoi = dapan.id_cauhoi
//                                 WHERE cauhoi.idKhoaHoc = $a 
//                                 AND dapan.id_cauhoi = $idCauhoi AND  dapan.dapandung = 1 AND cauhoi.dangcauhoi = 'CheckBox'";
            
//                         $result = mysqli_query($conn, $sql);
            
//                         if (!$result) {
//                             echo "Error executing query: " . mysqli_error($conn);
//                         } else {
                            
                          
//                             while ($row = mysqli_fetch_assoc($result)) {
//                                 $correctAnswers[$row['id_cauhoi']][] = $row['id_dapan'];
//                             }
                           
//                             if (!isset($printedAnswers[$idCauhoi])) {
//                                 $printedAnswers[$idCauhoi] = true; 
//                             }
                            
//                         }
//                         $printedAnswers[$idCauhoi] = false;
                        
                        
//                     }
//                 }
             
//               }
        
//               foreach ($correctAnswers as $idCauhoi => $correct) {
//                if (isset($selectedAnswersArray[$idCauhoi])) {
//                    if (array_diff($correct, $selectedAnswersArray[$idCauhoi]) === array_diff($selectedAnswersArray[$idCauhoi], $correct)) {
                    
//                     $_SESSION['QuestionCorrect'][] = $idCauhoi;
//                        $numberQuestionCorrect++;
//                    }
//                }
//            }
           
  
//               //Điền
              
//           foreach ($_POST as $key => $value) {
//                if (strpos($key, 'textAnswer') !== false) {
//                    $parts = explode('_', $key);
//                    $questionNumber = end($parts);
           
               
//                    $questionNumber = trim($questionNumber);
//                    $value = trim($value);

//                    $questionNumber = mysqli_real_escape_string($conn, $questionNumber);
//                    $value = mysqli_real_escape_string($conn, $value);
                    
//                    $sql = "SELECT *
//                            FROM cauhoi 
//                            JOIN dapan ON cauhoi.id_cauhoi = dapan.id_cauhoi
//                            WHERE cauhoi.idKhoaHoc = $a 
//                                AND dapan.id_cauhoi = $questionNumber 
//                                AND dapan.dapan = '" . $value . "'"; 
           
                  
//                    $result = mysqli_query($conn, $sql);
              
//                    if (!$result) {
//                        echo "Loi Error executing query: " . mysqli_error($conn);
//                    } else {
                     
//                        if (mysqli_num_rows($result) > 0) {
//                          $row = mysqli_fetch_assoc($result);
//                          $_SESSION['QuestionCorrect'][] = $row['id_cauhoi'];
//                            $numberQuestionCorrect++;

//                        } else {
//                           echo "";
//                        }
//                    }
//                }
//            }
           
      


//               //  Select
//               $selectOptionQuestionArray = [];
//               $selectOptionAnswerArray = [];
//               $selectOptionUser = [];
//               $valueQuestion =[];
//               $valueAnswer =[];
//               $printedAnswersSelect = []; 
//               $correctAnswersSelect = [];
              
//               foreach ($_POST as $key => $value) {
              
//                if (strpos($key, 'selectQuestion') !== false) {
//                    $parts = explode('_', $key);

//                    $value = mysqli_real_escape_string($conn, $value);

//                    $valueQuestion = explode('_', $value);
               
//                    $answerselectQuestion = $parts[1];
                  
//                    $idQuestionselectQuestion = $parts[1];
//                    $idAnswerselectQuestion = $parts[2];
//                } elseif (strpos($key, 'selectAnswer') !== false) {
//                     $value = mysqli_real_escape_string($conn, $value);

                 
//                    $valueAnswer = explode('_', $value);
                  
//                    $parts = explode('_', $key);
           
//                    $answerselectAnswer = $parts[0];
//                    $idQuestionselectAnswer = $parts[1];
//                    $idAnswerselectAnswer = $parts[2];
                   
//                }

              
//                        if(isset($idQuestionselectAnswer)){
//                          $sql = "SELECT *
//                          FROM cauhoi 
//                            JOIN dapan ON cauhoi.id_cauhoi = dapan.id_cauhoi
//                         WHERE cauhoi.idKhoaHoc = $a 
//                         AND dapan.id_cauhoi = $idQuestionselectAnswer AND  dapan.dapandung = 1 AND cauhoi.dangcauhoi = 'Select'";
          
//                      $result = mysqli_query($conn, $sql);
          
//                     if (!$result) {
//                     echo "Error executing query: " . mysqli_error($conn);
//                     } else {
                    
                  
//                      while ($row = mysqli_fetch_assoc($result)) {
//                           $correctAnswersSelect[$row['id_cauhoi']][$row['id_dapan']] = $row['dapan'];
//                       }
                      
                    
//                 }
//                        }
//                if (isset($idAnswerselectQuestion, $idAnswerselectAnswer) && $idAnswerselectQuestion == $idAnswerselectAnswer) {
                  
                 
//                     if($valueQuestion[1] ==$valueAnswer[1] &&$valueQuestion[2] ==$valueAnswer[2] ){
//                       $concatenatedString =''."$valueAnswer[0]".'-'."$valueQuestion[0]".'';   
//                     }
//                    $selectOptionUser[$idQuestionselectAnswer][$idAnswerselectAnswer] = $concatenatedString;
//                }
//            }
//            foreach ($correctAnswersSelect as $idQuestionselectAnswer => $correct) {
//                if (isset($selectOptionUser[$idQuestionselectAnswer])) {
//                    if (array_diff($correct, $selectOptionUser[$idQuestionselectAnswer]) === array_diff($selectOptionUser[$idQuestionselectAnswer], $correct)) {
                    
//                     $_SESSION['QuestionCorrect'][] = $idQuestionselectAnswer;
//                        $numberQuestionCorrect++;
//                    }
//                }
//           }
//            echo("<br>");
//            echo '<script type="text/javascript">alert("Số câu đúng là:' . $numberQuestionCorrect . '");</script>';
//           print_r($_SESSION['QuestionCorrect']);
//           echo '  <script type="text/javascript">
//                                             window.location.href = "thuc_hanh.php?id_khoa_hoc='.$_GET['id_khoa_hoc'].'";
//                                         </script>';

//           }
      
       ?>  
</html>
