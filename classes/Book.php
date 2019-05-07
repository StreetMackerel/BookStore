<?php
require_once 'classes/Connection.php';

class Book {
    public $id;
    public $title;
    public $author;
    public $isbn;
    public $year;
    public $price;
    public $cover;
    public $publisher_id;
    public $stock;

    public function __construct() {
    }

    public function save() {    

        $params = array(
            'title' => $this->title,
            'author' => $this->author,
            'isbn' => $this->isbn,
            'year' => $this->year,
            'price' => $this->price,
            'cover' => $this->cover,
            'publisher_id' => $this->publisher_id,
        );

        if ($this->id === NULL) {
            $sql = "INSERT INTO books(
                        title, author, isbn, year, price, cover, publisher_id, stock
                    ) VALUES (
                        :title, :author, :isbn, :year, :price, :cover, :publisher_id, 0
                    )";
        }
        else if ($this->id !== NULL) {
            $params["id"] = $this->id;

            $sql = "UPDATE books SET
                        title = :title,
                        author = :author,
                        isbn = :isbn,
                        year = :year,
                        price = :price,
                        cover = :cover,
                        publisher_id = :publisher_id
                        WHERE id = :id";
        }

        $conn = Connection::getInstance();
        $stmt = $conn->prepare($sql);
        $success = $stmt->execute($params);
        if (!$success) {
            throw new Exception("Failed to save book");
        }
        else {
            $rowCount = $stmt->rowCount();
            if ($rowCount !== 1) {
                throw new Exception("Error saving book");
            }
            if ($this->id === NULL) {
                $this->id = $conn->lastInsertId('books');
            }
        }
    }

        public function restock() {
        $params = array(
            'id' => $this->id
        );
            
            $sql = "CALL `calcFunds`(:id);";
            
        $conn = Connection::getInstance();
        $stmt = $conn->prepare($sql);
        $success = $stmt->execute($params);
            
        if (!$success) {
            throw new Exception("Failed to restock book");
        }
        else {
            $rowCount = $stmt->rowCount();
            if ($rowCount !== 1) {
                throw new Exception("Error restocking book");
            }
            if ($this->id === NULL) {
                $this->id = $conn->lastInsertId('books');
            }
        }
    }
    
    public function delete() {
        $params = array(
            'id' => $this->id
        );
        $sql = 'UPDATE books SET
                        active = 0 WHERE id = :id';
        $connection = Connection::getInstance();
        $stmt = $connection->prepare($sql);
        $success = $stmt->execute($params);
        if (!$success) {
            throw new Exception("Failed to delete book");
        }
        else {
            $rowCount = $stmt->rowCount();
            if ($rowCount !== 1) {
                throw new Exception("Error deleting book");
            }
        }
    }

    public static function all() {
        $sql = 'SELECT * FROM books WHERE active = 1';
        $connection = Connection::getInstance();
        $stmt = $connection->prepare($sql);
        $success = $stmt->execute();
        if (!$success) {
            throw new Exception("Failed to retrieve books");
        }
        else {
            $books = $stmt->fetchAll(PDO::FETCH_CLASS, 'Book');
            return $books;
        }
    }
    

    

    public static function find($id) {
        $params = array(
            'id' => $id
        );
        $sql = 'SELECT * FROM books WHERE id = :id';
        $connection = Connection::getInstance();
        $stmt = $connection->prepare($sql);
        $success = $stmt->execute($params);
        if (!$success) {
            throw new Exception("Failed to retrieve book");
        }
        else {
            $book = $stmt->fetchObject('Book');
            return $book;
        }
    }
    
    public static function findByUserId($id) {
        $params = array(
            'id' => $id
        );
        $sql = 'SELECT title, author, cover FROM books
				LEFT JOIN userbook on books.id = userbook.book_id 
				LEFT JOIN users on userbook.user_id = users.id 
                WHERE userbook.user_id = :id';

        $connection = Connection::getInstance();
        $stmt = $connection->prepare($sql);
        $success = $stmt->execute($params);
        if (!$success) {
            throw new Exception("Failed to retrieve purchase");
        }
        else {
            $purchases = $stmt->fetchAll(PDO::FETCH_CLASS, 'Purchase');
            return $purchases;
        }
    }
    
    public static function buyBook($user_id, $book_id) {
        $params = array( 
			'user_id' => $user_id,
			'book_id' => $book_id
        );

            $sql = "INSERT INTO userbook(
                        user_id, book_id, purchase_date
                    ) VALUES (
                        :user_id, :book_id, CURDATE()
                    );
                    
                    UPDATE books SET stock=stock-1 
                    WHERE id = :book_id;
                    
                    UPDATE reports SET funds=funds+ 
                    (SELECT price FROM books
                    WHERE id = :book_id);";
    
        $conn = Connection::getInstance();
        $stmt = $conn->prepare($sql);
        $success = $stmt->execute($params);
        if (!$success) {
            throw new Exception("Failed to save purchase");
        }
        else {
            $rowCount = $stmt->rowCount();
            if ($rowCount !== 1) {
                throw new Exception("Error saving purchase");
            }
            
        }
    }

}
?>
