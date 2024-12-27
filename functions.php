<?php
function pdo_connect_mysql() {
    $DATABASE_HOST = 'localhost';
    $DATABASE_USER = 'root';
    $DATABASE_PASS = '';
    $DATABASE_NAME = 'phpcrud';
    try {
    	return new PDO('mysql:host=' . $DATABASE_HOST . ';dbname=' . $DATABASE_NAME . ';charset=utf8', $DATABASE_USER, $DATABASE_PASS);
    } catch (PDOException $exception) {
    	exit('Failed to connect to database!');
    }
}
function template_header($title) {  
  echo <<<EOT
  <!DOCTYPE html>
  <html>
  <head>
   <meta charset="utf8">
    <title>$title</title>  <link href="style1.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
    
    <script>
    function printPage() {
      window.print();
    }
    </script>
    <style media="print">
      nav,
      footer,
      .navtop,
      .contact-button,
      .logout,
      .fa-home,
      .fa-address-book,
      .fa-sign-out-alt,
      .fa-print {
      display: none;
      }
        </style>
  </head>
  <body>
    <nav class="navtop">
      <div>
        <h1>Guidance Office</h1>
        <form action="search_results.php" method="post">
          <label for="query"></label>
          <input type="text" id="query" name="query">
          <button type="submit" class="search-button"><i class="fas fa-search"></i>Search</button>
        </form>
        <a href="home.php"><i class="fas fa-home"></i>Home</a>
        <a href="read.php" class="contact-button"><i class="fas fa-address-book"></i>Students</a>
        <a href="logout.php" class="logout"><i class="fas fa-sign-out-alt"></i>Logout</a>
        <a href="#" onclick="printPage()"><i class="fas fa-print"></i>Print</a>      
        </div>
    
    </nav>
  EOT;
  }
function template_footer() {
  echo '
  </div>
  <script src="https://kit.fontawesome.com/yourcode.js"></script>
</body>
</html>
';
}
?>