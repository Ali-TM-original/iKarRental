<?php
include_once("services/redirection.php");
include_once("utils/carstorage.php");
include_once("services/validation.php");

session_start();
$errors = [];
if (!isset($_SESSION['user'])) {
    redirect('login.php');
}

if (!in_array("admin", $_SESSION['user']['roles'])) {
    redirect('index.php');
}


if (count($_POST) > 0) {
    if (isCarValid($_POST, $errors)) {
        $cs = new CarStorage();
        $data = [
            "brand" => $_POST['brand'],
            "model" => $_POST['model'],
            "year" => intval($_POST['year']),
            "transmission" => $_POST['gear'],
            "fuel_type" => $_POST['fuel'],
            "passengers" => intval($_POST['passengers']),
            "daily_price_huf" => intval($_POST['daily_price_huf']),
            "image" => $_POST['image']
        ];
        $cs->add($data);
        redirect('index.php');
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Car Booking</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-[#1B1B1B]">

    <header class="inset-x-0 top-0 z-50 bg-[#2C2C2C] text-white">
        <nav class="flex items-center justify-between p-4 lg:px-8" aria-label="Global">
            <div class="flex lg:flex-1">
                <a href="/" class="-m-1.5 p-1.5 text-xl">
                    <h1>IKarRental</h1>
                </a>
            </div>
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
                        class="text-black text-sm md:text-lg font-semibold bg-amber-400 hover:bg-amber-500 pt-2 pb-2 pl-4 pr-4 rounded-full">Register</a>
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
    <div class="flex flex-col items-center justify-center mt-16">
        <h1 class="text-6xl text-white font-bold">Add Car</h1>
        <div class="w-full mt-16 items-center justify-center">
            <form class="p-8 max-w-sm md:max-w-lg mx-auto bg-[#2C2C2C] rounded-lg" action="" method="post">
                <div class="mb-5">
                    <label for="brand" class="text-white block mb-2 text-sm font-medium text-gray-900">Brand</label>
                    <input type="text" name="brand"
                        class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 outline-none"
                        placeholder="Toyota" required />
                </div>
                <div class="mb-5">
                    <label for="model" class="text-white block mb-2 text-sm font-medium text-gray-900">Model</label>
                    <input type="text" name="model"
                        class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 outline-none"
                        placeholder="Corolla" required />
                </div>
                <div class="mb-5">
                    <label for="year" class="text-white block mb-2 text-sm font-medium text-gray-900">Year</label>
                    <input type="number" id="year" name="year"
                        class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 outline-none"
                        placeholder="2018" required />
                </div>
                <div class="mb-5">
                    <label for="fuel" class="text-white block mb-2 text-sm font-medium text-gray-900">Fuel</label>
                    <select name="fuel"
                        class="border-2 border-gray-700  text-sm rounded-md outline-none p-2 focus:ring-2 focus:ring-red-500">
                        <option value="Petrol" selected>Petrol</option>
                        <option value="Diesel">Diesel</option>
                        <option value="Electric">Electric</option>
                    </select>
                </div>
                <div class="mb-5">
                    <label for="gear"
                        class="text-white block mb-2 text-sm font-medium text-gray-900">Transmission</label>
                    <select name="gear"
                        class="border-2 border-gray-700  text-sm rounded-md outline-none p-2 focus:ring-2 focus:ring-red-500">
                        <option value="Automatic">
                            Automatic</option>
                        <option value="Manual">
                            Manual
                        </option>
                    </select>

                </div>
                <div class="mb-5">
                    <label for="passengers"
                        class="text-white block mb-2 text-sm font-medium text-gray-900">Passengers</label>
                    <input type="number" id="passengers" name="passengers"
                        class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 outline-none"
                        placeholder="4" required />
                </div>
                <div class="mb-5">
                    <label for="daily_price_huf" class="text-white block mb-2 text-sm font-medium text-gray-900">Daily
                        Price Huf</label>
                    <input type="number" id="daily_price_huf" name="daily_price_huf"
                        class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 outline-none"
                        placeholder="1600" required />
                </div>
                <div class="mb-5">
                    <label for="image" class="text-white block mb-2 text-sm font-medium text-gray-900">image</label>
                    <input type="text" id="image" name="image"
                        class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 outline-none"
                        placeholder="www.image.jpg" required />
                </div>
                <div class="flex justify-end">
                    <button type="submit"
                        class="text-[#1B1B1B] bg-amber-400 hover:bg-amber-500 font-medium rounded-full text-sm w-full sm:w-auto px-5 py-2.5 text-center">Add</button>
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