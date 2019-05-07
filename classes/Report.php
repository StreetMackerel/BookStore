<?php
require_once 'classes/Connection.php';

class Report{
    public $id;
	public $funds;
	public $profits;

    public function __construct() {
    }

    
    public static function get() {
        $sql = 'SELECT * FROM reports';
        $connection = Connection::getInstance();
        $stmt = $connection->prepare($sql);
        $success = $stmt->execute();
        if (!$success) {
            throw new Exception("Failed to retrieve purchases");
        }
        else {
            $report = $stmt->fetchAll(PDO::FETCH_CLASS, 'Report');
            return $report;
        }
    }

    
}