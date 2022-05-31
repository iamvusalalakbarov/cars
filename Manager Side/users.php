<?php

$users = $db->query("SELECT * FROM users")->fetchAll(PDO::FETCH_ASSOC);
$bookings = $db->query("SELECT * FROM bookings")->fetchAll(PDO::FETCH_ASSOC);

?>

<section class="users">
    <table>
        <thead>
            <tr>        
                <th>Username</th>
                <th>First Name</th>
                <th>Surname</th>
                <th>E-mail</th>
                <th>Total Reservations</th>
                <th>Active Reservations</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $user): ?>
                <tr>
                    <td><a class="review-link" href="index.php?page=bookings&userid=<?php echo $user["user_id"]; ?>"><?php echo $user["username"]; ?></a></td>
                    <td><?php echo $user["firstname"]; ?></td>
                    <td><?php echo $user["surname"]; ?></td>
                    <td><?php echo $user["email"]; ?></td>
                    <?php
                    $total = 0;
                    $active = 0;

                    foreach ($bookings as $booking) {
                        if ($booking["user_id"] == $user["user_id"]) {
                            $total++;

                            if (strtotime($booking["takeoff_date"]) >= strtotime(date("m/d/Y"))) {
                                $active++;
                            }
                        }
                    }
                    ?>
                    <td><?php echo $total; ?></td>
                    <td><?php echo $active; ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</section>