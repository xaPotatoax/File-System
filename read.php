<?php
include 'functions.php';
$pdo = pdo_connect_mysql();
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
$records_per_page = 5;

// Determine the sort order
$sort = isset($_GET['sort']) && in_array($_GET['sort'], ['asc', 'desc']) ? $_GET['sort'] : 'asc';
$next_sort = $sort === 'asc' ? 'desc' : 'asc'; // Toggle sort order

// Determine the sort column
$sort_column = isset($_GET['column']) && in_array($_GET['column'], ['id', 'name', 'title', 'created']) ? $_GET['column'] : 'name';

$stmt = $pdo->prepare("SELECT * FROM contacts ORDER BY $sort_column $sort LIMIT :current_page, :record_per_page");
$stmt->bindValue(':current_page', ($page-1)*$records_per_page, PDO::PARAM_INT);
$stmt->bindValue(':record_per_page', $records_per_page, PDO::PARAM_INT);
$stmt->execute();
$contacts = $stmt->fetchAll(PDO::FETCH_ASSOC);
$num_contacts = $pdo->query('SELECT COUNT(*) FROM contacts')->fetchColumn();
?>

<?=template_header('Read')?> 

<style>
    .content {
        width: 100%;
        margin: 0 auto;
        padding: 20px;
        background-color: #f9f9f9;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }
    h2 {
        color: #333;
        margin-bottom: 20px;
    }
    table {
        width: 100%; 
        border-collapse: collapse;
        margin-top: 20px;
    }
    thead {
        background-color: rgb(47, 86, 145);
        color: black;
    }
    th, td {
        padding: 12px;
        text-align: left;
        border-bottom: 1px solid #ddd;
        word-wrap: break-word; 
    }
    tbody tr {
        cursor: pointer;
    }
    tbody tr:hover {
        background-color: #f1f1f1; 
    }
    .actions {
        display: flex;
        justify-content: center; 
    }
    .actions a {
        display: flex;
        align-items: center;
        justify-content: center;
        text-decoration: none;
        color: #fff;
        padding: 5px 10px; 
        border-radius: 5px; 
    }
    .actions .view {
        background-color: #4CAF50; 
    }
    .actions .edit {
        background-color:rgb(78, 132, 175);
    }
    .actions .trash {
        background-color:rgb(155, 70, 64);
    }
    .actions a:hover {
        opacity: 0.8; 
    }
    .create-contact {
        display: inline-block;
        background-color: #38b673;
        color: white;
        padding: 10px 15px;
        text-decoration: none;
        border-radius: 5px;
        margin-bottom: 20px;
    }
    .create-contact:hover {
        background-color: #32a367;
    }
    .pagination {
        margin-top: 20px;
        text-align: center;
    }
    .pagination a {
        margin: 0 5px;
        text-decoration: none;
        color: #3f69a8;
        font-weight: bold;
        padding: 5px 10px; 
        border: 1px solid #ddd; 
        border-radius: 5px; 
    }
    .pagination a:hover {
        background-color: #f1f1f1; 
    }
</style>

<div class="content">
    <h2>Contacts</h2>
    <a href="create.php" class="create-contact">Create Contact</a>
    <table>
        <thead>
            <tr>
                <th>
                    <a href="read.php?page=<?= $page ?>&sort=<?= $next_sort ?>&column=id " style="text-decoration: none; color: inherit;">
                        ID 
                        <i class="fas fa-sort-<?= $sort === 'asc' ? 'down' : 'up' ?>" style="margin-left: 5px;"></i>
                    </a>
                </th>
                <th>
                    <a href="read.php?page=<?= $page ?>&sort=<?= $next_sort ?>&column=name" style="text-decoration: none; color: inherit;">
                        Name 
                        <i class="fas fa-sort-<?= $sort === 'asc' ? 'down' : 'up' ?>" style="margin-left: 5px;"></i>
                    </a>
                </th>
                <th>
                    <a href="read.php?page=<?= $page ?>&sort=<?= $next_sort ?>&column=title" style="text-decoration: none; color: inherit;">
                        Title 
                        <i class="fas fa-sort-<?= $sort === 'asc' ? 'down' : 'up' ?>" style="margin-left: 5px;"></i>
                    </a>
                </th>
                <th>
                    <a href="read.php?page=<?= $page ?>&sort=<?= $next_sort ?>&column=created" style="text-decoration: none; color: inherit;">
                        Created 
                        <i class="fas fa-sort-<?= $sort === 'asc' ? 'down' : 'up' ?>" style="margin-left: 5px;"></i>
                    </a>
                </th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($contacts as $contact): ?>
            <tr onclick="window.location='view.php?id=<?= $contact['id'] ?>'">
                <td><?= $contact['id'] ?></td>
                <td><?= $contact['name'] ?></td>
                <td><?= $contact['title'] ?></td>
                <td><?= $contact['created'] ?></td>
                <td class="actions">
                    <!-- <a href="view.php?id=<?=$contact['id']?>" class="view"><i class="fas fa-eye fa-xs"></i> View</a> -->
                    <a href="edit.php?id=<?= $contact['id'] ?>" class="edit">Edit</a>
                    <a href="delete.php?id=<?= $contact['id'] ?>" class="trash">Delete</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <div class="pagination">
        <?php 
        $total_pages = ceil($num_contacts / $records_per_page);
        for ($i = 1; $i <= $total_pages; $i++): 
        ?>
            <a href="read.php?page=<?= $i ?>&sort=<?= $sort ?>&column=<?= $sort_column ?>"><?= $i ?></a>
        <?php endfor; ?>
    </div>
</div>

<?=template_footer()?>