<?php

session_start();

date_default_timezone_set('Asia/Baku');

require_once("connect.php");

if (!isset($_GET["page"])) {
    if (!isset($_SESSION["log"]) || !$_SESSION["log"]) {
        $_GET["page"] = "log-in";
    } else {
        $_GET["page"] = "dashboard";
    }
}

if ($_GET["page"] != "log-in") {
    require_once("header.php");
}

switch ($_GET["page"]) {
    case "log-in":
        require_once("log-in.php");
    break;

    case "dashboard":
        require_once("dashboard.php");
    break;

    case "cars":
        require_once("cars.php");
    break;

    case "users":
        require_once("users.php");
    break;

    case "bookings":
        require_once("bookings.php");
    break;

    case "messages":
        require_once("messages.php");
    break;

    case "log-out":
        session_destroy();
        unset($_SESSION['log']);
        unset($_SESSION['admin']);
        header('Location:index.php?page=log-in');
    break;
}

if ($_GET["page"] != "log-in") {
    require_once("footer.php");
}

?>