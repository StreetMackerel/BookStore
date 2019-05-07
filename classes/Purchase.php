<?php
require_once 'classes/Connection.php';

class Purchase{
    public $id;
	public $user_id;
	public $book_id;

    public function __construct() {
    }

    
    public static function all() {
        $sql = 'SELECT * FROM userbook';
        $connection = Connection::getInstance();
        $stmt = $connection->prepare($sql);
        $success = $stmt->execute();
        if (!$success) {
            throw new Exception("Failed to retrieve purchases");
        }
        else {
            $purchases = $stmt->fetchAll(PDO::FETCH_CLASS, 'Purchase');
            return $purchases;
        }
    }

    
}