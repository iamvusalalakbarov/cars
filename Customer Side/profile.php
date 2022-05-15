<?php

$users = $db->query("SELECT * FROM users")->fetchAll(PDO::FETCH_ASSOC);
$cars = $db->query("SELECT * FROM cars")->fetchAll(PDO::FETCH_ASSOC);
$bookings = $db->query("SELECT * FROM bookings")->fetchAll(PDO::FETCH_ASSOC);
$payments = $db->query("SELECT * FROM payments")->fetchAll(PDO::FETCH_ASSOC);

foreach ($users as $user) {
    if ($user["username"] == $_SESSION["username"]) {
        $userID = $user["user_id"];
        $fullname = $user["firstname"] . " " . $user["surname"];
        break;
    }
}

$reservations = $db->query(
    "SELECT b.booking_id, b.user_id, b.car_id, b.pickup_date, b.takeoff_date, c.car_name, p.amount
	FROM bookings b
    INNER JOIN cars c ON c.car_id = b.car_id
    INNER JOIN payments p ON p.booking_id = b.booking_id"
)->fetchAll(PDO::FETCH_ASSOC);

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

    header("Location:index.php?page=profile");
}

if (isset($_POST["update"])) {
    $booking_id = $_POST["update"];
    $user_id = $userID;
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
                header("Location:index.php?page=profile");
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

<style>
    button {
        cursor: pointer;
    }
</style>

<main class="profile">
    <h1><?php echo $fullname; ?></h1>
    <table>
        <thead>
            <tr>
                <th>Car</th>
                <th>Pick-up Date</th>
                <th>Take-off Date</th>
                <th>Amount</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($reservations as $reservation): ?>
                <?php if ($reservation["user_id"] == $userID): ?>
                    <tr>
                        <?php
                        $interval = strtotime($reservation["pickup_date"]) - strtotime(date("m/d/Y"));
                        $interval = round($interval / (24 * 60 * 60));
                        ?>
                        <?php if ($interval > 0): ?>
                            <form method="POST">
                                <td><?php echo $reservation["car_name"]; ?></td>
                                <input type="hidden" name="car_id" value="<?php echo $reservation["car_id"]; ?>">
                                <td><input type="date" name="pickup_date" value="<?php echo $reservation["pickup_date"]; ?>"></td>
                                <td><input type="date" name="takeoff_date" value="<?php echo $reservation["takeoff_date"]; ?>"></td>
                                <td><?php echo $reservation["amount"] . "$"; ?></td>
                                <td>
                                    <input type="hidden" name="update" value="<?php echo $reservation["booking_id"]; ?>">
                                    <button type="submit" >[Update]</button>
                                </td>
                            </form>
                            <td>
                                <form method="POST">
                                    <input type="hidden" name="delete" value="<?php echo $reservation["booking_id"]; ?>">
                                    <button type="submit" >[Cancel]</button>
                                </form>
                            </td>
                        <?php else: ?>
                            <td><?php echo $reservation["car_name"]; ?></td>
                            <td><?php echo $reservation["pickup_date"]; ?></td>
                            <td><?php echo $reservation["takeoff_date"]; ?></td>
                            <td><?php echo $reservation["amount"] . "$"; ?></td>
                        <?php endif; ?>
                    </tr>
                <?php endif; ?>
            <?php endforeach; ?>
        </tbody>
    </table>
</main>