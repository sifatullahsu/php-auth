<?php

include 'inc/header.php';
include 'lib/user.php';

Session::checkLogin();

$user = new User;

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['login'])) {
    $userLogin = $user->userLogin($_POST);
}



?>

<div class="min-hight middle">


    <div class="main-box">
        <h3 class="page-title">Login Form</h3>
        <?php
        if (isset($userLogin)) {
            echo $userLogin;
        }
        ?>
        <form action="" method="POST">
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
                    <input type="submit" value="Login" name="login">
                </div>
            </div>
        </form>
    </div>
</div>

<?php

include 'inc/footer.php';