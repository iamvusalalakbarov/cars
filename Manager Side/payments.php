<?php

$payments = $db->query(
    "SELECT p.booking_id, p.user_id, p.firstname, p.surname, p.email, p.card_number, p.amount, p.payment_date, u.username
    FROM payments p
    INNER JOIN users u ON p.user_id = u.user_id"
)->fetchAll(PDO::FETCH_ASSOC);

?>

<section class="payments">
    <table>
        <thead>
            <tr>
                <th>Booking ID</th>
                <th>Username</th>
                <th>First Name</th>
                <th>Surname</th>
                <th>Email</th>
                <th>Card Number</th>
                <th>Amount</th>
                <th>Payment Date</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($payments as $payment): ?>
                <tr>
                    <td><?php echo $payment["booking_id"]; ?></td>
                    <td><?php echo $payment["username"]; ?></td>
                    <td><?php echo $payment["firstname"]; ?></td>
                    <td><?php echo $payment["surname"]; ?></td>
                    <td><?php echo $payment["email"]; ?></td>
                    <td><?php echo "**** **** **** " . $payment["card_number"]; ?></td>
                    <td><?php echo $payment["amount"]; ?></td>
                    <td><?php echo $payment["payment_date"]; ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</section>