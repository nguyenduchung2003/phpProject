<?php 
    include '../connectdb.php';
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
    <title>Quản lý tài khoản</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        header {
            background-color: #333;
            color: #fff;
            text-align: center;
            padding: 10px;
        }

        a.btn {
            display: inline-block;
            padding: 10px 20px;
            margin: 10px;
            text-decoration: none;
            color: #fff;
            background-color: #007bff;
            border-radius: 5px;
        }

        nav {
            background-color: #ddd;
            padding: 10px;
        }

        section {
            padding: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #333;
            color: #fff;
        }

        .back-btn {
            text-align: center;
            margin-top: 20px;
        }
        .btnUpdate {
            padding: 10px 20px;
            background-color: #4CAF50; 
            border: none;
            border-radius: 4px; 
            cursor: pointer;
          }

       .btnUpdate:hover {
           background-color: #45a049;
       }
    </style>
</head>
<body>

    <header>
        <h1>Quản lý tài khoản</h1>
    </header>

    <a href="khoa_hoc.php" class="btn btn-primary">Trở lại</a>

    <section>
        <h2>Danh sách tài khoản người dùng</h2>
        <table>
        <tr>
                <th>Tên người dùng</th>
                <th>Action</th>
           
            </tr>
          <?php
               $sql = "SELECT *
               FROM account 
               WHERE role = 'user'";
               $result = mysqli_query($conn, $sql);
              
               if ($result && mysqli_num_rows($result) > 0) {
                      echo '<form method="post" action="">';
                      while ($row = mysqli_fetch_assoc($result)) {
                          echo '<tr>
                                  <td>' . $row['username'] . '</td>
                                  <td>
                                      <select name="SelectRole[' . $row['idUser'] . ']">
                                          <option value="admin" ' . ($row["role"] == 'admin' ? 'selected' : '') . '>Admin</option>
                                          <option value="user" ' . ($row['role'] == 'user' ? 'selected' : '') . '>User</option>
                                      </select>
                                  </td>
                              </tr>';
                      }
                      echo '<input type="submit" class="btnUpdate" value="Cập nhật" name="btnUpdate" />';
                      echo '</form>';
                  } else {
                      echo "<tr><td colspan='2'>Không có người dùng nào.</td></tr>";
                  }
              
                if(isset($_POST['btnUpdate']) && isset($_POST['SelectRole'])) {
                      foreach ($_POST['SelectRole'] as $idUser => $selectedRole) {
                          // Escape values to prevent SQL injection
                          $idUser = mysqli_real_escape_string($conn, $idUser);
                          $selectedRole = mysqli_real_escape_string($conn, $selectedRole);
              
                          $sqlUpdate = "UPDATE account
                                        SET role = '$selectedRole'
                                        WHERE idUser = '$idUser'";
                          
                          mysqli_query($conn, $sqlUpdate);
                      }
                      header("Refresh:0");
                  }
          ?>
        </table>
    </section>

</body>
</html>
