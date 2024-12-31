<?php
include_once("utils/auth.php");
include_once("utils/bookingstorage.php");
include_once("services/redirection.php");

session_start();
if (!isset($_SESSION['user']) || !in_array("admin", $_SESSION['user']['roles'])) {
    redirect('login.php');
}
$id = isset($_GET['id']) ? $_GET['id'] : null;

$b = new BookingStorage();

$b->deleteMany(function ($car) use ($id) {
    return $car['id'] === $id; // Filter by matching `id`
});

redirect('index.php');