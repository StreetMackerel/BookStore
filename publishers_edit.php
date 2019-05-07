<?php
require_once 'utils/functions.php';
require_once 'classes/Book.php';
require_once 'classes/Publisher.php';
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
            throw new Exception("Invalid book id: " . $errors['id']);
        }

        $id = $validated_data['id'];
        $publisher = Publisher::find($id);

        $publishers = Publisher::all();
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
                          action="publishers_update.php"
                          role="form"
                          class="form-horizontal"
                          enctype="multipart/form-data"
                          >
                        <input type="hidden" name="id" value="<?= $publisher->id ?>" />
                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-3">
                                <h2>Edit publisher form</h2>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="name" class="col-md-3 control-label">Name</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" id="name" name="name" value="<?= old('name', $publisher->name) ?>" />
                            </div>
                            <div class="col-md-3 error">
                                <?php error('name'); ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="author" class="col-md-3 control-label">Address</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" id="address" name="address" value="<?= old('address', $publisher->address) ?>" />
                            </div>
                            <div class="col-md-3 error">
                                <?php error('address'); ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="phone" class="col-md-3 control-label">Phone</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" id="phone" name="phone" value="<?= old('phone', $publisher->phone) ?>" />
                            </div>
                            <div class="col-md-3 error">
                                <?php error('phone'); ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="email" class="col-md-3 control-label">Email</label>
                            <div class="col-md-6">
                                <input type="email" class="form-control" id="email" name="email" value="<?= old('email', $publisher->email) ?>" />
                            </div>
                            <div class="col-md-3 error">
                                <?php error('email'); ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="website" class="col-md-3 control-label">Website</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" id="website" name="website" value="<?= old('website', $publisher->website) ?>" />
                            </div>

                            <div class="col-md-3 error">
                                <?php error('website'); ?>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-3">
                                <a href="publishers_index.php" class="btn btn-default">Cancel</a>
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