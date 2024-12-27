<?php
require 'vendor/autoload.php'; 
include 'functions.php'; // Ensure this line is present
use PhpOffice\PhpWord\TemplateProcessor;

session_start();
$pdo = pdo_connect_mysql();

if (!isset($_SESSION['loggedin'])) {
    header('Location: index.php');
    exit;
}

if (!isset($_GET['id'])) {
    exit('No student ID specified!');
}

$stmt = $pdo->prepare('SELECT id, name, email, phone, title, created FROM contacts WHERE id = ?');
$stmt->execute([$_GET['id']]);
$student = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$student) {
    exit('Student doesn\'t exist with that ID!');
}

$stmt = $pdo->prepare('SELECT id, name, email, phone, title, created FROM contacts WHERE id = ?');
$stmt->execute([$_GET['id']]);
$student = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$student) {
    exit('Student doesn\'t exist with that ID!');
}

$studentName = preg_replace('/[^a-zA-Z0-9_-]/', '', $student['name']);
$uploadDir = 'C:/xampp/htdocs/codes/Jem/uploads/' . $studentName . '/';

$files = array_diff(scandir($uploadDir), array('..', '.'));

$imagePreview = '';
$firstImage = '';

function createDocument($studentName) {
    $templateProcessor = new TemplateProcessor('template.docx'); 
    $templateProcessor->setValue('name', $studentName);

    
    $tempFile = tempnam(sys_get_temp_dir(), 'doc');
    $templateProcessor->saveAs($tempFile . '.docx');

   
    header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document');
    header('Content-Disposition: attachment; filename="StudentProfile.docx"');
    readfile($tempFile . '.docx');
    unlink($tempFile . '.docx');
    exit;
}


if ($files) {
    foreach ($files as $file) {
        if (preg_match('/\.(jpg|jpeg|png|gif)$/i', $file)) { 
            $firstImage = htmlspecialchars($file);
            break; 
        }
    }
    if ($firstImage) {
        $imagePreview = '<img src="uploads/' . $studentName . '/' . $firstImage . '" alt="Image Preview" style="max-width: 300px; max-height: 300px;"/>';
    }
}
$stmt = $pdo->prepare('SELECT * FROM student_forms WHERE student_id = ?');
$stmt->execute([$student['id']]);
$forms = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (isset($_GET['delete'])) {
    $fileToDelete = basename($_GET['delete']); 
    $filePath = $uploadDir . $fileToDelete;

    if (file_exists($filePath)) {
        unlink($filePath); 
        header("Location: view.php?id=" . $student['id']); 
        exit;
    } else {
        exit('File does not exist!');
    }
}
if (isset($_POST['print'])) {
    createDocument($student['name']);
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Student Profile</title>
    <link href="style1.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer">
    <script>
    function printPage() {
        window.print();
    }
    </script>
    <style>
        .preview {
            margin-right: 25%;
            float: right;
            padding: 5px;
            width: 200px;
            text-align: center;
            border: solid;
        }
        .file-list {
            margin-top: 20px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #f9f9f9;
        }
        .file-list div {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 5px;
            border-bottom: 1px solid #e0e0e0;
        }
        .file-list div:last-child {
            border-bottom: none;
        }
        .file-list a {
            color: #3274d6;
            text-decoration: none;
        }
        .file-list a:hover {
            text-decoration: underline;
        }
        .delete-button {
            color: red;
            text-decoration: none;
            padding: 5px 10px;
            border: 1px solid red;
            border-radius: 5px;
            background-color: #fff;
            transition: background-color 0.3s, color 0.3s;
        }
        .delete-button:hover {
            background-color: red;
            color: white;
        }
        .upload-form {
            margin-top: 20px;
        }
        .upload-form input[type="file"] {
            margin-bottom: 10px;
        }
        .back-button {
            display: block;
            margin: 20px auto; 
            padding: 10px 15px; 
            background-color: #007bff;  
            color: white;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            text-align: center;
            width: 150px;
            transition: background-color 0.3s; 
        }
        .back-button:hover {
            background-color: #0056b3;
        }
        .top-center {
            text-align: center;
        }
        @media print {
            .navtop, .back-button, .delete-button, .print-button, .upload-form, .view-button {
                display: none; 
            .preview img {
                width: 2in; 
                height: 2in; 
                object-fit: cover; 
            }
            body {
                margin: 0; 
                padding: 20px;
            }
        }
    }
    </style>
</head>
<body>
    <nav class="navtop">
        <div>
            <h1>Student Profile</h1>
            <a href="home.php"><i class="fas fa-home"></i> Home</a>
            <a href="read.php"><i class="fas fa-book"></i> Students</a>
            <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
            <a href="#" onclick="printPage()"><i class="fas fa-print"></i>Print</a>      
        </div>
    </nav>
    <div class="top-center">
        <button class="back-button" onclick="window.history.back();">Back</button>
    </div>
    <div class="preview">
            <?= $imagePreview ? $imagePreview : '<p>No image available.</p>' ?>
        </div>

    <div class="content">
        <h2>Student Profile</h2>
        <table>
            <tr>
                <td>ID:</td>
                <td><?= htmlspecialchars($student['id']) ?></td>
            </tr>
            <tr>
                <td>Name:</td>
                <td><?= htmlspecialchars($student['name']) ?></td>
            </tr>
            <tr>
                <td>Email:</td>
                <td><?= htmlspecialchars($student['email']) ?></td>
            </tr>
            <tr>
                <td>Phone:</td>
                <td><?= htmlspecialchars($student['phone']) ?></td>
            </tr>
            <tr>
                <td>Course:</td>
                <td><?= htmlspecialchars($student['title']) ?></td>
            </tr>
            <tr>
                <td>Created:</td>
                <td><?= htmlspecialchars($student['created']) ?></td>
            </tr>
        </table>


        <div class="upload-form">
            <h2>Upload New Image or File</h2>
            <form action="upload_image.php?id=<?= $student['id'] ?>" method="post" enctype="multipart/form-data">
                <input type="file" name="imageToUpload" required>
                <input type="submit" value="Upload">
            </form>
        </div>
        
        <h2>Forms for <?= htmlspecialchars($student['name']) ?></h2>
        <ul>
            <?php foreach ($forms as $form): ?>
                <li>
                    <strong><?= htmlspecialchars($form['form_name']) ?></strong>: <?= htmlspecialchars($form['form_description']) ?>
                </li>
            <?php endforeach; ?>
        </ul>
        <a href="add_form.php?id=<?= $student['id'] ?>" class="back-button">Add New Form</a>
        
        <div>
        <h2>Available Forms</h2>
        <a href="forms/GoodMoral.docx" class="back-button" target="_blank">Good Moral</a><br>
        </div>

        <h2>Uploaded Files</h2>
        <div class="file-list">
            <?php foreach ($files as $file): ?>
                <div>
                    <a href="uploads/<?= $studentName . '/' . htmlspecialchars($file) ?>" target="_blank"><?= htmlspecialchars($file) ?></a>
                    <a href="view_image.php?file=<?= urlencode($file) ?>&student=<?= urlencode($studentName) ?>" class="view-button">View</a>
                    <a href="?id=<?= $student['id'] ?>&delete=<?= urlencode($file) ?>" class="delete-button">Delete</a>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</body>
</html>