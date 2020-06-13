<?php
// echo '<pre>';
use MyApp\Connection\database;

include('../ajax/conection.php');
// echo $_SERVER['PHP_SELF'];
// print_r($_POST);
$errorFlag=0;
$errorLogs=[];
if (isset($_GET['email'])) {
    $email = $_GET['email'];
}
if (!empty($_POST)) {
    $email = $_POST['email'];
    $number = $_POST['MobileNumber'];
    $db = new database;
    $data = $db->get_data('*', 'login', "email_id='$email'");
    // print_r($data);
    // print_r(count($data));
    if(!empty($data)){
    if(count($data[0])<2){
        if($data[0]['user_name']==$number){
            if($data[0]['verified']!=1){
        $user_mail=$data[0]['email_id'];
        $db->update_value('login',"email_id='$user_mail'","verified=1");
    }
        else{
                
                    array_push($errorLogs,'<p class= "col-8">Account Aleady Verified</p> <a class="col-4" id="clickVerify" href="http://localhost/dashboard/www/new%20www/chatbook/loginpage/loginPage.php" > Login</a>');
$errorFlag=1;

        }
    }else {
        $errorFlag=1;
        array_push($errorLogs,'Number not Matched with registerd mail id .');
    }
    
}
else 
{
    $errorFlag=1;
array_push($errorLogs, "multiple id are Registered with mail ID");

}
}else
{
$errorFlag=1;
array_push($errorLogs, "You are not Registered with Us");
}
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- <link rel="stylesheet" href="http://ansariwap.000webhostapp.com/chatbook/Chatbook/css/columns.css" type="text/css">-->
    <!-- <link rel="stylesheet" href="http://ansariwap.000webhostapp.com/chatbook/Chatbook/loginpage/css.css" type="text/css">-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="../css/columns.css" type="text/css">
    <link rel="stylesheet" href="./loginpage.css" type="text/css">
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
            <div class='centerDiv col-6' style='padding: 2px 5%;'>
                <div class='col-12' style='padding: 5%; color:rgb(236,98,96);text-transform: capitalize;'>

                    <?php
                    if (!isset($_GET['email']))
                        $_GET['email'] = '';

                    $form = "<form action='" . $_SERVER['PHP_SELF'] . "' method='POST'>
                <label for='mobileNumber'>Input MobileNumber</label>
                <input required type='number' min='5000000000' max='9999999999' name='MobileNumber' id='MobileNumber' title='Please Enter 10 digit mobile Number'>
                <input type='email' value='" . $_GET['email'] . "' name='email' style='display: none;'>
                <button type='submit' value='Verify'> Verify</button>
                </form>";
                    if (empty($_POST)) {
                        echo $form;
                    } else {
                        if(!$errorFlag){
                        $succesMess= "<h2 style='color:green'>You succesfully Verified you Account. <i class='fa fa-check-circle'style='font-size: 2em;color:green'></i></h2>
                        <h3 style='color:green'>Redirecting to login Page in <span id='secondspan'>4</span> sec.</h3>
                        <script>
                        var i=3;
                        interval=setInterval(()=>{                               
                            if(i==0)
                            clearInterval(interval);
                            document.querySelector('#secondspan').innerHTML=i;
                            i=i-1;
                            },1000)
                        setTimeout(()=>{
                            window.location.replace('./loginPage.php');
                        },300000)
                            </script>";
                            echo $succesMess;
                    }
                    else{
                        // echo "Unknown Credentials";
                        foreach($errorLogs as $key)
                         {
                             echo $key;
                            }
                    }
                // echo "<a href='#'> click</a>";
                    }
                    ?>
                </div>
            </div>
            <div class="rightDiv col-3 ">

            </div>
        </main>
    </div>
</body>

</html>