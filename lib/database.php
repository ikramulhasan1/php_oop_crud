<?php
include_once './config/config.php';
class Database
{
    public $hostname = HOSTNAME;
    public $username = USERNAME;
    public $password = PASSWORD;
    public $DATABASE = DATABASE;

    public $link;
    public $error;

    public function __construct()
    {
        $this->dbConnect();
    }

    public function dbConnect()
    {
        $this->link = new mysqli($this->hostname, $this->username, $this->password, $this->DATABASE);
        if ($this->link->connect_error) {
            $this->error = "Failed to connect to MySQL: " . $this->link->connect_error;
            return false;
        }
    }

    //Insert
    public function insert($query)
    {
        $result = mysqli_query($this->link, $query) or die($this->link->error . `_LINE_`);
        if ($result) {
            return $result;
        } else {
            return false;
        }
    }

    public function select($query)
    {
        $result = mysqli_query($this->link, $query) or die($this->link->error . `_LINE_`);
        if (mysqli_num_rows($result) > 0) {
            return $result;
        } else {
            return false;
        }
    }

    //update
    public function update($query)
    {
        $result = mysqli_query($this->link, $query) or die($this->link->error . `_LINE_`);
        if ($result) {
            return $result;
        } else {
            return false;
        }
    }
}
