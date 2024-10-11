<?php
ob_start(); // Start output buffering

require "../includes/navbar.php";
require "../config/config.php";

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Fetch the topic to check ownership
    $select = $conn->prepare("SELECT * FROM topic WHERE id = :id");
    $select->execute([':id' => $id]);
    $topic = $select->fetch(PDO::FETCH_OBJ);

    if (!$topic) {
        // If no topic found, redirect or show an error
        header("Location: " . APPURL);
        exit();
    }

    if ($topic->user_name !== $_SESSION['username']) {
        // Redirect if the user is not the owner
        header("Location: " . APPURL);
        exit();
    } else {
        // Prepare and execute the delete statement
        $delete = $conn->prepare("DELETE FROM topic WHERE id = :id");
        if ($delete->execute([':id' => $id])) {
            // Redirect after successful deletion
            header("Location: " . APPURL);
            exit();
        } else {
            echo "<script>alert('Failed to delete topic.');</script>";
        }
    }
} else {
    // Redirect if no id is set
    header("Location: " . APPURL);
    exit();
}

ob_end_flush(); // End output buffering
?>
