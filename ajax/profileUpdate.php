<?php
session_start();
if(isset($_FILES['img']))
{
    if(($_FILES['img']['size'])>0 &&($_FILES['img']['type'])=='image/jpeg')
    {
        
        move_uploaded_file($_FILES['img']['tmp_name'],'../uploads/'.$_SESSION['username'].'.jpg');
        echo './uploads/'.$_SESSION['username'].'.jpg';
    }
    else
    echo "file empty";
}
else 
echo 'null';
// print_r($_FILES);
?>
