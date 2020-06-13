<?php
require('./conection.php');
use MyApp\Connection\database;

session_start();
$mpath = $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . '/dashboard/www/new%20www/chatbook';
// if(!$me)
// header("Location:$mpath/server.php");//redirect to content block page
if(isset($_POST['username']) && isset($_SESSION['username'])){
$username=filter_var($_POST['username'],FILTER_VALIDATE_INT);
$me=filter_var($_SESSION['username'],FILTER_VALIDATE_INT);
}
else
{
    $username=false;
    $me=false;
}
if($username && $me){
$data=$_POST;
if($_FILES['image']['name']){
$image=$_FILES['image'];
$ext=explode('.',$image['name']);
$image_name=$username.'_'.time().'.'.$ext[1];
if($image['size'])
{
    if(move_uploaded_file($image['tmp_name'],'../uploads/'.$image_name))
    {
        $data['image_upload_status']='Succes';
        $data['image_src']=$image_name;
    }
    else{
        $data['image_src']='';
        $data['image_upload_status']='failed';
    }

}
else
{
    $data['image_upload_status']='Uncknown File';
    $data['image_src']='';
}

}
else {
    $data['image_src']='';

}
date_default_timezone_set("Asia/Kolkata");
$data['time']=date('Y-m-d H:i:s',time());
// echo $data['time'];
$message=($data['message']);
if(strlen($message)>18)
{
    $message=substr($message,0,18).".....";
}
$db=new database();
$flag=$db->insert_message('unread_messages','from='.$me.',to='.$username.',message='.$message.',image_src='.$data['image_src']);
$avail=$db->get_data('*','current_users','sender='.$me.' and receiver='.$username.' or receiver='.$me.' and sender='.$username);
if($avail)
$db->update_value('current_users','sender='.$me.' and receiver='.$username.' or receiver='.$me.' and sender='.$username,'message='.$message.',time='.$data['time']);
else {
    $db->insert_message('current_users','sender='.$me.',receiver='.$username.',message='.$message.',time='.$data['time']);
}

echo json_encode($data);

}
else {
    session_destroy();
    die('Error 404: not Found');
}

?>