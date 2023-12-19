<?php
session_start();
unset($_SESSION['user']);
header('Location: dang_nhap.php');
?>