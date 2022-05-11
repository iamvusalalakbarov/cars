<?php

require_once("connect.php");

if (isset($_POST["submit"])) {
    $username = $_POST["username"];
    $password = $_POST["password"];

    $admins = $db->query("SELECT * FROM admins")->fetchAll(PDO::FETCH_ASSOC);

    $flag = false;

    foreach ($admins as $admin) {
        if ($admin["username"] == $username && $admin["password"] == $password) {
            $flag = true;
            break;
        }
    }

    if ($flag) {
        $_SESSION['log'] = true;
        $_SESSION['admin'] = $username;
        header("Location:index.php?page=dashboard");
    } else {
        echo '<script>alert("Username and password does not matched!");</script>';
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cars | Manager Log In</title>
    <link rel="icon" type="image/x-icon" href="./images/favicon.ico">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="./css/style.css">
    <style>
        button {
					display: flex;
					justify-content: center;
					align-items: center;
					padding: 8px 16px;
					width: 100%;
					background: #ea1b2d;
					color: #fff;
					font-size: 18px;
				}
    </style>
</head>

<body>
    <main class="manager-log-in">
        <form method="POST">
            <h1>Manager Log In</h1>

            <input type="text" placeholder="Username" name="username" required>
            <input type="password" placeholder="Password" name="password" required>
            <input type="hidden" name="submit" value="1">

            <button type="submit">Log In</button>
        </form>
    </main>
</body>

</html>
</body>

</html>