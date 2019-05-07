<?php
require_once 'classes/User.php';

try {
    $users = User::all();
}
catch (Exception $ex) {
    die($ex->getMessage());
}
?>
<!DOCTYPE html>
<html>
    <head>
        
        <meta charset="UTF-8">
        <title></title>
        <?php require 'utils/styles.php'; ?>
        <?php require 'utils/scripts.php'; ?>
		<?php require_once 'classes/User.php'; ?>
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
                    <h2><img src="styles/img/users.png">Users</h2>
                    <?php if (count($users) == 0) { ?>
                        <p>There are no users</p>
                    <?php } else { ?>
                        <table id="table-users" class="table table-hover">
                            <thead>
                                <th>User ID</th>
                                <th>Username</th>
                                <th>Role ID</th>
                                <th></th>
                                <th></th>
                                <th></th>
                            </thead>
                            <tbody>
                                <?php foreach ($users as $userList) { ?>
                                    <tr data-id="<?= $userList->id ?>">
                                        <td><?= $userList->id ?></td>
                                        <td><?= $userList->username ?></td>
                                        <td><?= $userList->role_id ?></td>
                                        
                                        <?php if ($userList->role_id >= $user->role_id) { ?>
                                            <td><a href="users_edit.php?id=<?= $userList->id ?>" class="btn btn-warning">Edit</a></td>
                                            <td><a href="users_delete.php?id=<?= $userList->id ?>" class="btn btn-danger">Delete</a></td>
                                            <td><a href="users_password_form.php?id=<?= $userList->id ?>" class="btn btn-primary">Change Password</a></td>
                                                <?php } else { ?>
                                                    <td><button  class="btn btn-secondary btn-block">Not Authorized</button></td>
                                                    <td></td>
                                                    <td></td>
                                                <?php } ?>
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
