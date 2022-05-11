<?php

if (isset($_POST["submit"])) {
    $firstname = $_POST["firstname"];
    $surname = $_POST["surname"];
    $email = $_POST["email"];
    $message = $_POST["message"];

    $query = $db->prepare(
        "INSERT INTO messages SET
        firstname = ?,
        surname = ?,
        email = ?,
        message = ?"
        );
    $insert = $query->execute([$firstname, $surname, $email, $message]);
}

?>

<main class="contact">
        <h1>Contact Us</h1>

        <form method="POST">
            <input type="text" placeholder="First Name" name="firstname" required>
            <input type="text" placeholder="Surname" name="surname" required>
            <input type="email" placeholder="E-mail" name="email" required>
            <textarea placeholder="Your message..." name="message"></textarea>
            <input type="hidden" name="submit" value="1">
            <button type="submit">Send</button>
        </form>
</main>