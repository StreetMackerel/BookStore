<?php
require_once 'utils/functions.php';
require_once 'classes/User.php';

if (!is_logged_in()) {
    header("Location: login_form.php");
}

$user = $_SESSION['user'];
$users = User::allInactive();

if ($user->role_id != 1) {
    header("Location: logout.php");
}
?>
<!DOCTYPE html>
<html>
    <head>
        
        <meta charset="UTF-8">
        <title></title>
        <?php require 'utils/styles.php'; ?>
        <?php require 'utils/scripts.php'; ?>
        <link rel="stylesheet" type="text/css" href="styles/styles.css">
        <link href="https://fonts.googleapis.com/css?family=Montserrat|Open+Sans+Condensed:300|Philosopher" rel="stylesheet">
    </head>
    <body>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <?php require 'utils/header.php'; ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <?php require 'utils/toolbar.php'; ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <?php
                    echo '<h2>Hello, '.$user->username.'</h2>';
                    ?>
                </div>
            </div>
             <div class="row">
                <div class="col-md-12">
                    <h2><img src="styles/img/users.png">Inactive Users</h2>
                    <?php if (count($users) == 0) { ?>
                        <p>There are no inactive users</p>
                    <?php } else { ?>
                        <table id="table-users" class="table table-hover">
                            <thead>
                                <th>User ID</th>
                                <th>Username</th>
                                <th>Role ID</th>
                                <th></th>
                            </thead>
                            <tbody>
                                <?php foreach ($users as $userList) { ?>
                                    <tr data-id="<?= $userList->id ?>">
                                        <td><?= $userList->id ?></td>
                                        <td><?= $userList->username ?></td>
                                        <td><?= $userList->role_id ?></td>
                                        
                                            <td><a href="admin_reactivate.php?id=<?= $userList->id ?>" class="btn btn-danger">Reactivate</a></td>
                                        
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    <?php } ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <?php require 'utils/footer.php'; ?>
                </div>
            </div>
        </div>
    </body>
</html>
