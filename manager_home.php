<?php
require_once 'utils/functions.php';
require_once 'classes/User.php';
require_once 'classes/Book.php';
require_once 'classes/Report.php';
require_once 'classes/Gump.php';

if (!is_logged_in()) {
    header("Location: login_form.php");
}

$user = $_SESSION['user'];
$books = Book::all();
$reports = Report::get();

if ($user->role_id != 2) {
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
                        <table id="table-reports" class="table table-hover">
                            <thead>
                                <th>Company Funds</th>
                                <th>25% Wholesale Discount Total</th>
                            </thead>
                            <tbody>
                                <?php foreach ($reports as $report) { ?>
                                    <tr data-id="">
                                        <td>€<?= $report->funds ?></td>
                                        <td>€<?= $report->profits ?></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                </div>
            </div>
             <div class="row">
                <div class="col-md-12">
                    
                    <?php if (count($books) == 0) { ?>
                        <p>There are no books</p>
                    <?php } else { ?>
                        <table id="table-books" class="table table-hover">
                            <thead>
                                <th>Title</th>
                                <th>Price</th>
                                <th>Stock</th>
                                <th></th>
                            </thead>
                            <tbody>
                                <?php foreach ($books as $book) { ?>
                                    <tr data-id="<?= $book->id ?>">
                                        <td><a href="books_show.php?id=<?= $book->id ?>" class="btn-link"><?= $book->title ?></a></td>
                                        <td><?= $book->price ?></td>
                                        <td><?= $book->stock ?></td>
                                        <td><a href="manager_restock.php?id=<?= $book->id ?>" class="btn btn-primary pull-right">Restock</a></td>
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
