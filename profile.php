<?php
session_start(); // Start the session
require "includes/navbar.php"; // Include the navigation bar
require "config/config.php"; // Include the database configuration

if (!isset($_SESSION['username'])) {
    header("location: " . APPURL . "/auth/login.php"); // Redirect to login if not logged in
    exit();
}

// Get the logged-in user's information
$user_name = $_SESSION['username'];
$user_id = $_SESSION['user_id']; // Make sure this is set during login

// Fetch user details from the database
$userQuery = $conn->prepare("SELECT * FROM users WHERE id = :user_id");
$userQuery->execute([':user_id' => $user_id]);
$user = $userQuery->fetch(PDO::FETCH_OBJ);

if (!$user) {
    echo "<script>alert('User not found. Please log in again.'); window.location.href = '" . APPURL . "/auth/login.php';</script>";
    exit();
}

// Fetch topics created by the user
$topicsQuery = $conn->prepare("SELECT * FROM topic WHERE user_name = :user_name");
$topicsQuery->execute([':user_name' => $user_name]);
$topics = $topicsQuery->fetchAll(PDO::FETCH_OBJ);
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($user->username); ?>'s Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body>
<div class="container mx-auto p-6">
    <div class="bg-white shadow-md rounded-lg p-6">
        <h1 class="text-2xl font-semibold mb-4">Profile: <br><?php echo htmlspecialchars($user->username); ?></h1>
        <div class="flex items-center mb-4">
            <img src="<?php echo APPURL; ?>/img/gravatar.png" alt="User Image" class="w-24 h-24 rounded-full">
            <div class="ml-4">
                <p class="text-lg font-bold"><?php echo htmlspecialchars($user->name); ?></p>
                <p class="text-gray-500"><?php echo htmlspecialchars($user->email); ?></p>
            </div>
        </div>

        <h2 class="text-xl font-semibold mt-6 mb-4">Topics Created</h2>
        <ul class="list-disc pl-5">
            <?php if (count($topics) > 0): ?>
                <?php foreach ($topics as $topic): ?>
                    <li class="mb-2">
                        <a href="<?php echo APPURL; ?>/topics/topic.php?id=<?php echo $topic->id; ?>" class="text-blue-600 hover:underline"><?php echo htmlspecialchars($topic->title); ?></a>
                        <span class="text-gray-500"> - <?php echo date("M d, Y", strtotime($topic->created_at)); ?></span>
                    </li>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No topics found.</p>
            <?php endif; ?>
        </ul>
    </div>
</div>
</body>
</html>
