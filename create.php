<?php
include 'functions.php';
$pdo = pdo_connect_mysql();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = isset($_POST['id']) ? $_POST['id'] : '';
    $name = isset($_POST['name']) ? $_POST['name'] : '';
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $phone = isset($_POST['phone']) ? $_POST['phone'] : '';
    $title = isset($_POST['title']) ? $_POST['title'] : '';
    $created = isset($_POST['created']) ? $_POST['created'] : date('Y-m-d H:i:s');

    $stmt = $pdo->prepare('INSERT INTO contacts (id, name, email, phone, title, created) VALUES (?, ?, ?, ?, ?, ?)');
    if ($stmt->execute([$id, $name, $email, $phone, $title, $created])) {
        $student_name = preg_replace('/[^a-zA-Z0-9_-]/', '', $name); 
        $uploadDir = 'C:/xampp/htdocs/codes/Jem/uploads/' . $student_name . '/';
        
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true); 
        }

        header('Location: read.php');
        exit;
    } else {
        echo 'Error inserting data into the database.';
    }
}
?>

<?=template_header('Create')?> 

<div class="content update">
    <h2>Add Student</h2>
    <form action="create.php" method="post">
        <div class="form-element">
            <label for="id">ID Number</label>
            <input type="text" name="id" placeholder="Enter ID Number" id="id" required>
        </div>
        <div class="form-element">
            <label for="name">Name</label>
            <input type="text" name="name" placeholder="Enter Name" id="name" required>
        </div>
        <div class="form-element">
            <label for="email">Email</label>
            <input type="email" name="email" placeholder="email@example.com" id="email" required>
        </div>
        <div class="form-element">
            <label for="phone">Phone</label>
            <input type="text" name="phone" placeholder="+63-9xx-xxx-xxxx" id="phone" required>
        </div>
        <div class="form-element">
            <label for="title">Title</label>
            <select name="title" id="title" required>
                <option value="Information Technology"> IT</option>
                <option value="Education"> Educ</option>
                <option value="Criminology"> Crim</option>
                <option value="Law Enforcement Administration"> LEA</option>
                <option value="Agri-Business"> BSAB</option>
                <option value="Agriculture"> Agriculture</option>
                <option value="Fisheries"> PIF</option>
                <option value="Agri-Science"> DAS</option>
            </select>
        </div>
        <div class="form-element">
            <label for="created">Time Stamp</label>
            <input type="datetime-local" name="created" value="<?=date('Y-m-d\TH:i')?>" id="created" required>
        </div>
        <div class="form-element">
            <input type="submit" value="Create">
        </div>
    </form>
</div>

<?=template_footer()?>