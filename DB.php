<?php
class DB {
    private $host = "localhost";
    private $user = "root";
    private $pass = "";
    private $dbname = "queryall";
    public $conn;

    public function __construct() {
        $this->conn = new mysqli($this->host, $this->user, $this->pass, $this->dbname);
        if ($this->conn->connect_error) {
            die("DB Connection Failed: " . $this->conn->connect_error);
        }
    }
}
?>
