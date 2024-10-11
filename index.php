<?php
session_start(); // Start the session
require "includes/navbar.php";
require "config/config.php";

$page_title = 'Forum';

// Number of posts per page
$postsPerPage = 4;

// Determine the current page from the URL, default is 1
if (isset($_GET['page']) && is_numeric($_GET['page'])) {
    $currentPage = (int) $_GET['page'];
} else {
    $currentPage = 1;
}

// Calculate the starting row for the query
$startRow = ($currentPage - 1) * $postsPerPage;

// Fetch the total number of topics for pagination
$totalTopicsQuery = $conn->query("SELECT COUNT(*) as total FROM topic");
$totalTopics = $totalTopicsQuery->fetch(PDO::FETCH_OBJ)->total;

// Calculate the total number of pages
$totalPages = ceil($totalTopics / $postsPerPage);

// Fetch topics with pagination and join categories to get category names
$topic = $conn->prepare("SELECT topic.id AS id, topic.title AS title, categories.name AS category_name,
    topic.user_name AS user_name, topic.user_image AS user_image, topic.created_at AS created_at,
    COUNT(replies.topic_id) AS count_replies 
    FROM topic 
    LEFT JOIN replies ON topic.id = replies.topic_id 
    LEFT JOIN categories ON topic.category = categories.id
    GROUP BY topic.id 
    ORDER BY topic.created_at DESC 
    LIMIT :startRow, :postsPerPage");

$topic->bindValue(':startRow', (int) $startRow, PDO::PARAM_INT);
$topic->bindValue(':postsPerPage', (int) $postsPerPage, PDO::PARAM_INT);
$topic->execute();
$allTopics = $topic->fetchAll(PDO::FETCH_OBJ);

?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title; ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body>
<?php include 'includes/header.php'; ?>
<div class="container mx-auto mt-6">
    <div class="w-full max-w-4xl mx-auto">
        <div class="bg-white shadow-md rounded-lg p-6">
            <h2 class="text-red-600 text-2xl font-semibold">Onderwerpen</h2>
            <hr class="my-4">
            <div class="list-unstyled">
                <?php if (count($allTopics) > 0): ?>
                    <?php foreach ($allTopics as $topic): ?>
                        <div class="flex mb-4">
                            <div class="w-1/6">
                                <img class="avatar w-16 h-16 rounded-full" src="<?php echo APPURL; ?>/img/gravatar.png" alt="User image">
                            </div>
                            <div class="w-4/6 pl-4">
                                <h3 class="text-lg font-bold">
                                    <a href="topics/topic.php?id=<?php echo $topic->id; ?>" class="text-gray-900 hover:underline"><?php echo $topic->title; ?></a>
                                </h3>
                                <p class="text-gray-500 text-sm mb-1 ">
                                <span class="text-red-500">Categorie:</span> <?php echo $topic->category_name; ?> |
                                    <span class="text-red-500">Auteur:</span><?php echo $topic->user_name; ?>
                                    |
                                    <span class="text-red-500">Gepost op:</span>  <?php echo $topic->created_at; ?>
                                </p>
                            </div>
                            <div class="w-1/6 text-right relative">
    <span class="text-white text-sm relative">
        <span class="count" style="position: absolute ; top: -11px; right: 14px;">
            <?php echo $topic->count_replies; ?>
        </span>
        <i class="fa-solid fa-comment text-4xl" style="color: #ff0000;"></i>
    </span>
                            </div>


                        </div>
                        <hr class="my-4">
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>No topics found.</p>
                <?php endif; ?>
            </div>

            <!-- Pagination -->
            <!-- Pagination -->
            <div class="mt-6 flex justify-center">
                <nav aria-label="Page navigation example">
                    <ul class="inline-flex items-center -space-x-px">
                        <?php if ($currentPage > 1): ?>
                            <li><a href="?page=<?php echo $currentPage - 1; ?>" class="px-3 py-2 ml-0 leading-tight text-gray-500 bg-white border border-gray-300 rounded-l-lg hover:bg-gray-100 hover:text-gray-700">Previous</a></li>
                        <?php endif; ?>

                        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                            <li><a href="?page=<?php echo $i; ?>" class="px-3 py-2 leading-tight <?php echo $i == $currentPage ? 'text-red-600' : 'text-gray-500'; ?> bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700"><?php echo $i; ?></a></li>
                        <?php endfor; ?>

                        <?php if ($currentPage < $totalPages): ?>
                            <li><a href="?page=<?php echo $currentPage + 1; ?>" class="px-3 py-2 leading-tight text-gray-500 bg-white border border-gray-300 rounded-r-lg hover:bg-gray-100 hover:text-gray-700">Next</a></li>
                        <?php endif; ?>
                    </ul>
                </nav>
            </div>


        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
</body>
</html>
