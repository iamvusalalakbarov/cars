<main class="review">
    <h1>Review</h1>
    <table>
        <thead>
            <th>Car</th>
            <th>Pick-up Date</th>
            <th>Take-off Date</th>
            <th>Amount</th>
        </thead>
        <tbody>
            <tr>
                <td><?php echo $_SESSION["car_name"]; ?></td>
                <td><?php echo $_SESSION["pickupDate"]; ?></td>
                <td><?php echo $_SESSION["takeoffDate"]; ?></td>
                <td><?php echo $_SESSION["amount"] . "$"; ?></td>
            </tr>
        </tbody>
    </table>
</main>