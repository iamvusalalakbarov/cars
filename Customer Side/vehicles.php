<?php

if (!isset($_SESSION["pickupDate"]) || !isset($_SESSION["takeoffDate"])) {
    header("Location:index.php");
    echo '<style>alert("Dates are not picked.");</style>';
}

$cars = $db->query("SELECT * FROM cars")->fetchAll(PDO::FETCH_ASSOC);
$bookings = $db->query("SELECT * FROM bookings")->fetchAll(PDO::FETCH_ASSOC);

?>

<style>
.desc, .price {
    text-align: center;
    margin-bottom: 4px;
}
.price {
    font-weight: bold;
}
</style>

<main class="vehicles">
        <h1>Available Vehicles</h1>
        <div class="vehicle-list">
            <?php foreach ($cars as $car): ?>
                <?php

                $flag = true;
                
                foreach ($bookings as $booking) {
                    if ($booking["car_id"] == $car["car_id"]) {
                        if ($_SESSION["pickupDate"] >= $booking["pickup_date"] && $_SESSION["pickupDate"] <= $booking["takeoff_date"]) {
                            $flag = false;
                            break;
                        } else if ($_SESSION["takeoffDate"] >= $booking["pickup_date"] && $_SESSION["takeoffDate"] <= $booking["takeoff_date"]) {
                            $flag = false;
                            break;
                        }
                    }
                }

                ?>
                <?php if ($flag): ?>
                    <div class="vehicle">
                        <div class="image">
                            <img src="<?php echo "images/" . $car["car_filename"]; ?>">
                        </div>
                        <h3><?php echo $car["car_name"]; ?></h3>
                        <div class="desc"><?php echo $car["car_desc"]; ?></div>
                        <div class="price"><?php echo $car["car_price"] . "$ per day"; ?></div>
                        <a href="index.php?page=payment&car=<?php echo $car["car_id"]; ?>">Choose Vehicle</a>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>
    </main>