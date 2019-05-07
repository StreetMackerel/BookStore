<?php
require_once 'classes/Book.php';
require_once 'classes/Publisher.php';
require_once 'classes/Purchase.php';

try {
    $purchases = Purchase::all();
}
catch (Exception $ex) {
    die($ex->getMessage());
}
?>
<!DOCTYPE html>
<html>
    <head>
        
        <link rel="icon" href="styles/img/book.png">
        <meta charset="UTF-8">
        <title></title>
        <?php require 'utils/styles.php'; ?>
        <?php require 'utils/scripts.php'; ?>
        <link rel="stylesheet" type="text/css" href="styles/styles.css">
        <link href="https://fonts.googleapis.com/css?family=Montserrat|Open+Sans+Condensed:300|Philosopher" rel="stylesheet">
        
        
		<?php require_once 'classes/User.php'; ?>
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
                    <h2><img src="styles/img/purchases.png">Purchases</h2>
                    <?php if (count($purchases) == 0) { ?>
                        <p>There are no purchases</p>
                    <?php } else { ?>
                        <table id="table-purchases" class="table table-hover">
                            <thead class="head">
                                <th>User</th>
                                <th>Title</th>
                                <th>Date Purchased</th>
                            </thead>
                            <tbody>
                                <?php foreach ($purchases as $purchase) { ?>
                                    <tr data-id="<?= $purchase->id ?>">                           
                                        <td><?= User::find($purchase->user_id)->username ?></td>
                                        <td><?= Book::find($purchase->book_id)->title ?></td>
                                        <td><?= $purchase->purchase_date ?></td>
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