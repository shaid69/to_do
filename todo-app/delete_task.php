<?php
include 'db.php';

if (isset($_POST['id'])) {
    $id = $_POST['id'];
    $conn->query("DELETE FROM tasks WHERE id = $id");
}
?>
