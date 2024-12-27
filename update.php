<?php
include 'functions.php';
$pdo = pdo_connect_mysql();

if (!empty($_POST)) {
    $id = $_POST['id'];
    $name = isset($_POST['name']) ? $_POST['name'] : '';
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $phone = isset($_POST['phone']) ? $_POST['phone'] : '';
    $title = isset($_POST['title']) ? $_POST['title'] : '';
    $created = isset($_POST['created']) ? $_POST['created'] : date('Y-m-d H:i:s');

    $stmt = $pdo->prepare('SELECT name FROM contacts WHERE id = ?');
    $stmt->execute([$id]);
    $student = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($student) {
        $oldName = $student['name'];
        
        $stmt = $pdo->prepare('UPDATE contacts SET name = ?, email = ?, phone = ?, title = ?, created = ? WHERE id = ?');
        $stmt->execute([$name, $email, $phone, $title, $created, $id]);

        if ($oldName !== $name) {
            $newFolderName = preg_replace('/[^a-zA-Z0-9_-]/', '', $name);
            $oldFolderPath = 'C:/xampp/htdocs/codes/Jem/uploads/' . preg_replace('/[^a-zA-Z0-9_-]/', '', $oldName) . '/';
            $newFolderPath = 'C:/xampp/htdocs/codes/Jem/uploads/' . $newFolderName . '/';

            if (is_dir($oldFolderPath)) {
                rename($oldFolderPath, $newFolderPath);
            }
        }

        header('Location: read.php');
        exit;
    }
}

if (isset($_GET['id'])) {
    $stmt = $pdo->prepare('SELECT * FROM contacts WHERE id = ?');
    $stmt->execute([$_GET['id']]);
    $student = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$student) {
        exit('Student not found');
    }
} else {
    exit('No ID specified');
}
?>

<?=template_header('Update')?> 

<div class="content update">
    <h2>Update Student</h2>
    <form action="update.php" method="post">
        <input type="hidden" name="id" value="<?= $student['id'] ?>">
        <div class="form-element">
            <label for="name">Name</label>
            <input type="text" name="name" placeholder="Enter Name" value="<?= $student['name'] ?>" id="name" required>
        </div>
        <div class="form-element">
            <label for="email">Email</label>
            <input type="email" name="email" placeholder="email@example.com" value="<?= $student['email'] ?>" id="email" required>
        </div>
        <div class="form-element">
            <label for="phone">Phone</label>
            <input type="text" name="phone" placeholder="+63-9xx-xxx-xxxx" value="<?= $student['phone'] ?>" id="phone" required>
        </div>
        <div class="form-element">
            <label for="title">Course</label>
            <select name="title" id="title" required>
                <option value="Information Technology" <?= $student['title'] == 'Information Technology' ? 'selected' : '' ?>> IT</option>
                <option value="Education" <?= $student['title'] == 'Education' ? 'selected' : '' ?>> Educ</option>
                <option value="Criminology" <?= $student['title'] == 'Criminology' ? 'selected' : '' ?>> Crim</option>
                <option value="Law Enforcement Administration" <?= $student['title'] == 'Law Enforcement Administration' ? 'selected' : '' ?>> LEA</option>
                <option value="Agri-Business" <?= $student['title'] == 'Agri-Business' ? 'selected' : '' ?>> BSAB</option>
                <option value="Agriculture" <?= $student['title'] == 'Agriculture' ? 'selected' : '' ?>> Agriculture</option>
                <option value="Fisheries" <?= $student['title'] == 'Fisheries' ? 'selected' : '' ?>> PIF</option>
                <option value="Agri-Science" <?= $student['title'] == 'Agri-Science' ? 'selected' : '' ?>> DAS</option>
            </select>
        </div>
        <div class="form-element">
            <label for="created">Time Stamp</label>
            <input type="datetime-local" name="created" value="<?= date('Y-m-d\TH:i', strtotime($student['created'])) ?>" id="created" required>
        </div>
        <div class="form-element">
            <input type="submit" value="Update">
        </div>
    </form>
</div>

<?=template_footer()?> 