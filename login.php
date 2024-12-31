<?php
include_once('utils/userstorage.php');
include_once('utils/auth.php');

include_once('services/validation.php');
include_once('services/redirection.php');

session_start();

$user_storage = new UserStorage();
$auth = new Auth($user_storage);

$data = [];
$errors = [];

if (count($_POST) > 0) {
    if (isLoginValid($_POST, $errors)) {
        $data = [
            'email' => $_POST['email'],
            'password' => $_POST['password']
        ];

        $auth_user = $auth->authenticate($data['email'], $data['password']);

        if (!$auth_user)
            $errors['global'] = "Login error";
        else {
            $auth->login($auth_user);
            redirect('index.php');
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
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

    <?php foreach ($errors as $err): ?>
        <div id="alert"
            class="fixed top-4 left-1/2 transform -translate-x-1/2 z-50 p-4 text-sm text-red-800 rounded-lg bg-red-500 text-white max-w-sm transition-opacity duration-500 opacity-100"
            role="alert">
            <span class="font-medium">Danger alert!</span> <?php echo $err ?>
        </div>
    <?php endforeach ?>

    <!-- Body Content -->
    <div class="flex flex-col items-center justify-center mt-16">
        <h1 class="text-6xl text-white font-bold">Login</h1>



        <div class="w-full mt-16 items-center justify-center">
            <form class="p-4 max-w-sm md:max-w-lg mx-auto" action="" method="post">
                <div class="mb-5">
                    <label for="email" class="text-white block mb-2 text-sm font-medium text-gray-900">username</label>
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
                <div class="flex justify-end">
                    <button type="submit"
                        class="text-[#1B1B1B] bg-amber-400 hover:bg-amber-500 font-medium rounded-full text-sm w-full sm:w-auto px-5 py-2.5 text-center">Submit</button>
                </div>
            </form>

        </div>

    </div>

</body>
<script>
    setTimeout(() => {
        const alert = document.getElementById('alert');
        if (alert) {
            alert.classList.add('opacity-0');
            setTimeout(() => {
                alert.style.display = 'none';
            }, 500);
        }
    }, 5000);
</script>

</html>