<?php
// $to=$_GET['email'];
// $to = "zaa78692@gmail.com";
$subject = "Verify Your Account";
$message='<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- <link rel="stylesheet" href="http://ansariwap.000webhostapp.com/chatbook/Chatbook/css/columns.css" type="text/css">-->
    <!-- <link rel="stylesheet" href="http://ansariwap.000webhostapp.com/chatbook/Chatbook/loginpage/css.css" type="text/css">-->
    <link rel="stylesheet" href="../css/columns.css" type="text/css">
    <link rel="stylesheet" href="./loginPage.css" type="text/css">
    <title>Verify</title>
</head>

<body>
    <div class="outer col-12">
        <main class="col-12">
            <header class="col-12">
                <h1>Chatbook</h1>
            </header>
            <div class="leftDiv col-3">

            </div>


            <div class="centerDiv col-6" style="padding: 2px 5%;">
                <div class="col-12" style="padding: 5%; color:rgb(236,98,96);text-transform: capitalize;">
                <p>dear user you have successfully register please click on the link to verify your accounts.</p>
                <a class="col-6" id="clickVerify"href="http://localhost/dashboard/www/new%20www/chatbook/loginpage/verify.php?email='.$to.'" > Click to verify</a>
                </div>
            </div>
            <div class="rightDiv col-3 ">

            </div>
        </main>
    </div>
</body>

</html>';
// Always set content-type when sending HTML email
$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

// More headers
$headers .= 'From: <chatbook@verify.com>' . "\r\n";
// $headers .= 'Cc: myboss@example.com' . "\r\n";

// mail($to,$subject,$message,$headers);
echo "to:$to<br> send Success ";
// echo $message;
?>
