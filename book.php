<?php
include_once("services/redirection.php");
include_once("utils/carstorage.php");
include_once("utils/bookingstorage.php");

session_start();

$id = isset($_GET['id']) ? $_GET['id'] : null;
$start_date = isset($_GET['start_date']) ? $_GET['start_date'] : null;
$end_date = isset($_GET['end_date']) ? $_GET['end_date'] : null;

if ($id == null) {
    redirect('index.php'); // incase ID is null
}

$cs = new CarStorage();
$car = $cs->findOne([
    'id' => $id,
]);

if ($car == null) {
    redirect('index.php');
}

$showerror = false;
$canBeBooked = true;
if ($start_date != null && $end_date != null) {
    if (!isset($_SESSION['user'])) {
        redirect('login.php');
    }
    // Try to book
    $booking = new BookingStorage();

    $book = $booking->findMany(function ($bookin) use ($id) {
        return $bookin['id'] === intval($id); // Filter by matching `id`
    });

    foreach ($book as $b) {
        $existingStart = DateTime::createFromFormat('m-d-Y', $b['start_date']);
        $existingEnd = DateTime::createFromFormat('m-d-Y', $b['end_date']);
        $requestedStart = DateTime::createFromFormat('m-d-Y', $start_date);
        $requestedEnd = DateTime::createFromFormat('m-d-Y', $end_date);


        if (!($requestedEnd < $existingStart || $requestedStart > $existingEnd) && $b['email'] == $_SESSION['user']['email']) {
            $canBeBooked = false;
            break; // No need to check further if overlap exists
        }
    }

    if ($canBeBooked) {

        $data = [
            'start_date' => $start_date,
            'end_date' => $end_date,
            'email' => $_SESSION['user']['email'],
            'id' => $car['id']
        ];

        $booking->add($data, $car['id']);

    } else {
        $showerror = true;
    }

}

?>


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
    <?php if ($showerror): ?>
        <div id="alert"
            class="fixed top-4 left-1/2 transform -translate-x-1/2 z-50 p-4 text-sm text-red-800 rounded-lg bg-red-500 text-white max-w-sm transition-opacity duration-500 opacity-100"
            role="alert">
            <span class="font-medium">Danger alert!</span> Car Cannot be booked on this date
        </div>
    <?php endif; ?>

    <?php if ($canBeBooked == false && $start_date != null): ?>
        <div class="flex flex-col items-center justify-center h-screen text-white">
            <!-- Icon -->
            <div class="p-6">
                <img src="/assets/reject.png" alt="rejected" class="w-32 h-32 text-white">
            </div>

            <!-- Title -->
            <h1 class="text-2xl font-bold mb-4">Booking failed!</h1>

            <!-- Description -->
            <p class="text-center max-w-md mb-6">
                The <?php echo $car['brand']; ?>     <?php echo $car['model']; ?> is not available in the specified interval
                from <?php echo $start_date; ?> to <?php echo $end_date; ?>.
                Try entering a different interval or search for another vehicle.
            </p>

            <!-- Button -->
            <a href="/index.php"
                class="text-black text-sm md:text-lg font-semibold bg-amber-400 hover:bg-amber-500 pt-2 pb-2 pl-4 pr-4 rounded-full">
                Back to the vehicle side
            </a>
        </div>
    <?php endif; ?>
    <?php if ($canBeBooked && $start_date != null): ?>
        <div class="flex flex-col items-center justify-center h-screen text-white">
            <!-- Icon -->
            <div class="p-6">
                <img src="/assets/verified.png" alt="rejected" class="w-32 h-32 text-white">
            </div>

            <!-- Title -->
            <h1 class="text-2xl font-bold mb-4">Successful Booking!</h1>

            <!-- Description -->
            <p class="text-center max-w-md mb-6">
                The <?php echo $car['brand']; ?>     <?php echo $car['model']; ?> has been successfuly booked for the specified
                interval
                from <?php echo $start_date; ?> to <?php echo $end_date; ?>.
                you can track the status of your reservation on your profile
            </p>

            <!-- Button -->
            <a href="/profile.php"
                class="text-black text-sm md:text-lg font-semibold bg-amber-400 hover:bg-amber-500 pt-2 pb-2 pl-4 pr-4 rounded-full">
                My Profile
            </a>
        </div>
    <?php endif; ?>

    <?php if ($car && $start_date == null): ?>
        <div class="flex flex-col md:flex-row justify-center rounded-lg mt-16 ml-8 mr-8 md:mt-64">
            <img class="object-cover w-full rounded-lg h-96 md:h-auto md:w-1/4" src="<?php echo $car['image']; ?>"
                alt="Car Image">
            <div class="flex flex-col justify-between p-4 bg-[#2c2c2c] rounded-lg">
                <h5 class="p-4 mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
                    <?php echo $car['brand']; ?>     <?php echo $car['model']; ?>
                </h5>
                <div class="p-4">
                    <p class="font-normal text-white"><span class="text-gray-200">Fuel:</span>
                        <?php echo $car['fuel_type']; ?></p>
                    <p class="font-normal text-white"><span class="text-gray-200">Transmission:</span>
                        <?php echo $car['transmission']; ?></p>
                    <p class="font-normal text-white"><span class="text-gray-200">Year of Manufacture:</span>
                        <?php echo $car['year']; ?></p>
                    <p class="font-normal text-white"><span class="text-gray-200">Number of Seats:</span>
                        <?php echo $car['passengers']; ?></p>
                </div>

                <div class="flex flex-col md:flex-row items-center justify-center space-x-4">
                    <label for="start-date" class="text-white">Start Date:</label>
                    <input type="date" name="start_date" id="start-date"
                        class="text-sm text-black bg-white hover:bg-gray-100 pl-8 pr-8 pt-2 pb-2 rounded">

                    <label for="end-date" class="text-white">End Date:</label>
                    <input type="date" name="end_date" id="end-date"
                        class="text-sm text-black bg-white hover:bg-gray-100 pl-8 pr-8 pt-2 pb-2 rounded">
                </div>

                <div class="flex flex-col p-4 space-y-4">
                    <a href="<?php echo 'book.php?id=' . $car['id']; ?>" id="book-link"
                        class="text-sm text-black bg-amber-400 hover:bg-amber-500 pl-8 pr-8 pt-2 pb-2 rounded text-center">
                        Book It
                    </a>
                </div>
            </div>
        </div>
    <?php endif; ?>

</body>
<script>
    // Get references to the date inputs and the anchor tag
    const startDateInput = document.getElementById('start-date');
    const endDateInput = document.getElementById('end-date');
    const bookLink = document.getElementById('book-link');

    // Add event listeners to update the href attribute of the link dynamically
    const updateBookingLink = () => {
        const startDate = startDateInput.value;
        const endDate = endDateInput.value;
        if (startDate && endDate) {
            const originalHref = "<?php echo 'book.php?id=' . $car['id']; ?>";
            bookLink.href = `${originalHref}&start_date=${startDate}&end_date=${endDate}`;
        }
    };

    startDateInput.addEventListener('change', updateBookingLink);
    endDateInput.addEventListener('change', updateBookingLink);

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