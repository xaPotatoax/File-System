<?php
include 'functions.php';
session_start();
$pdo = pdo_connect_mysql();

if (!isset($_SESSION['loggedin'])) {
    header('Location: index.php');
    exit;
}

if (!isset($_GET['id'])) {
    exit('No student ID specified!');
}

$studentId = $_GET['id'];

$studentName = ''; 
$stmt = $pdo->prepare('SELECT name FROM contacts WHERE id = ?');
$stmt->execute([$studentId]);
$student = $stmt->fetch(PDO::FETCH_ASSOC);
if ($student) {
    $studentName = preg_replace('/[^a-zA-Z0-9_-]/', '', $student['name']);
} else {
    exit('Student doesn\'t exist with that ID!');
}

$uploadDir = 'C:/xampp/htdocs/codes/Jem/uploads/' . $studentName . '/';

if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}

if (isset($_FILES['fileToUpload'])) {
    $fileName = basename($_FILES['fileToUpload']['name']);
    $targetFilePath = $uploadDir . $fileName;

    if (move_uploaded_file($_FILES['fileToUpload']['tmp_name'], $targetFilePath)) {
        header("Location: view.php?id=$studentId");
        exit;
    } else {
        exit('Error uploading the file.');
    }
}
?>