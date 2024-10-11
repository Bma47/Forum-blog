<?php
ob_start();

include "../includes/navbar.php";
include "../config/config.php";

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header("location:index.php " . APPURL);
    exit();
}



if (isset($_POST['submit'])) {
    if (empty($_POST['title']) || empty($_POST['category']) || empty($_POST['body'])) {
        echo "<script>alert('One or more inputs are empty');</script>";
    } else {
        $title = $_POST['title'];
        $category = $_POST['category'];
        $body = $_POST['body'];
        $user_name = $_SESSION['name'];
        $user_image = $_SESSION['user_image'];

        // Handle image upload
        if (!empty($_FILES['image']['tmp_name'])) {
            $uploadDir = '../upload/'; // make sure this directory exists and is writable
            $fileName = basename($_FILES['image']['name']);
            $fileTmpName = $_FILES['image']['tmp_name'];
            $destination = $uploadDir . $fileName;

            // Check if file is an image
            $fileType = mime_content_type($fileTmpName);
            if (strpos($fileType, 'image') === false) {
                echo "<script>alert('Please upload a valid image file.');</script>";
            } else {
                if (move_uploaded_file($fileTmpName, $destination)) {
                    $user_image = $destination;
                } else {
                    echo "<script>alert('Failed to upload image.');</script>";
                }
            }
        }

        // Insert into the database
        $insert = $conn->prepare("INSERT INTO topic (title, category, body, user_name, user_image) VALUES (:title, :category, :body, :user_name, :user_image)");
        $insert->execute([
            ":title" => $title,
            ":category" => $category,
            ":body" => $body,
            ":user_name" => $user_name,
            ":user_image" => $user_image,
        ]);

        header("location: " . APPURL);
        exit();
    }
}
ob_end_flush(); // Flush the output buffer

$query = $conn->query("SELECT id, name FROM categories");
$categories = $query->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Topic</title>
    <link href="<?php echo APPURL; ?>/css/style.css" rel="stylesheet">

</head>
<body class="bg-gray-100">

<div class="container mx-auto p-4">
    <div class="w-full max-w-2xl mx-auto bg-white shadow-md rounded-lg p-8">
        <h1 class="text-2xl font-semibold mb-4 text-gray-700">Maak een onderwerp aan</h1>
        <form role="form" method="POST" action="create.php" enctype="multipart/form-data">
            <div class="mb-4">
                <label class="block text-gray-700">Hoofdonderwerp</label>
                <input type="text" class="mt-1 block w-full p-2 border border-gray-300 rounded-lg" name="title" placeholder="Enter Post Title">
            </div>
            <div class="mb-4">
                <label class="block text-gray-700">Categorie</label>
                <select name="category" class="mt-1 block w-full p-2 border border-gray-300 rounded-lg">
                    <option value="">Select a category</option>
                    <?php foreach ($categories as $category): ?>
                        <option value="<?= $category['id']; ?>"><?= $category['name']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700">Topic box</label>
                <textarea  id="editor" rows="10" class="mt-1 block w-full p-2 border border-gray-300 rounded-lg" name="body"></textarea>
                <script>CKEDITOR.replace('body');</script>
            </div>

            <button type="submit" name="submit" class="w-full bg-red-600 text-white py-2 rounded-lg hover:bg-red-500 transition duration-200">Create</button>
        </form>
    </div>
</div>

<script src="https://cdn.tiny.cloud/1/o600y5mzhn2da4m0mco3dq1s6r3wuxm41nfrbv3h09kytocq/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>




<script src="../js/editor.js"></script>
<script src="../js/forum.js"></script>