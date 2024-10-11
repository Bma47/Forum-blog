<?php
ob_start(); // Start output buffering

require "../includes/navbar.php";
require "../config/config.php";

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Fetch the reply to check ownership
    $select = $conn->prepare("SELECT * FROM replies WHERE id = :id");
    $select->execute([':id' => $id]);
    $reply = $select->fetch(PDO::FETCH_OBJ);

    if (!$reply) {
        // If no reply found, redirect or show an error
        header("Location: " . APPURL);
        exit();
    }

    // Check if the user is the owner of the reply
    if ($reply->user_id !== $_SESSION['user_id']) {
        // Redirect if the user is not the owner
        header("Location: " . APPURL);
        exit();
    } else {
        // Prepare and execute the delete statement for replies
        $delete = $conn->prepare("DELETE FROM replies WHERE id = :id");
        if ($delete->execute([':id' => $id])) {
            // Redirect after successful deletion
            header("Location: " . APPURL . "/topics/topic.php?id=" . $reply->topic_id);
            exit();
        } else {
            echo "<script>alert('Failed to delete reply.');</script>";
        }
    }
} else {
    // Redirect if no id is set
    header("Location: " . APPURL);
    exit();
}

ob_end_flush(); // End output buffering
?>
