<?php
include 'functions.php';
?>

<link href="style.css" rel="stylesheet" type="text/css">

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Login</title>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
    <style>
        body {
            text-align: center; 
        }
        .login {
            width: 400px;
			color: #5b6574;
            box-shadow: 0 0 9px 0 rgba(0, 0, 0, 0.3);
            margin: 100px auto;
            padding: 20px;
        }
        img {
            max-width: 100%; 
            height: auto; 
            margin-bottom: 20px; 
        }
    </style>
</head>
<body>
    <div class="login">
		<img src="ISU Logo.png" alt="Description of Image"> 

        <h1>Guidance Office <br> File System</h1>
        <form action="authenticate.php" method="post">
            <label for="username">
                <i class="fas fa-user"></i>
            </label>
            <input type="text" name="username" placeholder="Username" id="username" required>
            <label for="password">
                <i class="fas fa-lock"></i>
            </label>
            <input type="password" name="password" placeholder="Password" id="password" required>
            <input type="submit" value="Login">
        </form>
    </div>
</body>
</html>