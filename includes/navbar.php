<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start(); // Start the session only if it's not already active
}

define("APPURL", "http://localhost/forum"); // Ensure no space or newline here

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Header</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link href="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.css" rel="stylesheet" />
    <link href="<?php echo APPURL; ?>/css/style.css" rel="stylesheet">
    <script src="https://unpkg.com/@themesberg/flowbite@1.1.1/dist/flowbite.bundle.js"></script>

</head>
<body>

<!-- Navigation Component -->
<nav class="bg-gray-900 border-gray-300  text-white p-5">
    <div class="container mx-auto flex flex-wrap items-center justify-between">
        <a href="<?php echo APPURL; ?>/index.php" class="flex">


            <span class="self-center text-3xl whitespace-nowrap text-red-600">Forum</span>
        </a>
        <button id="dropdown-toggle" class="md:hidden text-white bg-blue-500 p-2 rounded">
            <i class="fa-solid fa-bars"></i>
        </button>
        <div class="hidden md:block w-full md:w-auto" id="mobile-menu">
            <ul class="flex-col md:flex-row flex md:space-x-8 mt-4 md:mt-0 md:text-sm md:font-medium gap-5">
                <li class="mt-2 ml-20 ">
                    <?php if (isset($_SESSION['username'])) : ?>
                        <a href="<?php echo APPURL; ?>/topics/create.php" class="py-2.5 px-5 me-2 mb-2 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700" aria-current="page">Create</a>
                    <?php endif; ?>
                </li>
                <li class="mt-2 ">

                    <a href="<?php echo APPURL; ?>/https://www.bashirmallaali.nl/projects/forum/index.php" class="py-2.5 px-5 me-2 mb-2 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700" aria-current="page">Blog</a>
                </li>


                <li>
                    <?php if (isset($_SESSION['username'])) : ?>
                        <button id="dropdownNavbarLink" data-dropdown-toggle="dropdownNavbar" class="bg-gray-900  hover:text-blue-700  text-white gap-5  border-b border-gray-100 md:hover:bg-transparent md:border-0 pl-3 pr-4 py-2 md:hover:text-blue-700 md:p-0 font-medium flex items-center justify-between w-full md:w-auto mr-10">
                            <span class="mt-2 "><?php echo $_SESSION['username'] . ' <i class="fa-solid fa-address-card"></i>'; ?></span>
                            <svg class="w-8 h-8 " fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                            </svg>
                        </button>
                        <!-- Dropdown menu -->
                        <div id="dropdownNavbar" class="hidden bg-white text-base z-10 list-none divide-y divide-gray-100 hover:text-blue-700  rounded shadow  w-44  ">
                            <div class="py-1 ">
                                <a href="<?php echo APPURL; ?>/profile.php" class="text-sm hover:bg-gray-100 text-gray-700 hover:text-blue-700  flex px-4 py-2  ">Profile</a>
                                <a href="<?php echo APPURL; ?>/auth/logout.php" class="text-sm hover:bg-gray-100 text-gray-700 hover:text-blue-700  flex px-4 py-2  ">Logout</a>
                            </div>
                        </div>
                    <?php else : ?>


                <li class="mt-2">
                                <a href="<?php echo APPURL; ?>/auth/login.php" class="text-white bg-gradient-to-r from-cyan-400 via-cyan-500 to-cyan-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-cyan-300 dark:focus:ring-cyan-800 shadow-lg shadow-cyan-500/50 dark:shadow-lg dark:shadow-cyan-800/80 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">Login</a>
                            </li>
                            <li class="mt-2">

                                <a href="<?php echo APPURL; ?>/auth/register.php" class="focus:outline-none text-white bg-purple-700 hover:bg-purple-800 focus:ring-4 focus:ring-purple-300 font-medium rounded-lg text-sm px-5 py-2.5 mb-2 dark:bg-purple-600 dark:hover:bg-purple-700 dark:focus:ring-purple-900">Register</a>
                            </li>
                        </ul>
                    <?php endif; ?>

        </div>
    </div>
</nav>

<script>
    const dropdownToggle = document.getElementById('dropdown-toggle');
    const mobileMenu = document.getElementById('mobile-menu');

    dropdownToggle.addEventListener('click', () => {
        mobileMenu.classList.toggle('hidden');
    });
</script>

<!-- Header Section -->

<script src="https://unpkg.com/@themesberg/flowbite@1.1.1/dist/flowbite.bundle.js"></script>

</body>
</html>
