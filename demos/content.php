<?php
include('../ajax/conection.php');
use MyApp\Connection\database;
$last=$_GET['lastid'];
$db=new database('chatbook');
$data=$db->get_data('*','read_messages',1,'and id between '.$last.' and ~0 limit 10');
// echo '<pre>';
echo json_encode($data);
?>