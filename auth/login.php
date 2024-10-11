<?php require "../includes/navbar.php"; ?>
<?php require "../config/config.php"; ?>

<?php
if (isset($_SESSION['username'])) {
    header("location: index.php" . APPURL . "index.php");
}

if (isset($_POST['submit'])) {
    if (empty($_POST['email']) || empty($_POST['password'])) {
        echo "<script>alert('One or more inputs are empty');</script>";
    } else {
        $email = $_POST['email'];
        $password = $_POST['password'];

        $login = $conn->prepare("SELECT * FROM users WHERE email = :email");
        $login->bindParam(":email", $email);

        $login->execute();

        $fetch = $login->fetch(PDO::FETCH_ASSOC);

        if ($login->rowCount() > 0) {
            if (password_verify($password, $fetch['password'])) {
                $_SESSION['username'] = $fetch['username'];
                $_SESSION['name'] = $fetch['name'];
                $_SESSION['user_id'] = $fetch['id'];
                $_SESSION['email'] = $fetch['email'];
                $_SESSION['user_image'] = $fetch['avatar'];

                header("location: " . APPURL . "");
                exit(); // Add exit() to stop the script execution
            } else {
                echo "<script>alert('Email or password is wrong');</script>";
            }
        }
    }
}
?>
<div class="flex items-center justify-center h-screen bg-gray-100 ">
    <div class="bg-white shadow-md rounded-lg p-8 w-96 ">

        <h2 class="text-2xl font-bold mb-6 text-center">Login</h2>
        <form role="form" method="post" action="login.php">
            <div class="mb-4">
                <label class="block text-gray-700" for="email">Email Address</label>
                <input type="email" class="mt-1 p-2 border border-gray-300 rounded w-full" name="email" placeholder="Enter Your Email Address" required>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700" for="password">Password</label>
                <input type="password" class="mt-1 p-2 border border-gray-300 rounded w-full" name="password" placeholder="Enter A Password" required>
            </div>
            <button type="submit" name="submit" class="w-full bg-red-600 text-white py-2 rounded hover:bg-red-500 transition duration-200">Login</button>
        </form>
    </div>
</div>
