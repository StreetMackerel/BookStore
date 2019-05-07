<?php
require_once 'classes/Publisher.php';

try {
    $publishers = Publisher::all();
}
catch (Exception $ex) {
    die($ex->getMessage());
}
?><!DOCTYPE html>
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
                    <h2><img src="styles/img/publishers.png">Publishers <a href="publishers_create.php" class="btn btn-primary pull-right">Add</a></h2>
                    <?php if (count($publishers) == 0) { ?>
                        <p>There are no publishers</p>
                    <?php } else { ?>
                        <table id="table-publishers" class="table table-hover">
                            <thead>
                                <th>Name</th>
                                <th>Address</th>
                                <th>Phone</th>
                                <th>Email</th>
                                <th>Website</th>
                            </thead>
                            <tbody>
                                <?php foreach ($publishers as $publisher) { ?>
                                    <tr data-id="<?= $publisher->id ?>">
										<td><a href="publishers_show.php?id=<?= $publisher->id ?>" class="btn-link"><?= $publisher->name ?></a></td>          
                                        <td><?= $publisher->address ?></td>
                                        <td><?= $publisher->phone ?></td>
                                        <td><?= $publisher->email ?></td>
                                        <td><?= $publisher->website ?></td>
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
