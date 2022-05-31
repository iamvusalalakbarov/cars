<?php

$breakdowns = $db->query(
    "SELECT br.breakdown_id, br.car_id, br.breakdown_date, br.repair_date, c.car_name
    FROM breakdowns br
    INNER JOIN cars c ON br.car_id = c.car_id"
)->fetchAll(PDO::FETCH_ASSOC);

$cars = $db->query("SELECT * FROM cars")->fetchAll(PDO::FETCH_ASSOC);

if (isset($_POST["repair"])) {
    $query = $db->prepare(
        "UPDATE breakdowns SET
        repair_date = ?
        WHERE breakdown_id = ?"
        );
    $insert = $query->execute([date("Y-m-d"), $_POST["repair"]]);

    foreach ($breakdowns as $breakdown) {
        if ($_POST["repair"] == $breakdown["breakdown_id"]) {
            $carID = $breakdown["car_id"];
        }
    }

    foreach ($cars as $car) {
        if ($carID == $car["car_id"]) {
            $newQuantity = $car["quantity"] += 1;
            echo $newQuantity;
        }
    }

    $query = $db->prepare(
        "UPDATE cars SET
        quantity = ?
        WHERE car_id = ?"
    );
    $update = $query->execute([$newQuantity, $carID]);

    //header("Location:index.php?page=breakdowns");
}

?>

<section class="payments">
    <table>
        <thead>
            <tr>
                <th>Breakdown ID</th>
                <th>Car Name</th>
                <th>Breakdown Date</th>
                <th>Repair Date</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($breakdowns as $breakdown): ?>
                <tr>
                    <td><?php echo $breakdown["breakdown_id"]; ?></td>
                    <td><?php echo $breakdown["car_name"]; ?></td>
                    <td><?php echo $breakdown["breakdown_date"]; ?></td>
                    <td><?php echo ($breakdown["repair_date"] == "0000-00-00") ? "" : $breakdown["repair_date"]; ?></td>
                    <?php if ($breakdown["repair_date"] == "0000-00-00"): ?>
                        <form method="POST">
                            <input type="hidden" name="repair" value="<?php echo $breakdown["breakdown_id"]; ?>">
                            <td><button type="sumit">[Repair]</button></td>
                        </form>
                    <?php endif; ?>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</section>