<?php
require_once 'classes/Book.php';
require_once 'classes/Publisher.php';
require_once 'classes/Gump.php';
require_once 'classes/User.php';

try {
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
        throw new Exception("Invalid publisher id: " . $errors['id']);
    }

    $id = $validated_data['id'];
    $publisher = Publisher::find($id);
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
                    <h2>Publishers details</h2>
                    <table id="table-publisher" class="table table-hover">
                        <tbody>
                            <tr>
                                <td>Name</td>
                                <td><?= $publisher->name ?></td>
                            </tr>
                            <tr>
                                <td>Author</td>
                                <td><?= $publisher->address ?></td>
                            </tr>
                            <tr>
                                <td>Phone</td>
                                <td><?= $publisher->phone ?></td>
                            </tr>
                            <tr>
                                <td>Email</td>
                                <td><?= $publisher->email ?></td>
                            </tr>
                            <tr>
                                <td>Website</td>
                                <td><?= $publisher->website ?></td>
                            </tr>
                            
                        </tbody>
                    </table>
                    <p>
                        <a href="publishers_index.php" class="btn btn-default">Cancel</a>
                        <a href="publishers_edit.php?id=<?= $publisher->id ?>" class="btn btn-warning">Edit</a>
                        <a href="publishers_delete.php?id=<?= $publisher->id ?>" class="btn btn-danger">Delete</a>
                    </p>
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