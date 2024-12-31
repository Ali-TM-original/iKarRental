<?php
include_once("services/redirection.php");
include_once("utils/carstorage.php");
include_once("utils/bookingstorage.php");

session_start();
if (!isset($_SESSION['user'])) {
    redirect('login.php');
}

$userCars = [];
$allbookedCars = [];
$cs = new CarStorage();
$booking = new BookingStorage();
$allcars = $cs->findAll();
foreach ($allcars as $car) {
    // Use the correct syntax for associative array creation
    $val = $booking->findOne([
        'id' => $car['id'],
        'email' => $_SESSION['user']['email']
    ]);

    // Check if $val is not null
    if ($val != null) {
        $userCars[] = $car; // Add the car to $userCars if a matching booking is found
    }
}

if (in_array("admin", $_SESSION['user']['roles'])) {
    foreach ($allcars as $car) {
        // Use the correct syntax for associative array creation
        $val = $booking->findOne([
            'id' => $car['id'],
        ]);

        // Check if $val is not null
        if ($val != null) {
            $car['start_date'] = $val['start_date'];
            $car['end_date'] = $val['end_date'];
            $car['email'] = $val['email'];
            $car['booking_id'] = $val['id'];
            $allbookedCars[] = $car; // Add the car to $userCars if a matching booking is found
        }
    }
}

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
            <?php endif; ?>
        </nav>
    </header>

    <div class="flex flex-col m-8">
        <div class="flex flex-col mt-8 md:flex-row items-center justify-center">
            <!-- Profile Image -->
            <div>
                <img class="w-64 h-64 object-cover rounded-lg"
                    src="https:\/\/media.ed.edmunds-media.com\/honda\/civic\/2019\/oem\/2019_honda_civic_sedan_touring_fq_oem_1_815.jpg"
                    alt="Profile Picture" />
            </div>
            <div class="text-white ml-8 text-center">
                <h1 class="text-2xl font-semibold mt-4">Logged in as</h1>
                <h2 class="text-3xl font-bold"><?php echo $_SESSION['user']['fullname']; ?></h2>
            </div>
        </div>
        <div class="flex flex-wrap justify-center items-center mt-10">
            <?php foreach ($userCars as $car): ?>
                <div class="p-4 max-w-sm">
                    <div class="rounded-lg overflow-hidden shadow-lg bg-[#42404e] relative">
                        <!-- Image Section -->
                        <div class="relative">
                            <img class="w-full h-48 object-cover" src="<?php echo $car['image']; ?>" alt="Nissan Altima" />
                        </div>

                        <!-- Content Section -->
                        <div class="flex flex-col m-4">
                            <div class="flex justify-between items-center">
                                <h2 class="text-lg text-gray-200">
                                    <?php echo $car["brand"]; ?>
                                    <span class="font-bold text-white"><?php echo $car["model"]; ?></span>
                                </h2>
                                <p class="text-gray-700 dark:text-gray-400 mt-2">
                                    <?php echo $car["passengers"]; ?> - <?php echo $car["transmission"]; ?>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

            <?php endforeach ?>
        </div>
    </div>


    <?php if (in_array("admin", $_SESSION['user']['roles'])): ?>
        <div class="flex flex-row items-center justify-center text-white">
            <h1 class="text-5xl font-bold">All Bookings</h1>
        </div>

        <div class="flex flex-wrap justify-center mt-8">
            <?php foreach ($allbookedCars as $car): ?>
                <div class="p-4 max-w-sm">
                    <div class="rounded-lg overflow-hidden shadow-lg bg-[#42404e] relative">
                        <!-- Image Section -->
                        <div class="relative">
                            <img class="w-full h-48 object-cover" src="<?php echo $car['image']; ?>" alt="Nissan Altima" />
                        </div>

                        <!-- Content Section -->
                        <div class="flex flex-col m-4">
                            <div class="flex justify-between items-center">
                                <h2 class="text-lg text-gray-200">
                                    Booked By
                                    <span class="font-bold text-white"><?php echo $car['email']; ?></span>
                                </h2>
                            </div>
                            <p class="text-gray-700 dark:text-gray-400 mt-2">
                                From <?php echo $car["start_date"]; ?>
                            </p>
                            <p class="text-gray-700 dark:text-gray-400 mt-2">
                                Till <?php echo $car["end_date"]; ?>
                            </p>
                            <a href="<?php echo 'deletebook.php?id=' . $car['booking_id']; ?>"
                                class="text-black text-sm md:text-lg text-center font-semibold bg-amber-400 hover:bg-amber-500 mt-2 pt-2 pb-2 pl-4 pr-4 rounded-full">
                                Delete Booking
                            </a>
                        </div>
                    </div>
                </div>

            <?php endforeach ?>
        </div>
    <?php endif; ?>


</body>

</html>