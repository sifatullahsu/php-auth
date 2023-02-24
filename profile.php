<?php
include 'inc/header.php';
include 'lib/user.php';

Session::checkSession();
$user = new User;

if (isset($_GET['id'])) {
    $id = (int) $_GET['id'];
}
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update'])) {
    $result = $user->updateUserData($id, $_POST);
}


?>

<div class="min-hight middle">


    <div class="main-box">
        <h3 class="page-title">User Details</h3>

        <?php
        if (isset($result)) {
            echo $result;
        }
        ?>

        <?php
        $data = $user->getUserDataById($id);
        if (isset($data)) {
        ?>

        <form action="" method="POST">
            <div class="field-box">
                <label for="name">Name</label>
                <input type="text" name="name" value="<?php echo $data['name']; ?>">
            </div>
            <div class="field-box">
                <label for="username">Username</label>
                <input type="text" name="username" value="<?php echo $data['username']; ?>">
            </div>
            <div class="field-box">
                <label for="email">Email</label>
                <input type="email" name="email" value="<?php echo $data['email']; ?>">
            </div>

            <?php
                $session_id = Session::get('id');
                if ($id == $session_id) {
                ?>
            <div class="field-box">
                <div class="field-submit">
                    <input type="submit" value="Update" name="update">
                </div>
            </div>
            <?php } ?>

        </form>
        <?php } ?>
    </div>
</div>

<?php
















include 'inc/footer.php';