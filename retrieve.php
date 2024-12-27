<?php

session_start();
if(!isset($_SESSION['user_email'])){
    header("Location: login.php");
}
include 'connect.php';

$sql = "SELECT * FROM tbl_students";
$result = mysqli_query($conn, $sql);

if(isset($_POST['submit'])){
    $keyword = $_POST['search'];
    $sql = "SELECT * FROM tbl_students WHERE last_name like '%$keyword%' or first_name like '%$keyword%' or middle_name like '%$keyword%' or Address like '%$keyword%' or email like '%$keyword%'";
    $result = mysqli_query($conn, $sql);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta cahrsets="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> </title>
    <style>
        tr{
            background-color: #40E0D0;
        }
        .logout{
            display: relative;
            margin-left: 90%;
        
        }
        .search{
            margin:10px 0 10px;
        }
    </style>
</head>

<body>
    <h1> Student List </h1>
    <a href="index.php"> <button> Add Student</button> </a>
    <a href="logout.php" class="logout"> <button> Logout </button></a>
    <form method="post">
    <input class="search" type="text" placeholder="Search" name="search">
    <input type="submit" name="submit" value="🔎">
    <a href="retrieve.php"> Refresh </a> </form>
    <table border="01" width=100% Cellspacing="2">
        <thead>
            <th> No</th>
            <th> Student ID</th>
            <th> First Name </th>
            <th> Middle Name </th>
            <th> Last Name </th>
            <th> Email </th>
            <th> Mobile Number </th>
            <th> Address </th>
            <th> Picture </th>
            <th> Action </th>
        </thead>
        <tbody>
            <?php
            if ($result)    {
                while   ($row = mysqli_fetch_assoc($result))    
                    echo    '
                    <tr>
                    <td>'. $row['id'].'</td>
                    <td>'. $row['id_number'].'</td>
                    <td>'. $row['first_name'].'</td>
                    <td>'. $row['middle_name'].'</td>
                    <td>'. $row['last_name'].'</td>
                    <td>'. $row['email'].'</td>
                    <td>'. $row['mobile_number'].'</td>
                    <td>'. $row['address'].'</td>
                    <td><img src='.$row['image_path'].' style="width: 80px;"></td> |
                    <td><a href = "edit.php?ID='. $row['id'] .'"> Update</a> | 
                    <a href = "delete.php?ID='. $row['id'].'"> <button> Delete </button> </a> </td>
                    </tr>
                    ';
                }

             else {
                echo "Empty";
            }
            ?>
        </tbody>
    </table>
</body>
</html>