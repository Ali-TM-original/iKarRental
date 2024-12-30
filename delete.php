<?php
include_once("utils/auth.php");
include_once("utils/carstorage.php");
include_once("utils/bookingstorage.php");
include_once("services/redirection.php");

session_start();
if (!isset($_SESSION['user'])) {
    redirect('login.php');
}
$id = isset($_GET['id']) ? $_GET['id'] : null;

// Deleting the car delets all the bookings as well
$c = new CarStorage();
$b = new BookingStorage();
$c->deleteMany(function ($car) use ($id) {
    return $car['id'] === intval($id); // Filter by matching `id`
});

$b->deleteMany(function ($car) use ($id) {
    return $car['id'] === intval($id); // Filter by matching `id`
});

redirect('index.php');