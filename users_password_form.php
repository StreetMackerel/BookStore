<?php
require_once 'utils/functions.php';
require_once 'classes/Gump.php';
require_once 'classes/User.php';

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
        $userEditP = User::find($id);

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
                          action="users_password.php"
                          role="form"
                          class="form-horizontal"
                          enctype="multipart/form-data"
                          >
                        <input type="hidden" name="id" value="<?= $id ?>" />
                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-3">
                                <h2><?= $userEditP->username ?></h2>
                            </div>
                        </div>
                       
                       <div class="form-group">
                            <label for="password" class="col-md-3 control-label">New Password: </label>
                            <div class="col-md-6">
                                <input type="password"
                                       id="password"
                                       class="form-control"
                                       name="password"
                                       value=""
                                       />
                            </div>
                            <div class="col-md-3 error">
                                <?php error('password'); ?>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="password_confirmation" class="col-md-3 control-label">Confirm Password: </label>
                            <div class="col-md-6">
                                <input type="password"
                                       id="password_confirmation"
                                       class="form-control"
                                       name="password_confirmation"
                                       value=""
                                       />
                            </div>
                            <div class="col-md-3 error">
                                <?php error('password_confirmation'); ?>
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