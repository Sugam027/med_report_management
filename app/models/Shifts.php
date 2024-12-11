<?php

class Shifts extends Controller{
    private $db;

    public function __construct() {
        $this->db = new Database();
        $this->db = new Sql();
    }

    public function getShift() {
        return $this->db->getData('shifts');  
    }

    // Fetch specific shifts by their titles
    public function getShiftIdsByTitle()
{
    $query = "SELECT title, shift_id FROM shifts";
    $this->db->query($query);  // Prepare the query
    $result = $this->db->resultSet(); // Execute and fetch as an array of objects

    // Map shift titles to their IDs
    $shiftMap = [];
    foreach ($result as $row) {
        // Access object properties using "->"
        $shiftMap[strtolower($row->title)] = $row->shift_id;
    }
    return $shiftMap;
}


}
