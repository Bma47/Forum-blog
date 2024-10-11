<?php
ob_start(); // Start output buffering

require "../includes/navbar.php";
require "../config/config.php";

if (!isset($_SESSION['username'])) {
    header("location: " . APPURL);
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $select = $conn->query("SELECT * FROM topic WHERE id='$id'");
    $select->execute();
    $topic = $select->fetch(PDO::FETCH_OBJ);

    if ($topic->user_name !== $_SESSION['username']) {
        header("location: " . APPURL);
    }
}

if (isset($_POST['submit'])) {
    if (empty($_POST['title']) || empty($_POST['category']) || empty($_POST['body'])) {
        echo "<script>alert('One or more inputs are empty');</script>";
    } else {
        $title = $_POST['title'];
        $category = $_POST['category'];
        $body = $_POST['body'];
        $user_name = $_SESSION['name'];

        $update = $conn->prepare("UPDATE topic SET title = :title, category = :category, body = :body, user_name = :user_name WHERE id = :id");
        $update->execute([
            ":title" => $title,
            ":category" => $category,
            ":body" => $body,
            ":user_name" => $user_name,
            ":id" => $id
        ]);

        header("location: " . APPURL);
    }
}
ob_end_flush(); // Flush the output buffer

$query = $conn->query("SELECT id, name FROM categories");
$categories = $query->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container mx-auto p-6">
    <div class="max-w-3xl mx-auto bg-white shadow-lg rounded-lg p-6">
        <h1 class="text-2xl font-bold mb-4">Update Topic</h1>
        <form method="POST" action="update.php?id=<?php echo $id; ?>">
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Onderwerp</label>
                <input type="text" value="<?php echo $topic->title; ?>" class="w-full p-3 border border-gray-300 rounded-lg" name="title" placeholder="Enter Post Title">
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
            <div class="mb-6">
                <label class="block text-gray-700 text-sm font-bold mb-2">Topic box</label>
                <textarea id="body" rows="10" class="w-full p-3 border border-gray-300 rounded-lg" name="body"><?php echo $topic->body; ?></textarea>
                <script>CKEDITOR.replace('body');</script>
            </div>
            <div class="flex items-center justify-between">
                <button type="submit" name="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-500">Update</button>
            </div>
        </form>
    </div>
</div>
