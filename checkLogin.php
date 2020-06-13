<?php
session_start();
$mpath=$_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'].'/dashboard/www/new%20www/chatbook';
if(isset($_GET['logout']))
   { 
       $logout=filter_var($_GET['logout'],FILTER_VALIDATE_BOOLEAN);
    if($logout){
        session_destroy();
        header("location:$mpath/loginPage/loginPage.php?suc=LogOut Success");
    }
        else {
            exit();
        }
    }
else
{
$username=filter_var($_SESSION['username'],FILTER_VALIDATE_INT);
if($username){
    header("Location:$mpath/messageBox.php");
}
else{
    header("Location:$mpath/loginPage/loginPage.php");
}
}
