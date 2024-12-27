<?php
include 'functions.php';
$pdo = pdo_connect_mysql();

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    $stmt = $pdo->prepare('DELETE FROM contacts WHERE id = :id');
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
}

header('Location: read.php');
exit;
?>