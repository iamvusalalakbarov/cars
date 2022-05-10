<?php

if (isset($_POST["submit"])) {
    $username = $_POST["username"];
    $password = $_POST["password"];

    $users = $db->query("SELECT username, password FROM users")->fetchAll(PDO::FETCH_ASSOC);

    $flag = false;

    foreach ($users as $user) {
        if ($user["username"] == $username && password_verify($password, $user["password"])) {
            $flag = true;
            break;
        }
    }

    if ($flag) {
        $_SESSION['loggedin'] = true;
        $_SESSION['username'] = $username;
        header("Location:index.php?page=home");
    } else {
        echo '<script>alert("Username and password does not matched!");</script>';
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
                        <h3>Log In</h3>
                    </div>
        
                    <form method="POST">
                        <label for="username" class="non-checkbox">
                            <h2>Username</h2>
                            <input type="text" id="username" name="username" placeholder="Enter username" required>
                        </label>
        
                        <label for="password" class="non-checkbox">
                            <h2>Password</h2>
                            <input type="password" id="password" name="password" placeholder="Enter password" required>
                        </label>

                        <input type="hidden" name="submit" value="1">

                        <button class="new-log-btn" type="submit">Log In</button>
        
                        <a href="#" class="forgot-password">
                            <i class="fa-solid fa-lock"></i>
                            <span>Forgot your password?</span>
                        </a>
                    </form>
                </div>
            </div>
        </div>
    </main>