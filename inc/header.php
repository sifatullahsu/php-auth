<?php
$filename = realpath(dirname(__FILE__));
include_once $filename . '/../lib/session.php';
Session::init();

if (isset($_GET['action']) && $_GET['action'] == 'logout') {
    Session::destroy();
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <title>Login Registration System</title>
</head>

<body>
    <div id="main">
        <div class="container">
            <div class="row">
                <section class="header">
                    <div class="row">
                        <div class="box">
                            <h3>Login Registration System</h3>
                            <nav style="text-align: right;">

                                <?php
                                $id = Session::get('id');
                                $isLogin = Session::get('login');

                                if ($isLogin == true) {
                                ?>
                                <a href="index.php">Home</a>
                                <a href="profile.php?id=<?php echo  $id; ?>">Profile</a>
                                <a href="changepass.php?id=<?php echo  $id; ?>">ChangePass</a>
                                <a href="?action=logout">Logout</a>
                                <?php } else { ?>
                                <a href="login.php">Login</a>
                                <a href="register.php">Register</a>
                                <?php } ?>
                            </nav>
                        </div>
                    </div>
                </section>

                <section class="content">
                    <div class="row">