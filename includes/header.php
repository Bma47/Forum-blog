<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start(); // Start the session only if it's not already active
}


?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="../css/style.css">
</head>

<!-- Alert that will be shown dynamically -->
<div id="loginAlert" class="hidden fixed inset-0 flex justify-center items-center z-50">
    <div role="alert" class="w-96">
        <div class="bg-red-500 text-white font-bold rounded-t px-4 py-2">
            Waarschuwing
        </div>
        <div class="border border-t-0 border-red-400 rounded-b bg-red-100 px-4 py-3 text-red-700">
            <p>Je moet eerst login</p>
        </div>
    </div>
</div>

<!-- component -->
<div class="w-full">
    <div class="flex bg-white" style="height:600px;">
        <div class="flex items-center text-center lg:text-left px-8 md:px-12 lg:w-1/2">
            <div>
                <h2 class="text-3xl font-semibold text-gray-800 md:text-4xl p-4 ">Welcome to my <span class="text-red-600">Blog</span></h2>
                <p>Welcome to My Blog
                    Explore the latest in technology with a focus on various development fields.
                    From web and mobile app development to software and game design,
                    this blog covers essential topics like AI, cybersecurity, and cloud computing.
                    Join me as we delve into the exciting world of tech and innovation!</p>
                <div class="flex justify-center lg:justify-start mt-6">
                    <?php if (isset($_SESSION['username'])): ?>
                        <!-- If logged in, show the 'Get ready' button -->
                        <a class="px-4 py-3 bg-gray-900 text-gray-200 text-xs font-semibold rounded hover:bg-gray-800" href="<?php echo APPURL; ?>/index.php">Get ready</a>
                    <?php else: ?>
                        <!-- If not logged in, show the alert button -->
                        <a class="px-4 py-3 bg-gray-900 text-gray-200 text-xs font-semibold rounded hover:bg-gray-800" href="#" onclick="showLoginAlert(event)">Get ready</a>
                    <?php endif; ?>
                    <a class="mx-4 px-4 py-3 bg-gray-300 text-gray-900 text-xs font-semibold rounded hover:bg-gray-400" href="#">Learn More</a>
                </div>
            </div>
        </div>
        <div class="hidden lg:block lg:w-1/2" style="clip-path:polygon(10% 0, 100% 0%, 100% 100%, 0 100%)">
            <div class="image h-full object-cover" style="background-size: cover;
             object-fit: cover;
             background-position: center;
             background-image: url(https://images.unsplash.com/photo-1690140788599-e219500ef344?q=80&w=1935&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D)" >
                <div class="h-full bg-black opacity-25"></div>
            </div>
        </div>
    </div>
</div>


<script>
    // Function to show the alert
    function showLoginAlert(event) {
        event.preventDefault(); // Prevent default behavior (e.g., link redirection)
        document.getElementById("loginAlert").classList.remove("hidden");

        // Automatically hide the alert after 3 seconds
        setTimeout(() => {
            document.getElementById("loginAlert").classList.add("hidden");
        }, 3000);
    }
</script>
</body>
</html>