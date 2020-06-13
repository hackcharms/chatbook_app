
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href='../css/columns.css' type="text/css">
    <link rel="stylesheet" href='./loginPage.css' type="text/css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="../jquery/jquery-3.4.1.min.js"></script>

    <title>login</title>
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
                    <?php if (!empty($_GET)) {
                        foreach ($_GET as $key => $val) {
                            if (substr($key, 0, 3) == "suc")
                                echo "<li style='color:green;'>$val .</li> ";
                            else
                                echo "<li>$val .</li> ";
                        }
                    } ?>
                </div>
                <div class="formBtn col-12" style="padding: 1px 20%;">
                    <Button class="col-6 login" disabled> login</Button>
                    <Button class="col-6 signup"> SignUp</Button>
                </div>
                <form action="./login.php" method="post" id="login">
                    <label for="MobileNumber"> MobileNumber</label>
                    <input required type="number" name="MobileNumber" id="MobileNumber" required>
                    <label for="password">Password</label>
                    <input required type="password" name="password" id="password"><span onclick="showPass(this,this.previousElementSibling)" id="toggle-password" class="fa fa-fw fa-eye"></span> forgot <a class="forgotPass" href="#"> Password</a>
                    <input required type="text" name="submit" value="login" style="display: none;">
                    <button>Login</button>
                </form>
                <form action="./login.php" method="post" id="signup">
                    <label for="name">Name</label>
                    <input required type="text" name="name" id="name">
                    <label for="MobileNumber"> MobileNumber</label>
                    <input required type="number" min="5000000000" max="9999999999" name="MobileNumber" id="MobileNumber" title="Please Enter 10 digit mobile Number">
                    <label for="email">Email Id</label>
                    <input required type="email" name="email" id="">
                    <label for="password">Password</label>
                    <input required type="password" name="password1" id="password"><span id="toggle-password" onclick="showPass(this,this.previousElementSibling)" class="fa fa-fw fa-eye"></span>
                    <label for="password">Re-Type Password</label>
                    <input required type="password" name="password2" id=""><span id="toggle-password" onclick="showPass(this,this.previousElementSibling)" class="fa fa-fw fa-eye"></span>
                    <input required type="text" name="submit" value="signup" style="display: none;">
                    <button id="signupForm">SignUp</button>
                </form>
                <form action="./login.php" method="post" id="forgetPass">
                    <label for="mobileNumber"> MobileNumber</label>
                    <input required type="number" name="mobileNumber" id="">
                    <input required type="text" name="submit" value="forgetpass" style="display: none;">

                    <button>Send Mail</button>

                </form>

            </div>


            <div class="rightDiv col-3 ">

            </div>
        </main>
    </div>

</body>
<script>
    var password1 = document.querySelector('form#signup input[name=password1]');
    var password2 = document.querySelector('form#signup input[name=password2]');
    // var signupEmail=document.querySelector('form#signup input[name=email]');
    var signupForm = document.getElementById('signup');
    signupForm.addEventListener("submit", function(event) {
        if (!(password1.value == password2.value)) {
            alert('Password Not Matched');
            event.preventDefault();
        }
    })
    var signupBtn = document.querySelector('Button.signup');
    var loginBtn = document.querySelector('Button.login');
    var signupForm = document.querySelector('form#signup');
    var loginForm = document.querySelector('form#login');
    var forgotPass = document.querySelector('form#login a.forgotPass');
    var forgotForm = document.querySelector('form#forgetPass');
    signupBtn.addEventListener('click', () => {
        loginBtn.disabled = false;
        signupBtn.disabled = true;
        loginForm.style.display = 'none';
        forgotForm.style.display = 'none';
        signupForm.style.display = 'block';
    });
    loginBtn.addEventListener('click', () => {
        loginBtn.disabled = true;
        signupBtn.disabled = false;
        signupForm.style.display = 'none';
        forgotForm.style.display = 'none';
        loginForm.style.display = 'block';

    });
    forgotPass.addEventListener('click', () => {
        loginBtn.disabled = false;
        signupBtn.disabled = false;
        signupForm.style.display = 'none';
        forgotForm.style.display = 'block';
        loginForm.style.display = 'none';
    });

    function showPass(eyeIcon, pass) {
        // console.log('clicked');
        // console.log(eyeIcon, pass);
        if (eyeIcon.className == "fa fa-fw fa-eye") {
            pass.setAttribute('type', 'text');
            eyeIcon.classList.add('fa-eye-slash')

        } else if (eyeIcon.className == "fa fa-fw fa-eye fa-eye-slash") {
            pass.setAttribute('type', 'password');
            eyeIcon.classList.remove('fa-eye-slash')
        }
    }
</script>

</html>