<?php
include 'inc/header.php';
include 'lib/user.php';

Session::checkSession();

$loginSuccessMsg = Session::get('loginMsg');

if (isset($loginSuccessMsg)) {
    echo $loginSuccessMsg;
    Session::set("loginMsg", NULL);
}

?>

<div class="min-hight">
    <div class="user-info">
        <div class="container">
            <h3 style="margin-bottom: 20px;">Welcome. <?php echo Session::get('name'); ?></h3>
        </div>
    </div>
    <table class="border">
        <tr>
            <th style="width: 5%;">No.</th>
            <th style="width: 25%;">Name</th>
            <th style="width: 30%;">Email</th>
            <th style="width: 20%;">Action</th>
        </tr>

        <?php
        $user = new User;
        $results = $user->getUserData();
        $i = 0;
        foreach ($results as $value) {
            $i++;
        ?>
        <tr>
            <td><?php echo $i; ?></td>
            <td><?php echo $value['name']; ?></td>
            <td><?php echo $value['email']; ?></td>
            <td>
                <a href="profile.php?id=<?php echo $value['id']; ?>">View</a>
            </td>
        </tr>
        <?php } ?>
    </table>
</div>



<?php

















include 'inc/footer.php';