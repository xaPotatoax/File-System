<?php
include 'functions.php';
session_start();

if (!isset($_SESSION['loggedin'])) {
    header('Location: index.php');
    exit;
}

$pdo = pdo_connect_mysql();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $student_id = $_POST['student_id'];
    $form_name = $_POST['form_name'];
    $form_description = $_POST['form_description'];

    $stmt = $pdo->prepare('INSERT INTO student_forms (student_id, form_name, form_description) VALUES (?, ?, ?)');
    if ($stmt->execute([$student_id, $form_name, $form_description])) {
        header('Location: view.php?id=' . $student_id);
        exit;
    } else {
        echo 'Error inserting form data into the database.';
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Form</title>
</head>
<body>
    <h2>Add Form for Student</h2>
    <form action="add_form.php" method="post">
        <input type="hidden" name="student_id" value="<?= htmlspecialchars($_GET['id']) ?>">
        <div>
            <label for="form_name">Form Name:</label>
            <input type="text" name="form_name" required>
        </div>
        <div>
            <label for="form_description">Form Description:</label>
            <textarea name="form_description" required></textarea>
        </div>
        <div>
            <input type="submit" value="Add Form">
        </div>
    </form>
</body>
</html>