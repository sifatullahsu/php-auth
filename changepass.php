<?php
include 'inc/header.php';
include 'lib/user.php';

Session::checkSession();
$user = new User;

if (isset($_GET['id'])) {
    $id = (int) $_GET['id'];

    $session_id = Session::get('id');
    if ($id != $session_id) {
        header("Location: changepass.php?id=$session_id");
    }
}



if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_pass'])) {
    var_dump($_POST);
    $result = $user->updateUserPassword($id, $_POST);
}


?>

<div class="min-hight middle">


    <div class="main-box">
        <h3 class="page-title">Change Password</h3>

        <?php
        if (isset($result)) {
            echo $result;
        }
        ?>

        <form action="" method="POST">
            <div class="field-box">
                <label for="old_pass">Old Password</label>
                <input type="text" name="old_pass">
            </div>
            <div class="field-box">
                <label for="new_pass">New Password</label>
                <input type="text" name="new_pass">
            </div>
            <div class="field-box">
                <div class="field-submit">
                    <input type="submit" value="Change password" name="update_pass">
                </div>
            </div>
        </form>
    </div>
</div>

<?php
















include 'inc/footer.php';