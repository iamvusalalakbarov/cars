<?php

$cars = $db->query("SELECT * FROM cars")->fetchAll(PDO::FETCH_ASSOC);
$bookings = $db->query("SELECT * FROM bookings")->fetchAll(PDO::FETCH_ASSOC);

if (isset($_POST["insert"])) {
    $name = $_POST["name"];
    $desc = $_POST["desc"];
    $filename = $_POST["filename"];
    $price = $_POST["price"];
    $quantity = $_POST["quantity"];

    $query = $db->prepare(
        "INSERT INTO cars SET
        car_name = ?,
        car_desc = ?,
        car_filename = ?,
        car_price = ?,
        quantity = ?"
        );
    $insert = $query->execute([$name, $desc, $filename, $price, $quantity]);

    header("Location:index.php?page=cars");
}

if (isset($_POST["update"])) {
    $name = $_POST["name"];
    $desc = $_POST["desc"];
    $filename = $_POST["filename"];
    $price = $_POST["price"];
    $quantity = $_POST["quantity"];

    $i = 0;

    foreach ($bookings as $booking) {
        if ($booking["car_id"] == $_POST["update"] && strtotime($booking["takeoff_date"]) >= strtotime(date("m/d/Y"))) {
            $i++;
        }
    }


    if ($quantity >= $i) {
        $query = $db->prepare(
            "UPDATE cars SET
            car_name = ?,
            car_desc = ?,
            car_filename = ?,
            car_price = ?,
            quantity = ?
            WHERE car_id = ?"
        );
        $update = $query->execute([$name, $desc, $filename, $price, $quantity, $_POST["update"]]);
    
        if ($update) {
            header("Location:index.php?page=cars");
        } else {
            echo "Update is failed.";
        }
    } else {
        echo "<script>alert('Quantity is too low for future bookings.');</script>";
    }
}

?>

<section class="cars">
    <table>
        <thead>
            <tr>        
                <th>Car Name</th>
                <th>Description</th>
                <th>Filename</th>
                <th>Price</th>
                <th>Quantity</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($cars as $car): ?>
                <form method="POST">
                    <tr>
                        <td><input type="text" name="name" placeholder="Car Name" required value="<?php echo $car["car_name"]; ?>"></td>
                        <td><input type="text" name="desc" placeholder="Car Name" required value="<?php echo $car["car_desc"]; ?>"></td>
                        <td><input type="text" name="filename" placeholder="Car Name" required value="<?php echo $car["car_filename"]; ?>"></td>
                        <td><input type="text" name="price" placeholder="Car Name" required value="<?php echo $car["car_price"]; ?>"></td>
                        <td><input type="text" name="quantity" placeholder="Car Name" required value="<?php echo $car["quantity"]; ?>"></td>
                        <input type="hidden" name="update" value="<?php echo $car["car_id"]; ?>">
                        <td><button type="submit">[Update]</button></td>
                        <td><a class="review-link" href="index.php?page=bookings&carid=<?php echo $car["car_id"] ?>">[Select]</a></td>
                    </tr>
                </form>
            <?php endforeach; ?>
            <tr>
                <form method="POST">
                    <td><input type="text" name="name" placeholder="Car Name" required></td>
                    <td><input type="text" name="desc" placeholder="Description" required></td>
                    <td><input type="text" name="filename" placeholder="Filename" required></td>
                    <td><input type="number" name="price" placeholder="Price" required></td>
                    <td><input type="number" name="quantity" placeholder="Quantity" required></td>
                    <input type="hidden" name="insert" value="1">
                    <td><button type="submit">[Insert]</button></td>
                </form>
            </tr>
        </tbody>
    </table>
</section>