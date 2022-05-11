<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cars</title>
    <link rel="icon" type="image/x-icon" href="./images/favicon.ico">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="./css/style.css">
</head>

<body>
    <aside>
        <div class="logo">
            <img src="images/cars-logo.png" alt="Cars Logo">
        </div>

        <nav>
            <ul>
                <li>
                    <a href="index.php?page=dashboard" class="<?php echo ($_GET["page"] == "dashboard") ? 'active' : '' ?>"><label><i class="fas fa-home"></i></label>Dashboard</a>
                </li>
                <li>
                    <a href="index.php?page=cars" class="<?php echo ($_GET["page"] == "cars") ? 'active' : '' ?>"><label><i class="fa-solid fa-car"></i></label>Cars</a>
                </li>
                <li>
                    <a href="index.php?page=users" class="<?php echo ($_GET["page"] == "users") ? 'active' : '' ?>"><label><i class="fa-solid fa-user"></i></label>Users</a>
                </li>
                <li>
                    <a href="index.php?page=bookings" class="<?php echo ($_GET["page"] == "bookings") ? 'active' : '' ?>"><label><i class="fa-solid fa-arrow-right-arrow-left"></i></label>Bookings</a>
                </li>
                <li>
                    <a href="index.php?page=messages" class="<?php echo ($_GET["page"] == "messages") ? 'active' : '' ?>"><label><i class="fa-solid fa-inbox"></i></label>Messages</a>
                </li>
            </ul>
        </nav>
    </aside>

    <main>
        <header>
            <div class="right-side">
                <div class="admin">
                    <div class="name">
                            <p><?php echo $_SESSION["admin"]; ?></p>
                    </div>
                    <div class="log-out">
                        <a href="index.php?page=log-out"><i class="fa-solid fa-arrow-right-from-bracket"></i></a>
                    </div>
            </div>
        </header>