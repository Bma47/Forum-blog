
<?php
ob_start();
require "../config/config.php";
require "../includes/navbar.php";
if (isset($_SESSION['username'])) {
    header("location: " . APPURL);
}

if (isset($_POST['submit'])) {
    if (empty($_POST['name']) || empty($_POST['email']) || empty($_POST['username']) || empty($_POST['password']) || empty($_POST['about'])) {
        echo "<script>alert('One or more inputs are empty');</script>";
    } else {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $username = $_POST['username'];
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $about = $_POST['about'];

        // File upload handling
        $avatar = $_FILES['avatar']['name'];
        $avatar_tmp = $_FILES['avatar']['tmp_name'];
        $dir = "img/" . basename($avatar);
        move_uploaded_file($avatar_tmp, $dir);

        $insert = $conn->prepare("INSERT INTO users (name, email, username, password, about, avatar) VALUES (:name, :email, :username, :password, :about, :avatar)");

        $insert->execute([
            ":name" => $name,
            ":email" => $email,
            ":username" => $username,
            ":password" => $password,
            ":about" => $about,
            ":avatar" => $avatar,
        ]);

        header("https://www.bashirmallaali.nl/projects/forum/auth/login.php");
    }
}
ob_end_flush(); // at the end

?>

<div class="flex items-center justify-center min-h-screen bg-gray-100 ">
    <div class="bg-white shadow-md rounded-lg p-8 w-96 mt-10">
        <h2 class="text-2xl font-bold mb-6 text-center">Register</h2>
        <form role="form" enctype="multipart/form-data" method="post" action="register.php">
            <div class="mb-4">
                <label class="block text-gray-700" for="name">Name*</label>
                <input type="text" class="mt-1 p-2 border border-gray-300 rounded w-full" name="name" placeholder="Enter Your Name" required>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700" for="email">Email Address*</label>
                <input type="email" class="mt-1 p-2 border border-gray-300 rounded w-full" name="email" placeholder="Enter Your Email Address" required>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700" for="username">Choose Username*</label>
                <input type="text" class="mt-1 p-2 border border-gray-300 rounded w-full" name="username" placeholder="Create A Username" required>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700" for="password">Password*</label>
                <input type="password" class="mt-1 p-2 border border-gray-300 rounded w-full" name="password" placeholder="Enter A Password" required>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700" for="password2">Confirm Password*</label>
                <input type="password" class="mt-1 p-2 border border-gray-300 rounded w-full" name="password2" placeholder="Enter Password Again" required>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700" for="avatar">Upload Avatar</label>
                <input type="file" name="avatar" class="mt-1">
                <p class="text-sm text-gray-500">Choose an avatar image.</p>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700" for="about">About Me</label>
                <textarea id="about" rows="6" class="mt-1 p-2 border border-gray-300 rounded w-full" name="about" placeholder="Tell us about yourself (Optional)"></textarea>
            </div>
            <button name="submit" type="submit" class="w-full bg-red-600 text-white py-2 rounded hover:bg-red-500 transition duration-200">Register</button>
        </form>
    </div>
</div>

