<?php
ob_start(); // Start output buffering
session_start(); // Start the session
require "includes/navbar.php"; // Include the navigation bar
require "config/config.php"; // Include the database configuration

// Get the user ID from the URL and sanitize it
$user_id = isset($_GET['user_id']) ? (int)$_GET['user_id'] : 0;

// Debugging output

// Fetch user details from the database
$userQuery = $conn->prepare("SELECT * FROM users WHERE id = :user_id");
$userQuery->execute([':user_id' => $user_id]);
$user = $userQuery->fetch(PDO::FETCH_OBJ);

// Check if the user exists

// Fetch topics created by the user
$topicsQuery = $conn->prepare("SELECT * FROM topic WHERE user_id = :user_id");
$topicsQuery->execute([':user_id' => $user_id]);
$topics = $topicsQuery->fetchAll(PDO::FETCH_OBJ);

ob_end_flush(); // Flush the output buffer
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($user->username); ?>'s Topics</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100">
<div class="container ">
    <div class="bg-white shadow-md rounded-lg p-6 text-center">
        <h1 class="text-2xl font-semibold mb-4"><?php echo htmlspecialchars($user->username); ?>'s Topics</h1>
        <h2 class="text-xl font-semibold mt-6 mb-4">Topics Created</h2>
    </div>
    <ul class="list-disc pl-5">
        <?php if (count($topics) > 0): ?>
            <?php foreach ($topics as $topic): ?>
                <li class="mb-2">
                    <a href="<?php echo APPURL; ?>/topics/topic.php?id=<?php echo $topic->id; ?>" class="text-blue-600 hover:underline"><?php echo htmlspecialchars($topic->title); ?></a>
                    <span class="text-gray-500"> - <?php echo date("M d, Y", strtotime($topic->created_at)); ?></span>
                </li>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No topics found for this user.</p>
        <?php endif; ?>
    </ul>
</div>
</body>
</html>
