<?php

namespace MyApp\Connection;

class database
{

    private $userName = 'root';
    private $pass = '';
    private $con;
    public function __construct()
    {
        date_default_timezone_set('Asia/Kolkata');

        try {
            $this->con = new \PDO("mysql:host=localhost;dbname=chatbook", $this->userName, $this->pass);
            $this->con->setAttribute(\PDO::ERRMODE_EXCEPTION, \PDO::ATTR_ERRMODE);
        } catch (\PDOException $err) {
            echo 'error: ' . $err;
        }
    }
    public function get_data($attr, $table, $condition, $otherCondition = '')
    {
        // if($condition!=1){
        //     print_r(stripos('',));
        //     echo '<pre>';
        //     $con_lis=explode(' ',$condition);
        //     print_r(explode('=',$con_lis[1]));
        //     // list($k,$v)=explode('=',$condition);
        //     // $condition='`'.$k.'`='.$v;
        // }
        $sql = 'select ' . $attr . ' from ' . $table . ' where ' . $condition . ' ' . $otherCondition;
        // echo $sql; 
        $query = $this->con->query($sql);
        $data = $query->fetchAll(\PDO::FETCH_ASSOC);
        if ($data) {
            return $data;
        } else {
            // print_r($this->con->errorInfo());
        }
    }
    public function insert_message($table, $values = '', $fromAnotherTable = '')
    {
        if ($values) {
            $li = explode(',', $values);
            $key = '';
            $value = '';
            foreach ($li as $j) {
                list($k, $v) = explode('=', $j);
                $key = $key . ',`' . $k . '`';
                $value = $value . ',"' . $v . '"';
            }
            $value = ltrim($value, ',');
            $key = ltrim($key, ',');
            $sql = 'insert into ' . $table . '(' . $key . ') values(' . $value . ')';
        } else {
            $sql = 'insert into ' . $table . '  ' . $fromAnotherTable;
        }
        $query = $this->con->query($sql);
        if (!$query) {
            print_r($this->con->errorInfo());
        }
    }
    public function update_value($table, $condition = '', $value = '', $other = '')
    {
        $lis = explode(',', $value);
        $val = '';
        
        foreach ($lis as $i) {
            list($k, $v) = explode('=', $i);
            $val = $val . '`' . $k . '`="' . $v . '" ,';
        }
        $value = rtrim($val, ',');
        // print_r($value);
        $sql = 'update ' . $table . ' set ' . $value . ' where ' . $condition . ' ' . $other;
        // echo $sql . '<hr>';  
        $query = $this->con->query($sql);
        if (!$query) {
            print_r($this->con->errorInfo());
        }
    }
    public function delete_value($table, $condition)
    {
        $sql = 'DELETE FROM ' . $table . ' WHERE ' . $condition;
        $this->con->query($sql);
    }
    public function direct_sql($q)
    {
        echo $q;
        $que = $this->con->query($q);
        if (!$que) {
            print_r($this->con->errorInfo());
        }
    }
}
