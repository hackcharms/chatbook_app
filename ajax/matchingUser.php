<?php
require('./conection.php');
use MyApp\Connection\database;
session_start();
$mpath = $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . '/dashboard/www/new%20www/chatbook';
// if(!$_SESSION['username'])
// header("Location:$mpath/server.php");//redirect to content block page
if(isset($_SESSION['username']) && isset($_GET['user'])){
$user=filter_var($_GET['user'],FILTER_VALIDATE_INT);
$me = filter_var($_SESSION['username'], FILTER_VALIDATE_INT);
}
else
{
    $user=false;
    $me=false;
}
if($user && $me){
$db=new database();
if($user!=$me){
$result=$db->get_data('*','login','user_name='.$user);
if(!empty($result))
$result=$result[0];
}
else
$result=[];
echo(json_encode($result));
}
else{
    session_destroy();
    die('Error 404: not Found');
}


?>