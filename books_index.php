<?php
require_once 'classes/Book.php';
require_once 'classes/Publisher.php';

try {
    $books = Book::all();
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
            <h2><img src="styles/img/books.png">Books 
                        <?php if ($user->role_id < 3) { ?>
                         <a href="books_create.php" class="btn btn-primary pull-right">Add</a>
                        <?php } ?>
                    </h2>
			<?php if (count($books) == 0) { ?>
                        <p>There are no books</p>
                    <?php } ?>
					<?php foreach ($books as $book) { ?>
			<div class="col-sm-6">		
				<div class="mycard">	 
					
					<div class="mycardcontent">
                        
                        <div class="col-6 cardCover">
                            <img src="<?= $book->cover ?>" height="150px" />
                            <p class="cardElement">Stock: <b><?= $book->stock ?></b></p>
                        </div>
                        
                        <div class="col-6">
						<p class="cardTitle"><a href="books_show.php?id=<?= $book->id ?>" class="btn-link"><?= $book->title ?></a></p>
						<p class="author"><?= $book->author ?></p>
                        </div>
                            
					</div>
					<div class="mycardcontent">
						<p class="cardElement2"><b>Year: </b><?= $book->year ?></p>
						<p class="cardElement2"><b>Price: </b><?= $book->price ?></p>
						<p class="cardElement2"><b>Publisher: </b><?= Publisher::find($book->publisher_id)->name ?></p>		
					</div>	
                    
				</div>			
			</div>
			<?php } ?>
        </div>
            <div><br><br><br></div>
            
            <div class="row">
                <div class="col-md-12">
                    <?php require 'utils/footer.php'; ?>
                </div>
            </div>
        </div>
    </body>
</html>
