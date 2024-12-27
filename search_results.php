<!DOCTYPE html
<html><head>
  <title>Search Results</title>  <style>
    body{
      font-family:rial, sans-if;
      margin: 0;
      padding: 0;
    }
    h1{
      background-color: #333;
      color: #fff;
      margin: 0;
      padding: 1rem;
    }
    form{
      background-color: #f2f2f2;
      display: flex;
      justify-content: center;
      margin: 1rem 0;
      padding: 1rem;
    }
    label{
      margin-right: 1rem;
    }
    input[type="text"]{
      border: 1px solid #ccc;
      padding: 0.5rem;
    }
    button[type="submit"]{
      background-color: #333;
      border: none;
      color: #fff;
      padding: 0.5rem 1rem;
    }
    h2{
      background-color: #333;
      color: #fff;
      margin: 0;
      padding: 1rem;
    }
    table{
      border-collapse: collapse;
      margin: 1rem 0;
      width: 100%;
    }
    th,
    td{
      border: 1px solid #ccc;
      padding: 0.5rem;
      text-align: left;
    }
    th{
      background-color: #f2f2f2;
    }
  </style>
</head>
<body>
  <h1></h1>
  <form action="read.php" method="post">
    <button type="submit">Home</button>
  </form>
  <?php
  session_start();

  if (!isset($_SESSION['loggedin'])) {
    header('Location: index.php');
    exit;
  }

  require_once 'config.php';
  $query = $_POST['query'];
  $stmt = $pdo->prepare('SELECT * FROM contacts WHERE name LIKE :query OR email LIKE :query OR phone LIKE :query');
  $stmt->bindValue(':query', '%' . $query . '%');
  $stmt->execute();
  echo '<h2>Search Results</h2>' . PHP_EOL;
  echo '<table>' . PHP_EOL;
  echo '<tr><th>ID</th><th>Name</th><th>Email</th><th>Phone</th></tr>' . PHP_EOL;
  while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    echo '<tr>' . PHP_EOL;
    echo '<td>' . htmlspecialchars($row['id']) . '</td>' . PHP_EOL;
    echo '<td><a href="view.php?id=' . htmlspecialchars($row['id']) . '">' . htmlspecialchars($row['name']) . '</a></td>' . PHP_EOL;
    echo '<td>' . htmlspecialchars($row['email']) . '</td>' . PHP_EOL;
    echo '<td>' . htmlspecialchars($row['phone']) . '</td>' . PHP_EOL;
    echo '</tr>' . PHP_EOL;
  }
  echo '</table>' . PHP_EOL;
  ?>
</body>
</html>