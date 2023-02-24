<?php

include 'inc/header.php';
include 'lib/user.php';

Session::checkLogin();

$user = new User;

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['register'])) {
    $userReg = $user->userRegistration($_POST);
}




?>
<div class="min-hight middle">
    <div class="main-box">
        <h3 class="page-title">Register Form</h3>
        <?php
        if (isset($userReg)) {
            echo $userReg . '<br>';
        }
        ?>
        <form action="" method="POST">
            <div class="field-box">
                <label for="name">Name</label>
                <input type="text" name="name">
            </div>
            <div class="field-box">
                <label for="username">Username</label>
                <input type="text" name="username">
            </div>
            <div class="field-box">
                <label for="email">Email</label>
                <input type="email" name="email">
            </div>
            <div class="field-box">
                <label for="password">Password</label>
                <input type="text" name="password">
            </div>
            <div class="field-box">
                <div class="field-submit">
                    <input type="submit" value="Register" name="register">
                </div>
            </div>
        </form>
    </div>
</div>
<?php



include 'inc/footer.php';