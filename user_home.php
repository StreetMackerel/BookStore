<?php
require_once 'utils/functions.php';
require_once 'classes/User.php';
require_once 'classes/Book.php';
require_once 'classes/Purchase.php';
require_once 'classes/Publisher.php';

if (!is_logged_in()) {
    header("Location: login_form.php");
}

$user = $_SESSION['user'];
$books = Book::findByUserId($user->id);

if ($user->role_id != 3) {
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
                    echo '<h2>'.$user->username.'s Books</h2>';
                    ?>
                    <?php if (count($books) == 0) { ?>
                        <p>You don't have any books yet! Head to the store.</p>
                    <?php } else { ?>
                        <table id="table-purchases" class="table table-hover">
                        <thead>
                            <th>Title</th>
                            <th>Author</th>
                            </thead>
                        <tbody>
                                <?php foreach ($books as $book) { ?>
                                    <tr data-id="<?= $book->id ?>">
                                        <td><?= $book->title ?></td>
                                        <td><?= $book->author ?></td>
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
