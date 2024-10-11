<?php

$topic = $conn->query("SELECT COUNT(*) AS all_topics FROM topic");
$topic->execute();
// In PHP verwijst de term "prepare" naar het proces van het maken van een voorbereid statement

$all_topics =$topic->fetch(PDO::FETCH_OBJ);


// all_Categories

$categories =$conn->query("SELECT categories.id AS id, categories.name AS name, 
COUNT(topic.category) AS count_categore FROM categories  JOIN topic ON 
categories.name = topic.category GROUP BY (topic.category)");


$categories->execute();


$allCategories =$categories->fetchAll(PDO::FETCH_OBJ);


?>
<div class="col-md-4">
    <div class="sidebar">


        <div class="block">
            <h3 class="text-danger">Categories</h3>
            <div class="list-group ">
                <div class="list-group " id="list-tab" role="tablist">
                    <a class="Categories list-group-item list-group-item-action bg-danger" id="list-home-list" data-bs-toggle="list" href="#list-home" role="tab" aria-controls="list-home">All Topics <span class="badge pull-right"><?php echo $all_topics->all_topics; ?></span></a>
                    <?php foreach($allCategories as $category) :?>
                        <a class="Categories list-group-item list-group-item-action bg-danger" id="list-profile-list" data-bs-toggle="list" href="#list-profile" role="tab" aria-controls="list-profile"><?php echo $category->name; ?><span class="badge pull-right"><?php echo $category->count_categore; ?></span></a>
                    <?php endforeach; ?>

                </div>
            </div>

            <!-- <div class="block" style="margin-top: 20px;">
                <h3 class="margin-top: 40px">Forum Statistics</h3>
                <div class="list-group">
                    <a href="#" class="list-group-item">Total Number of Users:<span class="color badge pull-right">4</span></a>
                    <a href="#" class="list-group-item">Total Number of Topics:<span class="color badge pull-right">9</span></a>
                    <a href="#" class="list-group-item">Total Number of Categories: <span class="color badge pull-right">12</span></a>

                </div>
            </div> -->
        </div>
    </div>




