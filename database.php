<?php

class Database {
    private $host = 'localhost';
    private $db_name = 'profile_management';
    private $username = 'root';
    private $password = '';
    private $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, // Enable exceptions for errors
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, // Fetch results as associative arrays
    ];
    private $conn; // Database connection object

    // Constructor: Initializes the database connection
    public function __construct() {
        try {
            $this->conn = new PDO(
                "mysql:host=" . $this->host . ";dbname=" . $this->db_name . ";port=3307",
                $this->username,
                $this->password,
                $this->options
            );
        
        } catch (PDOException $e) {
            // Throw an exception with the error message and code
            throw new PDOException($e->getMessage(), (int)$e->getCode());
        }
    }

    // Getter for the database connection
    public function getConnection() {
        return $this->conn;
    }

    // Count rows from a query
    public function countRows($query, $params = []) {
        $stmt = $this->conn->prepare($query);
        $stmt->execute($params);
        return $stmt->rowCount(); // Return the number of affected rows
    }

    // Execute a SELECT query and fetch all results
    public function select($query, $params = []) {
        $stmt = $this->conn->prepare($query);
        $stmt->execute($params);
        return $stmt->fetchAll(); // Fetch all rows as an array
    }

    // Execute an INSERT query and return the last inserted ID
    public function create($query, $params = []) {
        $stmt = $this->conn->prepare($query);
        $stmt->execute($params);
        // Ensure the query is an INSERT and the table supports auto-increment IDs
        return $this->conn->lastInsertId();
    }

    // Execute an UPDATE query and return the number of affected rows
    public function update($query, $params = []) {
        $stmt = $this->conn->prepare($query);
        $stmt->execute($params);
        return $stmt->rowCount(); // Number of rows updated
    }

    // Execute a DELETE query and return the number of affected rows
    public function delete($query, $params = []) {
        $stmt = $this->conn->prepare($query);
        $stmt->execute($params);
        return $stmt->rowCount(); // Number of rows deleted
    }
}
?>
