<?php

class Database {
    private $host = 'localhost';
    private $user = 'root';
    private $pass = '';
    private $dbname = 'med_report_management';

    private $dbh;
    private $stmt;

    public function __construct() {
        // Connect to MySQL server without a specific database first
        $dsn = 'mysql:host=' . $this->host;
        $options = array(
            PDO::ATTR_PERSISTENT => true,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        );

        // Try to connect to the server
        try {
            $this->dbh = new PDO($dsn, $this->user, $this->pass, $options);
            // Create the database if it doesn't exist
            $this->createDatabase();
            // Reconnect with the specified database
            $this->dbh->exec('USE ' . $this->dbname);
        } catch (PDOException $e) {
            die("Database connection failed: " . $e->getMessage());
        }
    }

    // Function to create the database if it doesn't exist
    private function createDatabase() {
        try {
            $sql = "CREATE DATABASE IF NOT EXISTS " . $this->dbname;
            $this->dbh->exec($sql);
        } catch (PDOException $e) {
            die("Database creation failed: " . $e->getMessage());
        }
    }

    // Prepare statement with query
    public function prepare($sql) {
        $this->stmt = $this->dbh->prepare($sql);
    }

    // Prepare the SQL statement
    public function query($sql) {
        $this->stmt = $this->dbh->prepare($sql);
    }

    // Bind values to the prepared statement
    public function bindValues($values) {
        foreach ($values as $index => $value) {
            $this->stmt->bindValue($index + 1, $value);
        }
    }

    // Bind the values to the prepared statement with types
    public function bind($param, $value, $type = null) {
        if (is_null($type)) {
            switch (true) {
                case is_int($value):
                    $type = PDO::PARAM_INT;
                    break;
                case is_bool($value):
                    $type = PDO::PARAM_BOOL;
                    break;
                case is_null($value):
                    $type = PDO::PARAM_NULL;
                    break;
                default:
                    $type = PDO::PARAM_STR;
            }
        }
        $this->stmt->bindValue($param, $value, $type);
    }

    // Execute the prepared statement
    public function execute() {
        return $this->stmt->execute();
    }

    // Fetch a single record
    public function single() {
        $this->execute();
        return $this->stmt->fetch(PDO::FETCH_OBJ);
    }

    // Fetch all records as an array of associative arrays
    public function fetchAll() {
        $this->execute();
        return $this->stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Fetch all records as an array of objects
    public function resultSet() {
        $this->execute();
        return $this->stmt->fetchAll(PDO::FETCH_OBJ);
    }

    // Get the last inserted ID
    public function lastInsertId() {
        return $this->dbh->lastInsertId();
    }

     // Begin transaction
     public function beginTransaction() {
        return $this->dbh->beginTransaction();
    }

    // Commit the transaction
    public function commit() {
        return $this->dbh->commit();
    }

    // Rollback the transaction
    public function rollBack() {
        return $this->dbh->rollBack();
    }
}
