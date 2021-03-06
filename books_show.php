<?php
require_once 'classes/Book.php';
require_once 'classes/Publisher.php';
require_once 'classes/Gump.php';
require_once 'classes/User.php';
require_once 'classes/Purchase.php';

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
        throw new Exception("Invalid book id: " . $errors['id']);
    }

    $id = $validated_data['id'];
    $book = Book::find($id);
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
                    <h2>Book details</h2>
                    <table id="table-book" class="table table-hover">
                        <tbody>
                            <thead>
                                <th><?= $book->title ?></th>
                                <th></th>
                                <th></th>
                                <th></th>
                            </thead>
                            <tr>
                                <td>Author</td>
                                <td><?= $book->author ?></td>
                            </tr>
                            <tr>
                                <td>ISBN</td>
                                <td><?= $book->isbn ?></td>
                            </tr>
                            <tr>
                                <td>Year</td>
                                <td><?= $book->year ?></td>
                            </tr>
                            <tr>
                                <td>Price</td>
                                <td><?= $book->price ?></td>
                            </tr>
                            <tr>
                                <td>Publisher</td>
                                <td><?= Publisher::find($book->publisher_id)->name ?></td>
                            </tr>
                            <tr>
                                <td>Cover image</td>
                                <td><img src="<?= $book->cover ?>" height="100px" /></td>
                            </tr>
                        </tbody>
                    </table>
                    <p>
                        <a href="books_index.php" class="btn btn-default">Cancel</a>
                        
                        <?php if ($user->role_id == 3) { ?>
                            <?php if ($book->stock <= 0) { ?>
                                <a class="btn btn-danger">Out of Stock</a>
                            <?php } else { ?> 
                                <a href="purchases_store.php?id=<?= $book->id ?>" class="btn btn-success">Buy Book</a>
                            <?php } ?> 
                        <?php } else { ?> 
                        <a href="books_edit.php?id=<?= $book->id ?>" class="btn btn-warning">Edit</a>
                        <a href="books_delete.php?id=<?= $book->id ?>" class="btn btn-danger">Delete</a>
                        <?php } ?>
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
