<?php
include 'functions.php';
session_start();
if (!isset($_SESSION['loggedin'])) {
    header('Location: index.php');
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Home Page</title>
    <link href="style1.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer">
    <style>
        .document-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            margin: 20px auto;
            max-width: 1200px;
        }
        .document-box {
            background-color: #f3f4f7;
            border: 1px solid #ccc;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            margin: 15px;
            padding: 20px;
            text-align: center;
            width: 200px; 
            transition: transform 0.2s;
            cursor: pointer; 
            text-decoration: none; 
            color: inherit; 
        }
        .document-box:hover {
            transform: scale(1.05); 
        }
        .document-title {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 10px;
        }
        .document-description {
            font-size: 14px;
            color: #666;
        }
    </style>
</head>
<body class="loggedin">
    <nav class="navtop">
        <div>
            <h1>Student Profile</h1>
            <a href="home.php"><i class="fas fa-home"></i> Home</a>
            <a href="read.php"><i class="fas fa-book"></i> Students</a>
            <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
            <a href="#" onclick="printPage()"><i class="fas fa-print"></i>Print</a>      
        </div>
    </nav>
    <div class="content">
        <h2>Home Page</h2>
        <p>Welcome back, <?= $_SESSION['name'] ?>! <br> Pick your form!</p>

        <div class="document-container">
            <a href="documents.php?document=Good%20Moral%20Certificate" class="document-box">
                <div class="document-title">Good Moral Certificate</div>
                <div class="document-description">A certificate indicating good moral character.</div>
            </a>
            <a href="documents.php?document=Promissory%20Note" class="document-box">
                <div class="document-title">Promissory Note</div>
                <div class="document-description">A written promise to pay a specified amount of money.</div>
            </a>
            <a href="documents.php?document=Psychological%20Tests" class="document-box">
                <div class="document-title">Psychological Tests</div>
                <div class="document-description">Tests used to assess psychological functioning.</div>
            </a>
            <a href="documents.php?document=Transcript" class="document-box">
                <div class="document-title">Transcript</div>
                <div class="document-description">An official record of a student's academic performance.</div>
            </a>
            <a href="documents.php?document=Certificate%20of%20Enrollment" class="document-box">
                <div class="document-title">Certificate of Enrollment</div>
                <div class="document-description">Proof of enrollment in an educational institution.</div>
            </a>
            <a href="documents.php?document=Medical%20Certificate" class="document-box">
                <div class="document-title">Medical Certificate</div>
                <div class="document-description">A document confirming a person's medical condition.</div>
            </a>
            <a href="documents.php?document=Recommendation%20Letter" class="document-box">
                <div class="document-title">Recommendation Letter</div>
                <div class="document-description">A letter recommending a person for a position or opportunity.</div>
            </a>
            <a href="documents.php?document=Application%20Form" class="document-box">
                <div class="document-title">Application Form</div>
                <div class="document-description">A form used to apply for a position or opportunity.</div>
            </a>
        </div>
    </div>
    <script>
        function printPage() {
            window.print();
        }
    </script>
</body>
</html>