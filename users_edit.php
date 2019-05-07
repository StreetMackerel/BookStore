<?php
require_once 'utils/functions.php';
require_once 'classes/Gump.php';
require_once 'classes/User.php';
require_once 'classes/Role.php';
require_once 'classes/Book.php';

try {
    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        $validator = new GUMP();

        $_GET = $validator->sanitize($_GET);

        $validation_rules = array(
            'id' => 'required|integer|min_numeric,1'
        );
        $filter_rules = array(
        	'id' => 'trim|sanitize_numbers'
        );

        $validator->validation_rules($validation_rules);
        $validator->filter_rules($filter_rules);

        $validated_data = $validator->run($_GET);

        if($validated_data === false) {
            $errors = $validator->get_errors_array();
            throw new Exception("Invalid user id: " . $errors['id']);
        }
        
        $id = $validated_data['id'];
        $userEdit = User::find($id);
        $roles = Role::all();

    }
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
                    <form method="POST"
                          action="users_update.php"
                          role="form"
                          class="form-horizontal"
                          enctype="multipart/form-data"
                          >
                        <input type="hidden" name="id" value="<?= $id ?>" />
                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-3">
                                <h2>Edit User</h2>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="title" class="col-md-3 control-label">Username</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" id="username" name="username" value="<?= old('username', $userEdit->username) ?>" />
                            </div>
                            <div class="col-md-3 error">
                                <?php error('username'); ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="role_id" class="col-md-3 control-label">Role ID:</label> 
                                <div class="col-md-6">
                                    <select class="form-control" id="role_id" name="role_id">
                                        <?php foreach ($roles as $role) { ?>
                                            <?php if ($user->role_id <= $userEdit->role_id) { ?>
                                            <option <?php echo $userEdit->role_id == $role->id ? 'selected':'' ?> value="<?= $role->id ?>"><?= $role->title ?></option>
                                            <?php } ?>
                                        <?php } ?>
                                    </select>
                            </div>
                            <div class="col-md-3 error">
                                <?php error('role_id'); ?>
                            </div>
                        </div>


                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-3">
                                <a href="users_index.php" class="btn btn-default">Cancel</a>
                                <button type="submit" class="btn btn-primary pull-right">Submit</button>
                            </div>
                        </div>
                    </form>
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
