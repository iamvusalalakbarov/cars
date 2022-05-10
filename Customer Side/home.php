<?php

if (isset($_POST["submit"])) {
    if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
        $pickupDate = $_POST["pickupDate"];
        $takeoffDate = $_POST["takeoffDate"];
    
        if ($pickupDate < $takeoffDate && strtotime($pickupDate) >= strtotime(date("m/d/Y"))) {
            $_SESSION["pickupDate"] = $pickupDate;
            $_SESSION["takeoffDate"] = $takeoffDate;
            header("Location:index.php?page=vehicles");
        } else {
            echo '<script>alert("Wrong time interval selected.");</script>';
        }
    } else {
        echo '<script>alert("Please, log in first.");</script>';
    }
}

?>

<main class="home">
        <form method="POST">
            <div class="pick-up">
                <label>
                    <h6>Pick-Up Date</h6>
                    <input type="date" name="pickupDate">
                </label>

                <label>
                    <h6>Take-Off Date</h6>
                    <input type="date" name="takeoffDate">
                </label>
            </div>

            <input type="hidden" name="submit" value="1">

            <button type="submit">Find Vehicle</button>
        </form>

        <div class="mcqueen">
            <img src="images/lightning-mcqueen.png" alt="">
        </div>
</main>