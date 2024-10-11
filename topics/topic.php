<?php
ob_start(); // Start output buffering

session_start();
require "../includes/navbar.php";
require "../config/config.php";

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Fetch the selected topic
    $topic = $conn->query("SELECT * FROM topic WHERE id='$id'");
    $topic->execute();
    $singleTopic = $topic->fetch(PDO::FETCH_OBJ);

    // Count topics by the same user
    $topicCount = $conn->query("SELECT COUNT(*) AS count_topic FROM topic WHERE user_name='$singleTopic->user_name'");
    $topicCount->execute();
    $count = $topicCount->fetch(PDO::FETCH_OBJ);

    // Fetch replies dynamically
    $reply = $conn->query("SELECT * FROM replies WHERE topic_id='$id'");
    $reply->execute();
    $allReplies = $reply->fetchAll(PDO::FETCH_OBJ);

    // Handle new replies
    if (isset($_POST['submit'])) {
        // Check if user is logged in
        if (!isset($_SESSION['username'])) {
            echo "<script>alert('You need to login to reply to this topic.');</script>";
        } else {
            if (empty($_POST['reply'])) {
                echo "<script>alert('One or more inputs are empty');</script>";
            } else {
                $reply = $_POST['reply'];
                $user_id = $_SESSION['user_id'];
                $user_image = $_SESSION['user_image'];
                $topic_id = $id;
                $user_name = $_SESSION['username'];

                $insert = $conn->prepare("INSERT INTO replies (reply, user_id, user_image, topic_id, user_name) VALUES (:reply, :user_id, :user_image, :topic_id, :user_name)");

                $insert->execute([
                    ":reply" => $reply,
                    ":user_id" => $user_id,
                    ":user_image" => $user_image,
                    ":topic_id" => $topic_id,
                    ":user_name" => $user_name,
                ]);

                header("location: " . APPURL . "/topics/topic.php?id=" . $id);
                exit();
            }
        }
    }
}
?>


<div class="container mx-auto mt-6">
    <div class="w-full max-w-4xl mx-auto">
        <div class="bg-white shadow-md rounded-lg p-6">
            <h3 class="text-xl font-semibold text-green-600 mb-4">Comments</h3>
            <hr class="mb-6" />
            <ul class="space-y-4">


                <li class="flex space-x-4 p-4">
                    <img src="../img/gravatar.png" class="w-12 h-12 rounded-full" alt="">
                    <div class="flex-1">
                        <div class="text-gray-700">
                            <p class="text-sm text-gray-500"><?php echo date("M d, Y", strtotime($singleTopic->created_at)); ?> <a href="#" class="font-semibold text-blue-600"><?php echo $singleTopic->user_name; ?></a> says:</p>
                            <p class="mt-2"><?php echo $singleTopic->body; ?></p>
                        </div>
                        <?php if (isset($_SESSION['username']) && $singleTopic->user_name == $_SESSION['username']): ?>
                            <div class="flex  space-x-2 mt-4 justify-end ">
                                <a class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-500 transition" href="../topics/delete.php?id=<?php echo $singleTopic->id; ?>"><i class="fa-solid fa-trash"></i></a>
                                <a class="px-4 py-2 bg-yellow-500 text-white rounded hover:bg-yellow-400 transition" href="../topics/update.php?id=<?php echo $singleTopic->id; ?>"><i class="fa-solid fa-pen-to-square"></i></a>
                            </div>
                        <?php endif; ?>
                    </div>
                </li>

                <?php if (count($allReplies) > 0): ?>
                    <?php foreach ($allReplies as $reply) : ?>
                        <li class="flex space-x-4  p-4">
                            <img src="../img/gravatar.png" class="w-12 h-12 rounded-full" alt="">
                            <div class="flex-1">
                                <div class="text-gray-700">
                                    <p class="text-sm text-gray-500"><?php echo date("M d, Y", strtotime($reply->created_at)); ?> <a href="#" class="font-semibold text-blue-600"><?php echo $reply->user_name; ?></a> says:</p>
                                    <p class="mt-2"><?php echo $reply->reply; ?></p>
                                </div>
                                <?php if (isset($_SESSION['username']) && $reply->user_id == $_SESSION['user_id']): ?>
                                    <div class="flex  space-x-2 mt-4 justify-end ">
                                        <a class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-500 transition" href="../topics/delete.php?id=<?php echo $singleTopic->id; ?>"><i class="fa-solid fa-trash"></i></a>
                                        <a class="px-4 py-2 bg-yellow-500 text-white rounded hover:bg-yellow-400 transition" href="../topics/update.php?id=<?php echo $singleTopic->id; ?>"><i class="fa-solid fa-pen-to-square"></i></a>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </li>
                    <?php endforeach; ?>
                <?php else: ?>
                    <li>No replies found for this topic.</li>
                <?php endif; ?>
            </ul>

            <h3 class="text-lg font-semibold mt-8 mb-4">Reply To Topic</h3>
            <div class="mt-6">
                <?php if (isset($_SESSION['username'])): ?>
                    <!-- If logged in, show the reply form -->
                    <form method="POST" action="topic.php?id=<?php echo $id; ?>">
                        <div class="mb-4">
                            <textarea id="reply" rows="5" class="w-full p-4 border border-gray-300 rounded-lg" name="reply" placeholder="Write your reply..."></textarea>
                        </div>
                        <button type="submit" name="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-500 transition">Submit</button>
                    </form>
                <?php else: ?>
                    <!-- If not logged in, show an alert message -->
                    <div class="text-red-600 font-semibold">
                        You must <a href="../auth/login.php" class="text-blue-600 underline">log in</a> to reply to this topic.
                    </div>
                <?php endif; ?>
            </div>


            <?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
?>