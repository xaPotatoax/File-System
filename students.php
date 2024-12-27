<?php
include 'functions.php';
session_start();

if (!isset($_SESSION['loggedin'])) {
    header('Location: index.php');
    exit;
}

$pdo = pdo_connect_mysql();

if (!isset($_GET['course'])) {
    exit('No course specified!');
}

$course = htmlspecialchars($_GET['course']);

$stmt = $pdo->prepare('SELECT * FROM contacts WHERE title = ?');
$stmt->execute([$course]);
$students = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<?=template_header('Students in ' . $course)?> 

<div class="content read">
    <h2>List of Students in <?= $course ?></h2>
    <a href="create.php" class="create-contact">Add Student</a>
    <table>
        <thead>
            <tr>
                <td>ID Number</td>
                <td>Name</td>
                <td>Email</td>
                <td>Phone</td>
                <td>Date Created</td>
                <td></td>
            </tr>
        </thead>
        <tbody>
            <?php if ($students): ?>
                <?php foreach ($students as $student): ?>
                    <tr>
                        <td><?= htmlspecialchars($student['id']) ?></td>
                        <td><?= htmlspecialchars($student['name']) ?></td>
                        <td><?= htmlspecialchars($student['email']) ?></td>
                        <td><?= htmlspecialchars($student['phone']) ?></td>
                        <td><?= htmlspecialchars($student['created']) ?></td>
                        <td class="actions">
                            <a href="view.php?id=<?= $student['id'] ?>" class="view"><i class="fas fa-eye fa-xs"></i></a>
                            <a href="update.php?id=<?= $student['id'] ?>" class="edit"><i class="fas fa-pen fa-xs"></i></a>
                            <a href="#" onclick="confirmDeletion(<?= $student['id'] ?>); return false;" class="trash"><i class="fas fa-trash fa-xs"></i></a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6">No students found in this course.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
    <div class="pagination">
        <a href="home.php"><i class="fas fa-angle-double-left fa-sm"></i> Back to Home</a>
    </div>
</div>

<script>
function confirmDeletion(id) {
    if (confirm('Are you sure you want to delete this student?')) {
        window.location.href = 'delete.php?id=' + id;
    }
}
</script>

<?=template_footer()?>