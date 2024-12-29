<?php

class Sql extends Database
{
    public function __construct()
    {
        parent::__construct();
    }
    
    // Insert data into a table
    public function insertData($table, $data){
        try {
            $keys = implode(', ', array_keys($data));
            $placeholders = implode(', ', array_fill(0, count($data), '?'));

            $sql = "INSERT INTO $table ($keys) VALUES ($placeholders)";
            $this->query($sql);
            $this->bindValues(array_values($data));

            // Log the SQL and parameters for debugging
            error_log("Executing SQL: $sql with values: " . json_encode(array_values($data)));

            if ($this->execute()) {
                return $this->lastInsertId();
            } else {
                error_log("SQL execution failed: $sql with values: " . json_encode(array_values($data)));
                return false;
            }
        } catch (Exception $e) {
            // Log the exception
            error_log("Error in insertData: " . $e->getMessage());
            return false;
        }
    }


    // Get data from a table
    public function getData($table, $conditions = [], $fields = '*', $joins = [], $groupBy = '', $orderBy = '', $limit = '')
    {
        $sql = "SELECT $fields FROM $table";

        // Add JOINs to the query
        if (!empty($joins)) {
            foreach ($joins as $key => $value) {
                $sql .= " JOIN $key ON $value";
            }
        }

        // Add conditions if provided
        if (!empty($conditions)) {
            $conditionString = implode(' AND ', array_map(function($key) {
                return "$key = ?";
            }, array_keys($conditions)));

            $sql .= " WHERE $conditionString";
        }

        // Add GROUP BY clause if provided
        if (!empty($groupBy)) {
            $sql .= " GROUP BY $groupBy";
        }

        // Add ORDER BY clause if provided
        if (!empty($orderBy)) {
            $sql .= " ORDER BY $orderBy";
        }

        // Add LIMIT clause if provided
        if (!empty($limit)) {
            $sql .= " LIMIT $limit";
        }

        // Print the final SQL query for debugging
        
        // echo "<pre>";
        // echo "SQL Query: " . $sql . "\n";
        // print_r($conditions);
        // echo "</pre>";

        $this->query($sql);
        if (!empty($conditions)) {
            $this->bindValues(array_values($conditions));
        }

        return $this->fetchAll();
    }

    // Update data in a table
    public function updateData($table, $data, $conditions)
    {
        $setString = implode(', ', array_map(function($key) {
            return "$key = ?";
        }, array_keys($data)));

        $conditionString = implode(' AND ', array_map(function($key) {
            return "$key = ?";
        }, array_keys($conditions)));

        $sql = "UPDATE $table SET $setString WHERE $conditionString";
        $this->query($sql);
        $this->bindValues(array_merge(array_values($data), array_values($conditions)));

        return $this->execute();
    }

    // Delete data from a table (permanent delete)
    public function deleteData($table, $conditions)
    {
        $conditionString = implode(' AND ', array_map(function($key) {
            return "$key = ?";
        }, array_keys($conditions)));

        $sql = "DELETE FROM $table WHERE $conditionString";
        $this->query($sql);
        $this->bindValues(array_values($conditions));

        return $this->execute();
    }
    
    // Get single data
    public function getSingleData($table, $conditions = [], $columns = '*', $join = [])
    {
        $sql = "SELECT $columns FROM $table";

        if (!empty($join)) {
            foreach ($join as $key => $value) {
                $sql .= " LEFT JOIN $key ON $value";
            }
        }

        if (!empty($conditions))
            $sql .= " WHERE " . implode(' AND ', array_map(fn($key) => "$key = ?", array_keys($conditions)));

        $this->query($sql);
        $this->bindValues(array_values($conditions));

        return $this->single();
    }

    // Deactivate (soft delete) data
    public function deactivateData($table, $conditions)
    {
        $conditionString = implode(' AND ', array_map(function($key) {
            return "$key = ?";
        }, array_keys($conditions)));

        $sql = "UPDATE $table SET is_active = 0 WHERE $conditionString";
        $this->query($sql);
        $this->bindValues(array_values($conditions));

        return $this->execute();
    }

    // Restore data
    public function restoreData($table, $conditions)
    {
        $conditionString = implode(' AND ', array_map(function($key) {
            return "$key = ?";
        }, array_keys($conditions)));

        $sql = "UPDATE $table SET is_active = 1 WHERE $conditionString";
        $this->query($sql);
        $this->bindValues(array_values($conditions));

        return $this->execute();
    }

    // Get only active data
    public function getActiveData($table, $conditions = [], $fields = '*')
    {
        $sql = "SELECT $fields FROM $table WHERE is_active = 1";

        if (!empty($conditions)) {
            $conditionString = implode(' AND ', array_map(function($key) {
                return "$key = ?";
            }, array_keys($conditions)));

            $sql .= " AND $conditionString";
        }

        $this->query($sql);
        if (!empty($conditions)) {
            $this->bindValues(array_values($conditions));
        }

        return $this->fetchAll();
    }
}
