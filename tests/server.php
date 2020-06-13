<?php
class database
{
    private $host = 'localhost';
    private $root = 'root';
    private $pass_db = '';
    public $table;
    public $sql;
    public $db_name;
    function __construct($db_name)
    {
        $this->db_name = $db_name;
        // $this->con = $con;
    }
    function connect()
    {
        $con = mysqli_connect($this->host, $this->root, $this->pass_db, $this->db_name);
        if (!$con) die("Cannot Connected to database");

        return $con;
    }
    function sql($sql)
    {
        // $query = mysqli_query($this->connect(), $sql);
        // echo $sql;
        $query = mysqli_query($this->connect(), $sql);
        if (!$query)
            die("query unpropper" . mysqli_error($this->connect()));
        // print_r($query);
        return $query;
    }
    function execute($query)
    {
        while ($data = mysqli_fetch_assoc($query)) {
            print_r($data);
        }
    }
}
