<?php
$DATABASE_HOST = 'localhost';
$DATABASE_USER = 'root';
$DATABASE_PASS = '';
$DATABASE_NAME = 'phpcrud';

$con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);

if (mysqli_connect_errno()) {
    exit('Failed to connect to MySQL: ' . mysqli_connect_error());
}

$username = 'Jem';
$password = 'Batman23';

$hashed_password = password_hash($password, PASSWORD_DEFAULT);

if ($stmt = $con->prepare('INSERT INTO accounts (username, password) VALUES (?, ?)')) {
    $stmt->bind_param('ss', $username, $hashed_password);
    $stmt->execute();
    echo 'User  created successfully!';
} else {
    echo 'Could not prepare statement!';
}

$stmt->close();
$con->close();
?>