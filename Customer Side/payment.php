<?php

$cars = $db->query("SELECT * FROM cars")->fetchAll(PDO::FETCH_ASSOC);
$users = $db->query("SELECT * FROM users")->fetchAll(PDO::FETCH_ASSOC);
$bookings = $db->query("SELECT * FROM bookings")->fetchAll(PDO::FETCH_ASSOC);

foreach ($cars as $car) {
    if ($car["car_id"] == $_GET["car"]) {
        $price = $car["car_price"];
        $vehicle = $car;
        $_SESSION["car_name"] = $car["car_name"];
    }
}

$interval = strtotime($_SESSION["takeoffDate"]) - strtotime($_SESSION["pickupDate"]);
$interval = round($interval / (24 * 60 * 60));

$amount = $price * $interval;

if (isset($_POST["submit"])) {
    $firstname = $_POST["firstname"];
    $surname = $_POST["surname"];
    $email = $_POST["email"];
    $cardNumber = $_POST["card_number"] % 10000;
    $username = $_SESSION["username"];

    $_SESSION["amount"] = $amount;

    foreach ($users as $user) {
        if ($user["username"] == $username) {
            $userID = $user["user_id"];
            break;
        }
    }

    $query = $db->prepare(
        "INSERT INTO bookings SET
        user_id = ?,
        car_id = ?,
        pickup_date = ?,
        takeoff_date = ?"
        );
    $insert = $query->execute([$userID, $_GET["car"], $_SESSION["pickupDate"], $_SESSION["takeoffDate"]]);

    $bookingID = end($bookings)["booking_id"];

    $query = $db->prepare(
        "INSERT INTO payments SET
        firstname = ?,
        surname = ?,
        email = ?,
        card_number = ?,
        amount = ?,
        user_id = ?,
        booking_id = ?"
        );
    $insert = $query->execute([$firstname, $surname, $email, $cardNumber, $amount, $userID, $bookingID]);

    header("Location:index.php?page=review");
}

?>

<main class="payment">
    <form class="new-form" method="POST">
        <h1>Payment and Customer Details</h1>
        <div class="table">
            <div class="left">
                <h3>Total for rent</h3>
                <p>Price of the car</p>
                <p>Number of days</p>
            </div>
            <div class="right">
                <h3><?php echo $amount . "$"; ?></h3>
                <p><?php echo $price . "$"; ?></p>
                <p><?php echo $interval; ?></p>
            </div>
        </div>

        <h2><label><i class="fas fa-user"></i></label>Customer Information</h2>
        <div class="guest-info new-card">
            <input type="text" placeholder="First Name" name="firstname" required>
            <input type="text" placeholder="Last Name" name="surname" required>
            <input type="email" placeholder="Email" name="email" required>
        </div>

        <h2><label><i class="far fa-credit-card"></i></label>Payment</h2>
        <div class="card-info new-card">
            <div>
                <input type="text" placeholder="Card Holder" required>
            </div>

            <div>
                <input type="text" pattern="[0-9]+" minlength="16" maxlength="16" placeholder="Card Number" name="card_number" required>
            </div>

            <div>
                <input type="text" placeholder="CVV" pattern="[0-9]+" minlength="3" maxlength="3" required>
            </div>

            <div>
                <select name="months" id="months" required>
                    <option value="01">January</option>
                    <option value="02">February</option>
                    <option value="03">March</option>
                    <option value="04">April</option>
                    <option value="05">May</option>
                    <option value="06">June</option>
                    <option value="07">July</option>
                    <option value="08">August</option>
                    <option value="09">September</option>
                    <option value="10">October</option>
                    <option value="11">November</option>
                    <option value="12">December</option>
                </select>

                <select name="years" id="years" required>
                    <option value="2023">2023</option>
                    <option value="2024">2024</option>
                    <option value="2025">2025</option>
                    <option value="2026">2026</option>
                    <option value="2028">2027</option>
                    <option value="2028">2028</option>
                    <option value="2029">2029</option>
                    <option value="2030">2030</option>
                </select>
            </div>
        </div>

        <input type="hidden" name="submit" value="1">

        <button type="submit" class="button">Pay</button>
    </form>

    <aside>
        <div class="photo">
            <img src="<?php echo "images/" . $vehicle["car_filename"]; ?>">
        </div>
        <h2><?php echo $vehicle["car_name"]; ?></h2>
        <p class="date"><?php echo date("j F Y", strtotime($_SESSION["pickupDate"])) . " - " . date("j F Y", strtotime($_SESSION["takeoffDate"])); ?></p>
        <a href="index.php">Go Back</a>
    </aside>
</main>