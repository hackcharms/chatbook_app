<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href='./loginPage.css' type="text/css">
    <link rel="stylesheet" href='../css/columns.css' type="text/css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>Document</title>
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
                <div class="col-12" style="padding: 5%; color:rgb(236,98,96);font-size:1.5em;text-transform: capitalize;">
                    <?php

                    use MyApp\Connection\database;

                    include('../ajax/conection.php');
                    // if($_POST)

                    if (!empty($_POST)) {
                        // echo "<pre>";
                        // print_r($_POST);
                        // echo "<hr>";
                        foreach ($_POST as $key => $val) {
                            $_POST[$key] = htmlspecialchars(strip_tags($val));
                        }
                        // print_r($_POST);


                        $db = new database();
                        if ($_POST['submit'] == "login") {
                            // echo "<li>login <br>";

                            $username = filter_var($_POST['MobileNumber'], FILTER_VALIDATE_INT);
                            $pass = md5($_POST['password']);
                            if ($username) {
                                $query = $db->get_data("*", "login", "`user_name`= $username  and pass='$pass'");
                                // print_r($query);
                                if (!empty($query)) {
                                    $query = $query[0];
                                    if ($query['verified'] == '1') {
                                        session_start();
                                        $_SESSION['username'] = $query['user_name'];
                                        $mpath = $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . '/dashboard/www/new%20www/chatbook';
                                        header("location:$mpath/messageBox.php");
                                        print_r($_SESSION);
                                    } else {
                                        echo "<li> Your Account not verified Yet check your mail to verify";
                                    }
                                } else {
                                    echo "<li>Mobile No. or Password In not Correct.</li>";
                                }
                            } else {
                                echo "<li>not in Format";
                            }
                        } else if ($_POST['submit'] == "signup") {
                            // echo "<li>SignUP <br>";
                            $name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
                            $mobile = filter_var($_POST['MobileNumber'], FILTER_SANITIZE_NUMBER_INT);
                            $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
                            if (strlen($mobile) == 10) {
                                $avail = $db->get_data('*', 'login', 'user_name=' . $mobile . ' or email_id="' . $email . '"');
                                if (!$avail) {
                                    if ($_POST['password1'] == $_POST['password2']) {
                                        // echo strlen($_POST['password2']);
                                        if (strlen($_POST['password2']) > 5) {
                                            $pass = md5($_POST['password1']);
                                            $db->insert_message('login', "name=$name,email_id=$email,user_name=$mobile,pass=$pass");
                                            if ($db) {
                                                $to = $email;
                                                include('./mail.php');
                                                echo "<li style='color:blue'>Check your Mail and Verify account. <br>Redirecting to Login Page in <span id='secondSpan'></span></li>";
                                                echo "<script>
                                                var i=3;
                                                interval=setInterval(()=>{                               
                                                    if(i==0)
                                                    clearInterval(interval);
                                                    document.querySelector('#secondSpan').innerHTML=i;
                                                    i=i-1;
                                                    },1000)
                                                setTimeout(()=>{
                                                        window.location.replace('./loginPage.php');
                                                      },4*1000)</script>";
                                            }
                                        } else
                                            echo "<li>length should be greater than 5";
                                    } else
                                        echo "<li>Pass Not Matched";
                                } else {
                                    if ($avail[0]['user_name'] == $mobile)
                                        echo "<li>Mobile No already Found";
                                    else if ($avail[0]['email_id'] == $email)
                                        echo "<li>email Already Registered";
                                }
                            } else
                                echo "<li>Mobile Number is not in proper Format";
                        } else if ($_POST['submit'] == "forgetpass") {
                            $userName = filter_var($_POST['mobileNumber'], FILTER_SANITIZE_NUMBER_INT);
                            $data = $db->get_data('*', 'login', "user_name=$userName");
                            if (!empty($data)) {
                                $to = $data[0]['email_id'];
                                include('./mail.php');
                                // echo $subject;
                                echo "<li style='color:black'> your Reset Passs Link has been succefully sent on register email Id <a href='#'>$to</a></li>";
                                echo "<li style='color:blue'>Check your Mail and Verify account .<br>Redirecting to Login Page in <span id='secondSpan'></span></li>";
                            } else {
                                echo "<li>userName not Found Plz Sign Up";
                            }
                        } else {
                            echo "<li>Error";
                        }
                    } else {
                        echo "<li>not Null";
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