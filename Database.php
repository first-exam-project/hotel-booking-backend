<?php
class Database
{
    public $db;
    public function __construct()
    {
        $hostName = "localhost";
        $userName = "root";
        $password = "2005"; // Enclose the password in quotes
        $databaseName = "hotel_booking";
        try {
            $this->db = new PDO("mysql:host=$hostName;dbname=$databaseName", $userName, $password);
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Connection failed: " . $e->getMessage());
        }
    }
}