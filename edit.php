<?php
include_once("services/redirection.php");
include_once("utils/carstorage.php");
include_once("utils/bookingstorage.php");
include_once("services/validation.php");

session_start();
$errors = [];
if (!isset($_SESSION['user']) || !isset($_GET['id'])) {
    redirect('login.php');
}

if (!in_array("admin", $_SESSION['user']['roles'])) {
    redirect('index.php');
}


if (isset($_GET['id'])) {

    $updated = false;
    $id = $_GET['id'];
    $cs = new CarStorage();
    $car = $cs->findOne([
        'id' => $id,
    ]);

    if (count($_POST) > 0) {
        if (isEditValid($_POST, $errors)) {
            $data = [
                "id" => $id,
                "brand" => $car['brand'],
                "model" => $car['model'],
                "year" => intval($_POST['year']),
                "transmission" => $_POST['gear'],
                "fuel_type" => $_POST['fuel'],
                "passengers" => intval($_POST['passengers']),
                "daily_price_huf" => intval($_POST['daily_price_huf']),
                "image" => $car['image']
            ];
            // print_r($data);
            $cs->update($id, $data);
            redirect('index.php');
        } else {
            // Handle This Shit
            print_r($errors);
        }
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

    <?php if ($updated == true): ?>
        <div class="flex flex-col items-center justify-center h-screen text-white">
            <!-- Icon -->
            <div class="p-6">
                <img src="/assets/verified.png" alt="verified" class="w-32 h-32 text-white">
            </div>

            <!-- Title -->
            <h1 class="text-2xl font-bold mb-4">Updated Car</h1>

            <!-- Description -->
            <p class="text-center max-w-md mb-6">
                The <?php echo $car['brand']; ?>     <?php echo $car['model']; ?> has been updated
            </p>

            <!-- Button -->
            <a href="/index.php"
                class="text-black text-sm md:text-lg font-semibold bg-amber-400 hover:bg-amber-500 pt-2 pb-2 pl-4 pr-4 rounded-full">
                Back to the vehicle side
            </a>
        </div>
    <?php endif; ?>

    <?php if ($updated == false): ?>

        <div class="flex flex-col md:flex-row justify-center rounded-lg mt-6 ml-8 mr-8 md:mt-16">
            <img class="object-cover w-full rounded-lg h-96 md:h-auto md:w-1/4" src="<?php echo $car['image']; ?>"
                alt="Car Image">
            <div class="flex flex-col justify-between pl-16 pr-16 bg-[#2c2c2c] rounded-lg">
                <h5 class="p-4 mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
                    <?php echo $car['brand']; ?>     <?php echo $car['model']; ?>
                </h5>
                <div class="p-4">
                    <form class="max-w-sm md:max-w-lg mx-auto" action="" method="post">
                        <div class="mb-5">
                            <label for="fuel" class="text-white block mb-2 text-sm font-medium text-gray-900">Fuel</label>
                            <select name="fuel"
                                class="border-2 border-gray-700  text-sm rounded-md outline-none p-2 focus:ring-2 focus:ring-red-500">
                                <option value="Petrol" <?php echo $car['fuel_type'] == "Petrol" ? "selected" : ""; ?>>Petrol
                                </option>
                                <option value="Diesel" <?php echo $car['fuel_type'] == "Diesel" ? "selected" : ""; ?>>Diesel
                                </option>
                                <option value="Electric" <?php echo $car['fuel_type'] == "Electric" ? "selected" : ""; ?>>
                                    Electric</option>
                            </select>
                        </div>
                        <div class="mb-5">
                            <label for="transmission"
                                class="text-white block mb-2 text-sm font-medium text-gray-900">Transmission</label>
                            <select name="gear"
                                class="border-2 border-gray-700  text-sm rounded-md outline-none p-2 focus:ring-2 focus:ring-red-500">
                                <option value="Automatic" <?php echo $car['transmission'] == "Automatic" ? "selected" : ""; ?>>
                                    Automatic</option>
                                <option value="Manual" <?php echo $car['transmission'] == "Manual" ? "selected" : ""; ?>>
                                    Manual
                                </option>
                            </select>

                        </div>
                        <div class="mb-5">
                            <label for="year" class="text-white block mb-2 text-sm font-medium text-gray-900">Year</label>
                            <input type="number" name="year" value="<?php echo $car['year']; ?>"
                                class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 outline-none"
                                required />
                        </div>
                        <div class="mb-5">
                            <label for="passengers"
                                class="text-white block mb-2 text-sm font-medium text-gray-900">Passengers</label>
                            <input type="number" name="passengers" value="<?php echo $car['passengers']; ?>"
                                class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 outline-none"
                                required />
                        </div>
                        <div class="mb-5">
                            <label for="daily_price_huf"
                                class="text-white block mb-2 text-sm font-medium text-gray-900">Daily Price</label>
                            <input type="number" name="daily_price_huf" value="<?php echo $car['daily_price_huf']; ?>"
                                class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 outline-none"
                                required />
                        </div>
                        <div class="flex justify-end">
                            <button type="submit"
                                class="text-[#1B1B1B] bg-amber-400 hover:bg-amber-500 font-medium rounded-full text-sm w-full sm:w-auto px-5 py-2.5 text-center">Submit</button>
                        </div>
                    </form>


                    <!-- <p class="font-normal text-white"><span class="text-gray-200">Fuel:</span>
                    <?php echo $car['fuel_type']; ?></p>
                <p class="font-normal text-white"><span class="text-gray-200">Transmission:</span>
                    <?php echo $car['transmission']; ?></p>
                <p class="font-normal text-white"><span class="text-gray-200">Year of Manufacture:</span>
                    <?php echo $car['year']; ?></p>
                <p class="font-normal text-white"><span class="text-gray-200">Number of Seats:</span>
                    <?php echo $car['passengers']; ?></p> -->
                </div>

            </div>
        </div>

    <?php endif; ?>
</body>

</html>