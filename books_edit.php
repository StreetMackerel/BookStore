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
        $book = Book::find($id);

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
                          action="books_update.php"
                          role="form"
                          class="form-horizontal"
                          enctype="multipart/form-data"
                          >
                        <input type="hidden" name="id" value="<?= $book->id ?>" />
                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-3">
                                <h2>Edit book form</h2>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="title" class="col-md-3 control-label">Title</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" id="title" name="title" value="<?= old('title', $book->title) ?>" />
                            </div>
                            <div class="col-md-3 error">
                                <?php error('title'); ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="author" class="col-md-3 control-label">Author</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" id="author" name="author" value="<?= old('author', $book->author) ?>" />
                            </div>
                            <div class="col-md-3 error">
                                <?php error('author'); ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="isbn" class="col-md-3 control-label">ISBN</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" id="isbn" name="isbn" value="<?= old('isbn', $book->isbn) ?>" />
                            </div>
                            <div class="col-md-3 error">
                                <?php error('isbn'); ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="year" class="col-md-3 control-label">Year</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" id="year" name="year" value="<?= old('year', $book->year) ?>" />
                            </div>
                            <div class="col-md-3 error">
                                <?php error('year'); ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="price" class="col-md-3 control-label">Price</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" id="price" name="price" value="<?= old('price', $book->price) ?>" />
                            </div>

                            <div class="col-md-3 error">
                                <?php error('price'); ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="publisher" class="col-md-3 control-label">Publisher</label>
                            <div class="col-md-6">
                                <select class="form-control" id="publisher_id" name="publisher_id">
                                    <?php foreach ($publishers as $publisher) { ?>
                                        <option value="<?= $publisher->id ?>"><?= $publisher->name ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="col-md-3 error">
                                <?php error('publisher_id'); ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="cover" class="col-md-3 control-label">Cover image</label>
                            <div class="col-md-6">
                                <img src="<?= $book->cover ?>" height="100px" />
                                <input type="file" class="form-control" id="cover" name="cover" />
                            </div>

                            <div class="col-md-3 error">
                                <?php error('price'); ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-3">
                                <a href="books_index.php" class="btn btn-default">Cancel</a>
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
