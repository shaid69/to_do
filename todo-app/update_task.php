<?php
include 'db.php';

if (isset($_POST['id'])) {
    $id = $_POST['id'];
    $conn->query("UPDATE tasks SET is_completed = 1 - is_completed WHERE id = $id");
}
?>
