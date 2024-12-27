<?php
include 'functions.php';
session_start();
$pdo = pdo_connect_mysql();

if (!isset($_SESSION['loggedin'])) {
    header('Location: index.php');
    exit;
}

if (!isset($_GET['file']) || !isset($_GET['student'])) {
    exit('No file specified!');
}

$file = basename($_GET['file']);
$studentName = preg_replace('/[^a-zA-Z0-9_-]/', '', $_GET['student']);
$filePath = 'C:/xampp/htdocs/codes/Jem/uploads/' . $studentName . '/' . $file;

if (!file_exists($filePath)) {
    exit('File does not exist!');
}

$fileType = pathinfo($filePath, PATHINFO_EXTENSION);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>View File</title>
    <link href="style1.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer">
    <style>
        .file-container {
            text-align: center;
            margin-top: 20px;
        }
        .back-button {
            display: block;
            margin: 20px auto; 
            padding: 10px 15px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            width: 100px; 
        }
        .back-button:hover {
            background-color: #0056b3;
        }
        img {
            max-width: 600px;
            max-height: 600px; 
            margin: 20px 0; 
        }
        @media print {
            nav, .back-button {
                display: none; 
            }
            body {
                margin: 0; 
            }
        }
    </style>
    <script>
        function printFile() {
            window.print(); 
        }
    </script>
</head>
<body>
    <nav class="navtop">
        <div>
            <h1>View File</h1>
            <a href="home.php"><i class="fas fa-home"></i> Home</a>
            <a href="read.php"><i class="fas fa-book"></i> Students</a>
            <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
            <a href="#" onclick="printFile()"><i class="fas fa-print"></i> Print</a>
        </div>
    </nav>

    <div class="top-center">
        <button class="back-button" onclick="window.history.back();">Back</button>
    </div>

    <div class="file-container">
        <h2>File</h2>
        <?php if (in_array($fileType, ['jpg', 'jpeg', 'png', 'gif'])): ?>
            <h3>Image Preview</h3>
            <img src="<?= htmlspecialchars('uploads/' . $studentName . '/' . $file) ?>" alt="Image Preview">
        <?php endif; ?>
        
        <p>Click the link below to download the file:</p>
        <a href="<?= htmlspecialchars('uploads/' . $studentName . '/' . $file) ?>" target="_blank" class="back-button">Download File</a>
    </div>
</body>
</html>