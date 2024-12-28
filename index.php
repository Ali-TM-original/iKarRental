<?php
include_once("services/redirection.php");

session_start();
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
                    <a href="/login.php"
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

    <div class="flex flex-col justify-center mt-24 ml-4 mr-4 items-center">
        <div class="flex flex-col mt-8 justify-center items-center">
            <h1 class="text-4xl text-white font-bold">Rent Cars Easily!</h1>
            <a href="/register.php"
                class="text-black text-sm md:text-lg font-semibold bg-amber-400 hover:bg-amber-500 pt-2 pb-2 pl-4 pr-4 rounded-full mt-4">
                Registration
            </a>
        </div>
        <!-- FORM component -->
        <div class="flex-col flex md:flex-row mt-8 items-center justify-center">
            <form action="" method="GET" class="flex flex-col lg:flex-row items-center p-4 rounded-lg space-x-4">
                <!-- Seats Selector -->
                <div class="flex items-center justify-center space-x-2 p-2">
                    <button type="button" id="decrease-seats"
                        class="flex items-center text-white justify-center w-8 h-8 border-2 border-gray-700  rounded-md outline-none">
                        -
                    </button>
                    <input id="noseats" type="number" name="seats" value="0" min="0"
                        class="w-12 text-center border-2 border-gray-700  rounded-md outline-none" />
                    <button type="button" id="increase-seats"
                        class="flex items-center text-white justify-center w-8 h-8 border-2 border-gray-700  rounded-md outline-none">
                        +
                    </button>
                    <span class="text-gray-400">seats</span>
                </div>

                <!-- Date Range -->
                <div class="flex items-center justify-center space-x-2">
                    <label for="from-date" class="text-gray-400">from</label>
                    <input type="date" name="from" id="from-date"
                        class="w-32 border-2 border-gray-700  text-sm rounded-md outline-none p-2 focus:ring-2 focus:ring-red-500" />
                    <label for="until-date" class="text-gray-400">until</label>
                    <input type="date" name="until" id="until-date"
                        class="w-32 border-2 border-gray-700  text-sm rounded-md outline-none p-2 focus:ring-2 focus:ring-red-500" />
                </div>

                <!-- Gear Type Dropdown -->
                <div class="p-2">
                    <select name="gear"
                        class="border-2 border-gray-700  text-sm rounded-md outline-none p-2 focus:ring-2 focus:ring-red-500">
                        <option value="" disabled selected>Gear type</option>
                        <option value="automatic">Automatic</option>
                        <option value="manual">Manual</option>
                    </select>
                </div>

                <!-- Price Range -->
                <div class="flex items-center justify-center space-x-2 p-2">
                    <input type="number" name="min_price" placeholder="14,000"
                        class="w-16 border-2 border-gray-700  text-sm rounded-md outline-none p-2 focus:ring-2 focus:ring-red-500" />
                    <span class="text-gray-400">-</span>
                    <input type="number" name="max_price" placeholder="21,000"
                        class="w-16 border-2 border-gray-700  text-sm rounded-md outline-none p-2 focus:ring-2 focus:ring-red-500" />
                    <span class="text-gray-400">Ft</span>
                </div>

                <!-- Filter Button -->
                <button type="submit"
                    class="text-black text-sm md:text-lg font-semibold bg-amber-400 hover:bg-amber-500 pt-2 pb-2 pl-4 pr-4 rounded-full">
                    Filter
                </button>
            </form>


        </div>
    </div>


</body>
<!-- ADD AT END CAUSE THIS IS CLIENT SIDED -->
<script type="text/javascript" src="./js/index.js"></script>

</html>