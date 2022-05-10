<?php

if (isset($_POST["submit"])) {
    $firstname = $_POST["firstname"];
    $surname = $_POST["surname"];
    $email = $_POST["email"];
    $username = $_POST["username"];
    $password = $_POST["password"];
    $password2 = $_POST["password2"];

    if ($password == $password2) {
        $hash = password_hash($password, PASSWORD_DEFAULT);

        $users = $db->query("SELECT email, username FROM users")->fetchAll(PDO::FETCH_ASSOC);

        $flag = true;

        foreach ($users as $user) {
            if ($user["email"] == $email || $user["username"] == $username) {
                $flag = false;
                break;
            }
        }

        if ($flag) {
            $query = $db->prepare(
                "INSERT INTO users SET
                firstname = ?,
                surname = ?,
                email = ?,
                username = ?,
                password = ?"
                );
            $insert = $query->execute([$firstname, $surname, $email, $username, $hash]);
    
            header("Location:index.php?page=log-in");
        } else {
            echo '<script>alert("The username or email address is already exist!");</script>';
        }
    } else {
        echo '<script>alert("Passwords are not same!");</script>';
    }
}

?>

<style>
.new-log-btn {
	display: block;
	width: 100%;
	height: 32px;
	font-size: 16px;
	display: flex;
	justify-content: center;
	align-items: center;
	color: #fff;
	background: #ea1b2d;
	border-radius: 4px;
	transition: 200ms background-color ease-in;
    cursor: pointer;
}
.new-log-btn:hover {
    background: #d81425;
}
</style>

<main class="log-in">
    <div class="sign-in-page">
        <div class="login">
            <div class="login-part">
                <div class="cover">
                    <h3>Sign Up</h3>
                </div>

                <form method="POST">
                    <label for="first-name" class="non-checkbox">
                        <h2>First Name</h2>
                        <input type="text" id="firstname" name="firstname" placeholder="Enter your full name" required>
                    </label>

                    <label for="surname" class="non-checkbox">
                        <h2>Surname</h2>
                        <input type="text" id="surname" name="surname" placeholder="Enter your full name" required>
                    </label>

                    <label for="email" class="non-checkbox">
                        <h2>Email</h2>
                        <input type="email" id="email" name="email" placeholder="Enter your email address" required>
                    </label>

                    <label for="username" class="non-checkbox">
                        <h2>Username</h2>
                        <input type="text" id="username" name="username" placeholder="Enter username" required>
                    </label>

                    <label for="password" class="non-checkbox">
                        <h2>Password</h2>
                        <input type="password" id="password" name="password" placeholder="Enter password" required>
                    </label>

                    <label for="password" class="non-checkbox">
                        <h2>Password Again</h2>
                        <input type="password" id="password-again" name="password2" placeholder="Enter password again" required>
                    </label>

                    <input type="hidden" name="submit" value="1">

                    <button class="new-log-btn" type="submit">Sign Up</button>
                </form>
            </div>
        </div>
    </div>
</main>