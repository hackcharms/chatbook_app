<?php
require('./conection.php');
require('./modules.php');
use MyApp\Connection\database;
session_start();
$mpath = $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . '/dashboard/www/new%20www/chatbook';
if(isset($_SESSION['username'])&& isset($_GET['username'])){
$username=filter_var($_GET['username'],FILTER_VALIDATE_INT);
$me=filter_var($_SESSION['username'],FILTER_VALIDATE_INT);
}
else
{
    $me=false;
    $username=false;
}
if($username && $me){
$loginDB=new database();
$userInfo=$loginDB->get_data('*','current_users','sender='.$username.' and receiver='.$_SESSION['username'].' or receiver='.$username.' and sender='.$_SESSION['username'])[0];
$newMess=$loginDB->get_data('count(message) count','unread_messages',' `from`='.$username.' and `to`='.$_SESSION['username']);
$name=$loginDB->get_data('name','login','user_name='.$username);
$time=formatTime($userInfo['time']);
$userInfo['mess_time']= $time;
$data=array_merge($userInfo,$newMess[0]);
$data=array_merge($data,$name[0]);
echo(json_encode($data));
}else{
    session_destroy();
    die('Error 404: not Found');
}
?>