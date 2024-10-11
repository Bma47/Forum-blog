<?php
session_start(); // Start the session
ob_start(); // Start output buffering

require "../includes/navbar.php"; // Include the header
require "../config/config.php"; // Include the database configuration

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Fetch the existing reply
    $select = $conn->prepare("SELECT * FROM replies WHERE id = :id");
    $select->execute([':id' => $id]);
    $reply = $select->fetch(PDO::FETCH_OBJ);

    // Check if the user is the owner of the reply
    if ($reply->user_id !== $_SESSION['user_id']) {
        header("Location: " . APPURL);
        exit();
    }

    // Handle the form submission for updating the reply
    if (isset($_POST['update'])) {
        if (empty($_POST['reply'])) {
            echo "<script>alert('Reply cannot be empty');</script>";
        } else {
            $updatedReply = $_POST['reply'];

            // Update the reply in the database
            $update = $conn->prepare("UPDATE replies SET reply = :reply WHERE id = :id");
            $update->execute([
                ':reply' => $updatedReply,
                ':id' => $id
            ]);

            // Redirect back to the topic page after updating
            header("Location: " . APPURL . "/topics/topic.php?id=" . $reply->topic_id);
            exit();
        }
    }
} else {
    // Redirect if no id is set
    header("Location: " . APPURL);
    exit();
}

ob_end_flush(); // End output buffering
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Update Reply</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css">
</head>
<body>

<div class="container">
    <h1>Update Reply</h1>
    <form method="POST" action="">
        <div class="form-group">
            <textarea id="reply" rows="10" cols="80" class="form-control" name="reply"><?php echo htmlspecialchars($reply->reply); ?></textarea>
            <script>
                CKEDITOR.replace('reply');
            </script>
        </div>
        <button type="submit" name="update" class="btn btn-primary">Update</button>
    </form>
</div>

</body>
</html>
