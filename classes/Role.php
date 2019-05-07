<?php
require_once 'classes/Connection.php';

class Role{
    public $id;
    public $title;
    public $description;

    public function __construct() {
    }

    public function save() {
        $params = array(
            'title' => $this->title,
            'description' => $this->description
        );

        if ($this->id === NULL) {
            $sql = "INSERT INTO roles(
                        title, description
                    ) VALUES (
                        :title, :description
                    )";
        }
        else if ($this->id !== NULL) {
            $params["id"] = $this->id;

            $sql = "UPDATE roles SET
                        title = :title,
                        description = :description
                    WHERE id = :id";
        }

        $conn = Connection::getInstance();
        $stmt = $conn->prepare($sql);
        $success = $stmt->execute($params);
        if (!$success) {
            throw new Exception("Failed to save role");
        }
        else {
            $rowCount = $stmt->rowCount();
            if ($rowCount !== 1) {
                throw new Exception("Error saving role");
            }
            if ($this->id === NULL) {
                $this->id = $conn->lastInsertId('roles');
            }
        }
    }

    public function delete() {
        if (empty($this->id)) {
            throw new Exception("Unsaved role cannot be deleted");
        }
        $params = array(
            'id' => $this->id
        );
        $sql = 'DELETE FROM roles WHERE id = :id';
        $connection = Connection::getInstance();
        $stmt = $connection->prepare($sql);
        $success = $stmt->execute($params);
        if (!$success) {
            throw new Exception("Failed to delete role");
        }
        else {
            $rowCount = $stmt->rowCount();
            if ($rowCount !== 1) {
                throw new Exception("Error deleting role");
            }
        }
    }

    public static function all() {
        $sql = 'SELECT * FROM roles';
        $connection = Connection::getInstance();
        $stmt = $connection->prepare($sql);
        $success = $stmt->execute();
        if (!$success) {
            throw new Exception("Failed to retrieve roles");
        }
        else {
            $roles = $stmt->fetchAll(PDO::FETCH_CLASS, 'Role');
            return $roles;
        }
    }

    public static function find($id) {
        $params = array(
            'id' => $id
        );
        $sql = 'SELECT * FROM roles WHERE id = :id';
        $connection = Connection::getInstance();
        $stmt = $connection->prepare($sql);
        $success = $stmt->execute($params);
        if (!$success) {
            throw new Exception("Failed to retrieve roles");
        }
        else {
            $role = $stmt->fetchObject('Role');
            return $role;
        }
    }
    
    public static function findByTitle($title) {
        $params = array(
            'title' => $title
        );
        $sql = 'SELECT * FROM roles WHERE title = :title';
        $connection = Connection::getInstance();
        $stmt = $connection->prepare($sql);
        $success = $stmt->execute($params);
        if (!$success) {
            throw new Exception("Failed to retrieve titles");
        }
        else {
            $role = $stmt->fetchObject('Role');
            return $role;
        }
    }
}
?>
