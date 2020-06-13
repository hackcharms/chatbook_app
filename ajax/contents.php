<?php
namespace MyApp\contents;
require('./conection.php');
use MyApp\Connection\database;
session_start();
$mpath = $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . '/dashboard/www/new%20www/chatbook';
// if(!$_SESSION['username'])
// header("Location:$mpath/server.php");//redirect to content block page
if($_GET['username'] && isset($_SESSION['username'])){
$user=filter_var($_GET['username'],FILTER_VALIDATE_INT);
$pInfo=filter_var($_GET['pInfo'],FILTER_VALIDATE_BOOLEAN);
$lastMessId=filter_var($_GET['messId'],FILTER_VALIDATE_INT);
$me = filter_var($_SESSION['username'],FILTER_VALIDATE_INT);
}
else
{
    $user=false;
    $me=false;
}
if($user && $me){
$login_db = new database();
if($pInfo){
$data = $login_db->get_data('*', 'login', 'user_name=' . $user);
$lastMessId='~0';
}
else 
{
    $data=null;
}
$unread_mess = $login_db->get_data('*', 'unread_messages', '(`to`=' . $user . ' and `from`=' . $me . ' or `to`=' . $me . ' and `from`=' . $user,") and id < $lastMessId order by id DESC");
$img = '';
$mess = [];

if ($unread_mess) {
    foreach ($unread_mess as $un_mess) {
        $un_mess['time']= date('M d, Y h:m:s',strtotime($un_mess['time']));

        if ($un_mess['image_src'] != '') {
            $img = $img . '"' . $un_mess['image_src'] . '",';
        }
        $m = [];
        foreach ($un_mess as $key => $value) {
            if ($key != 'from')
                $m[$key] = $value;
        }
        array_push($mess, $m);
        if ($un_mess['to'] == $_SESSION['username']) {
            $login_db->insert_message('read_messages', '', 'select null,`from`, `to`, `message`, `image_src`, `time`, `status`, `deleted` from unread_messages where id=' . $un_mess['id']);
            $login_db->delete_value('unread_messages', 'id=' . $un_mess['id']);
        }
    }
    $img = rtrim($img, ',');
}
$unread_mess_size=!empty($unread_mess)?count($unread_mess):0;
if($unread_mess_size<30){
$read_mess = $login_db->get_data('*', 'read_messages', '(`to`=' . $user . ' and `from`=' . $me . ' or `to`=' . $me . ' and `from`=' . $user.' ) AND id<'.$lastMessId," Order by id DESC  limit ".(10-$unread_mess_size));
if ($read_mess) {
    foreach ($read_mess as $files) {
        $files['time']= date('M d, Y h:m:s',strtotime($files['time']));
        if ($files['image_src'] != '') {
            $img = $img . '"' . $files['image_src'] . '",';
        }
        $m = [];
        foreach ($files as $key => $value) {
            if ($key != 'from')
                $m[$key] = $value;
        }
        array_push($mess, $m);
    }
    $img = rtrim($img, ',');
}}

if ($data) {
    $con_json = '{
        "name":"' . $data[0]['name'] . '",
        "lastSeen":"10:05 am",
        "imgSrc":"' . $data[0]['dp_src'] . '",
        "read_mess":[' . $img . '],
        "details":{
            "Date of Birth":"' . $data[0]['dob'] . '",
            "Email":"' . $data[0]['email_id'] . '",
            "Mobile No.":' . $user . ',
            "Hobby":"Unknown",
            "Age":22,
            "Height":"16.5\'"
        },
        "message":' . json_encode($mess) . '
    }';
} else {
    $con_json = json_encode($mess);
}
// echo '<pre>';
echo $con_json;
// print_r($read_mess);
// echo '<hr>';
// print_r($unread_mess);
}
else{
    session_destroy();
    die('Error 404: not Found');
}
