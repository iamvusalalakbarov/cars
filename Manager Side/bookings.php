<?php

$bookings = $db->query(
    "SELECT b.booking_id, b.user_id, b.car_id, u.username, c.car_name, b.booking_date, b.pickup_date, b.takeoff_date
    FROM bookings b
    INNER JOIN users u ON b.user_id = u.user_id
    INNER JOIN cars c ON b.car_id = c.car_id"
)->fetchAll(PDO::FETCH_ASSOC);

$payments = $db->query("SELECT * FROM payments")->fetchAll(PDO::FETCH_ASSOC);
$users = $db->query("SELECT * FROM users")->fetchAll(PDO::FETCH_ASSOC);
$cars = $db->query("SELECT * FROM cars")->fetchAll(PDO::FETCH_ASSOC);

if (isset($_POST["delete"])) {
    $id = $_POST["delete"];

    $flag = false;

    foreach ($payments as $payment) {
        if ($payment["booking_id"] == $id) {
            $flag = true;
            break;
        }
    }

    if ($flag) {
        $query = $db->prepare(
            "DELETE FROM payments
            WHERE booking_id = ?"
        );
        $delete = $query->execute([$id]);
    }

    $query = $db->prepare(
        "DELETE FROM bookings
        WHERE booking_id = ?"
    );
    $delete = $query->execute([$id]);

    header("Location:index.php?page=bookings");
}

if (isset($_POST["update"])) {
    $booking_id = $_POST["update"];
    $user_id = $_POST["user_id"];
    $car_id = $_POST["car_id"];
    $pickup_date = $_POST["pickup_date"];
    $takeoff_date = $_POST["takeoff_date"];

    $new_interval = strtotime($takeoff_date) - strtotime($pickup_date);
    $new_interval = round($new_interval / (24 * 60 * 60));

    foreach ($bookings as $booking) {
        if ($booking["booking_id"] == $booking_id) {
            $old_interval = strtotime($booking["takeoff_date"]) - strtotime($booking["pickup_date"]);
            $old_interval = round($old_interval / (24 * 60 * 60));
        }
    }

    if ($pickup_date < $takeoff_date && strtotime($pickup_date) >= strtotime(date("m/d/Y")) && $new_interval == $old_interval) {
        $totalQuantity = 0;

        foreach ($cars as $car) {
            if ($car_id == $car["car_id"]) {
                $totalQuantity = $car["quantity"];
            }
        }
    
        foreach ($bookings as $booking) {
            if ($car_id == $booking["car_id"] && $booking_id != $booking["booking_id"]) {
                if (($pickup_date >= $booking["pickup_date"] && $pickup_date <= $booking["takeoff_date"]) || ($takeoff_date >= $booking["pickup_date"] && $takeoff_date <= $booking["takeoff_date"]) || ($pickup_date <= $booking["pickup_date"] && $takeoff_date >= $booking["takeoff_date"])) {
                    $totalQuantity--;
                }
            }
        }
    
    
        if ($totalQuantity > 0) {
            $query = $db->prepare(
                "UPDATE bookings SET
                pickup_date = ?,
                takeoff_date = ?
                WHERE booking_id = ?"
            );
            $update = $query->execute([$pickup_date, $takeoff_date, $booking_id]);
        
            if ($update) {
                header("Location:index.php?page=bookings");
            } else {
                echo "Update is failed.";
            }
        } else {
            echo "<script>alert('No available car for chosen time interval.');</script>";
        }
    } else {
        echo "<script>alert('Date interval is incorrect!');</script>";
    }
}

?>

<section class="rents">
    <table>
        <thead>
            <tr>        
                <th>Booking ID</th>
                <th>Username</th>
                <th>Car Name</th>
                <th>Pick-up Date</th>
                <th>Take-off Date</th>
            </tr>
        </thead>
        <tbody>
            <?php if (isset($_GET["userid"])): ?>
                <?php foreach ($bookings as $booking): ?>
                    <?php if ($_GET["userid"] == $booking["user_id"]): ?>
                        <tr>
                            <form method="POST">
                                <td>
                                    <?php echo $booking["booking_id"]; ?>
                                </td>
                                <td>
                                    <?php echo $booking["username"]; ?>
                                    <input type="hidden" name="user_id" value="<?php echo $booking["user_id"]; ?>">
                                </td>
                                <td>
                                    <?php echo $booking["car_name"]; ?>
                                    <input type="hidden" name="car_id" value="<?php echo $booking["car_id"]; ?>">
                                </td>
                                <td>
                                    <input type="date" name="pickup_date" value="<?php echo $booking["pickup_date"]; ?>" required>
                                </td>
                                <td>
                                    <input type="date" name="takeoff_date" value="<?php echo $booking["takeoff_date"]; ?>" required>
                                </td>
                                <td>
                                    <input type="hidden" name="update" value="<?php echo $booking["booking_id"]; ?>">
                                    <button type="submit">[Update Booking]</button>
                                </td>
                            </form>
                            <form method="POST">
                                <td>
                                    <input type="hidden" name="delete" value="<?php echo $booking["booking_id"]; ?>">
                                    <button type="submit">[Cancel Booking]</button>
                                </td>
                            </form>
                        </tr>
                    <?php endif; ?>
                <?php endforeach; ?>
            <?php elseif (isset($_GET["carid"])): ?>
                <?php foreach ($bookings as $booking): ?>
                    <?php if ($_GET["carid"] == $booking["car_id"]): ?>
                        <tr>
                            <form method="POST">
                                <td>
                                    <?php echo $booking["booking_id"]; ?>
                                </td>
                                <td>
                                    <?php echo $booking["username"]; ?>
                                    <input type="hidden" name="user_id" value="<?php echo $booking["user_id"]; ?>">
                                </td>
                                <td>
                                    <?php echo $booking["car_name"]; ?>
                                    <input type="hidden" name="car_id" value="<?php echo $booking["car_id"]; ?>">
                                </td>
                                <td>
                                    <input type="date" name="pickup_date" value="<?php echo $booking["pickup_date"]; ?>" required>
                                </td>
                                <td>
                                    <input type="date" name="takeoff_date" value="<?php echo $booking["takeoff_date"]; ?>" required>
                                </td>
                                <td>
                                    <input type="hidden" name="update" value="<?php echo $booking["booking_id"]; ?>">
                                    <button type="submit">[Update Booking]</button>
                                </td>
                            </form>
                            <form method="POST">
                                <td>
                                    <input type="hidden" name="delete" value="<?php echo $booking["booking_id"]; ?>">
                                    <button type="submit">[Cancel Booking]</button>
                                </td>
                            </form>
                        </tr>
                    <?php endif; ?>
                <?php endforeach; ?>
            <?php else: ?>
                <?php foreach ($bookings as $booking): ?>
                    <tr>
                        <form method="POST">
                            <td>
                                <?php echo $booking["booking_id"]; ?>
                            </td>
                            <td>
                                <?php echo $booking["username"]; ?>
                                <input type="hidden" name="user_id" value="<?php echo $booking["user_id"]; ?>">
                            </td>
                            <td>
                                <?php echo $booking["car_name"]; ?>
                                <input type="hidden" name="car_id" value="<?php echo $booking["car_id"]; ?>">
                            </td>
                            <td>
                                <input type="date" name="pickup_date" value="<?php echo $booking["pickup_date"]; ?>" required>
                            </td>
                            <td>
                                <input type="date" name="takeoff_date" value="<?php echo $booking["takeoff_date"]; ?>" required>
                            </td>
                            <td>
                                <input type="hidden" name="update" value="<?php echo $booking["booking_id"]; ?>">
                                <button type="submit">[Update Booking]</button>
                            </td>
                        </form>
                        <form method="POST">
                            <td>
                                <input type="hidden" name="delete" value="<?php echo $booking["booking_id"]; ?>">
                                <button type="submit">[Cancel Booking]</button>
                            </td>
                        </form>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</section>