<?php
include 'connect.php';
$email = $_POST['email'];
$password = $_POST['password'];

$sql = "select password from tbl_students where Email = '$email'";
$result = mysqli_query($conn,$sql);
$row = mysqli_fetch_assoc($result);
if($row){
    if($password == $row['password']){
        session_start();
        $_SESSION['user_email'] = $email;
        header('location:retrieve.php');
    }else{
        header('Location: login.php');
    }
}else{
    header('Location: login.php');
}
?>