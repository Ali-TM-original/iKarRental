<?php
include_once("services/redirection.php");

session_start();
print_r($_SESSION);
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-[#1B1B1B]">

    <header class="absolute inset-x-0 top-0 z-50 bg-[#2C2C2C] text-white">
        <nav class="flex items-center justify-between p-6 lg:px-8" aria-label="Global">
            <div class="flex lg:flex-1">
                <a href="/" class="-m-1.5 p-1.5 text-xl">
                    <h1>IKarRental</h1>
                </a>
            </div>
            <?php if (isset($_SESSION['user'])): ?>
                <div class="flex lg:flex-1 lg:justify-end space-x-8">
                    <a href="/login.php"
                        class="text-black text-sm md:text-lg font-semibold bg-amber-400 pt-2 pb-2 pl-4 pr-4 rounded-full">Profile</a>
                    <a href="/logout.php" class="text-sm md:text-lg font-semibold pt-2 pb-2 pl-4 pr-4">Log out</a>
                </div>
            <?php else: ?>
                <div class="flex lg:flex-1 lg:justify-end space-x-8">
                    <a href="/login.php" class="text-sm md:text-lg font-semibold pt-2 pb-2 pl-4 pr-4">Log in</a>
                    <a href="/register.php"
                        class="text-black text-sm md:text-lg font-semibold bg-amber-400 pt-2 pb-2 pl-4 pr-4 rounded-full">Registration</a>
                </div>
            <?php endif; ?>
        </nav>
    </header>

</body>

</html>