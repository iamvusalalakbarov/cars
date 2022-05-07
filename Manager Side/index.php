<?php

if (!isset($_GET["page"])) {
    $_GET["page"] = "log-in";
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

    case "bookings":
        require_once("messages.php");
    break;
}

if ($_GET["page"] != "log-in") {
    require_once("footer.php");
}

?>