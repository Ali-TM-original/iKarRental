<?php
include_once("services/validation.php");
include_once("services/redirection.php");

include_once("utils/auth.php");
include_once("utils/userstorage.php");

session_start();
// print_r($_SESSION);

$data = [];
$errors = [];

if (count($_POST) > 0) {
    if (isUserValid($_POST, $errors)) {
        $data = [
            'email' => $_POST['email'],
            'fullname' => $_POST['fullname'],
            'password' => $_POST['password']
        ];

        // PASWORD: Pa$$word1234

        $auth = new Auth(new UserStorage());

        if ($auth->user_exists($data['email']))
            $errors[] = "User already exists";
        elseif (strcmp($data['password'], $_POST['passwordagain']) != 0) {
            $errors[] = "Password does not match";
        } else {
            $auth->register($data);
            redirect("/");
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-[#1B1B1B]">

    <!-- Header Section -->
    <header class="inset-x-0 top-0 z-50 bg-[#2C2C2C] text-white">
        <nav class="flex items-center justify-between p-4 lg:px-8" aria-label="Global">
            <!-- Logo Container -->
            <div class="flex lg:flex-1">
                <a href="/" class="-m-1.5 p-1.5 text-xl">
                    <h1>IKarRental</h1>
                </a>
            </div>
            <!-- Button Container -->
            <?php if (isset($_SESSION['user'])): ?>
                <div class="flex lg:flex-1 lg:justify-end space-x-8">
                    <a href="/profile.php"
                        class="text-black text-sm md:text-lg font-semibold bg-amber-400 hover:bg-amber-500 pt-2 pb-2 pl-4 pr-4 rounded-full">Profile</a>
                    <a href="/logout.php" class="text-sm md:text-lg font-semibold pt-2 pb-2 pl-4 pr-4">Log out</a>
                </div>
            <?php else: ?>
                <div class="flex lg:flex-1 lg:justify-end space-x-8">
                    <a href="/login.php" class="text-sm md:text-lg font-semibold pt-2 pb-2 pl-4 pr-4">Log in</a>
                    <a href="/register.php"
                        class="text-black text-sm md:text-lg font-semibold bg-amber-400 hover:bg-amber-500 pt-2 pb-2 pl-4 pr-4 rounded-full">Registration</a>
                </div>
            <?php endif; ?>
        </nav>
    </header>

    <!-- Body Content -->
    <div class="flex flex-col items-center justify-center mt-16">
        <h1 class="text-6xl text-white font-bold">Registration</h1>

        <!-- Create a form component here -->


        <div class="w-full mt-16 items-center justify-center">
            <form class="p-4 max-w-sm md:max-w-lg mx-auto" action="" method="post">
                <div class="mb-5">
                    <label for="fullname" class="text-white block mb-2 text-sm font-medium text-gray-900">Full
                        Name</label>
                    <input type="text" id="fullname" name="fullname"
                        class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 outline-none"
                        placeholder="jakab gipsz" required />
                </div>
                <div class="mb-5">
                    <label for="email" class="text-white block mb-2 text-sm font-medium text-gray-900">Email
                        Address</label>
                    <input type="email" id="email" name="email"
                        class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 outline-none"
                        placeholder="jakab.gipsz@ikarrental.net" required />
                </div>
                <div class="mb-5">
                    <label for="password"
                        class="text-white block mb-2 text-sm font-medium text-gray-900">password</label>
                    <input type="password" id="password" name="password"
                        class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 outline-none"
                        placeholder="******" required />
                </div>
                <div class="mb-5">
                    <label for="password-again" class="text-white block mb-2 text-sm font-medium text-gray-900">password
                        Again</label>
                    <input type="password" id="password-again" name="passwordagain"
                        class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 outline-none"
                        placeholder="******" required />
                </div>
                <button type="submit"
                    class="text-[#1B1B1B] bg-amber-400 hover:bg-amber-500 font-medium rounded-full text-sm w-full sm:w-auto px-5 py-2.5 text-center">Registration</button>

            </form>

        </div>

    </div>

</body>

</html>