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
echo '<h2>Search Results</h2>';
echo '<table>';
echo '<tr><th>ID</th><th>Name</th><th>Email</th><th>Phone</th></tr>';
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
	echo '<tr>';
	echo '<td>' . htmlspecialchars($row['id']) . '</td>';
	echo '<td><a href="view.php?id=' . htmlspecialchars($row['id']) . '">' . htmlspecialchars($row['name']) . '</a></td>';
	echo '<td>' . htmlspecialchars($row['email']) . '</td>';
	echo '<td>' . htmlspecialchars($row['phone']) . '</td>';
	echo '</tr>';
}
echo '</table>';