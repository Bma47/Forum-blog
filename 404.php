<?php
// Start session if needed
session_start();
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 Not Found</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
<div class="container mx-auto p-6">
    <div class="bg-white shadow-md rounded-lg p-6 text-center">
        <h1 class="text-3xl font-bold mb-4">404 - Page Not Found</h1>
        <p class="text-lg mb-4">Sorry, the page you are looking for does not exist.</p>
        <a href="index.php" class="text-blue-600 hover:underline">Go to Homepage</a>
    </div>
</div>
</body>
</html>
