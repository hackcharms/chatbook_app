<?php
session_start();
$mpath = $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . '/dashboard/www/new%20www/chatbook';
// print_r($_SESSION);
if (!isset($_SESSION['username']) || $_SESSION['username'] == '')
    header('location:' . $mpath . '/checkLogin.php');

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href='css/layout.css' type="text/css">
    <link rel="stylesheet" href='css/columns.css' type="text/css">
    <link rel="stylesheet" href='css/chatbook.css' type="text/css">
    <link rel="stylesheet" href='css/image_show.css' type="text/css">
    <link rel="stylesheet" href='css/messageDiv.css' type="text/css">
    <link rel="stylesheet" href='css/messageBox.css' type="text/css">
    <link rel="stylesheet" href='css/device.css' type="text/css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="./jquery/jquery-3.4.1.min.js"></script>
    <script src="./js/notify.js"></script>
    <script src="./js/deviceHandler.js"></script>
    <script>
        window.addEventListener('resize', deviceHandler);
        if (window.screen.width < 900) {
            flag = '<900'
        } else {
            flag = '>900'
        };
        var username = '<?php echo $_SESSION["username"]; ?>';
        var conn = new WebSocket('ws://localhost:8080?username=' + username);
        conn.onopen = function(e) {
            console.log("Connection established!");
        };
        conn.onmessage = function(e) {
            var json = JSON.parse(e.data);
            // console.log(json);
            fetch('./ajax/updateNewmess.php?username=' + json.from)
                .then(res => {
                    return res.json();
                })
                .then(data => {
                    // console.log(data);
                    $.notify('Message:\n' + data.name + ":" + data.message, "message");
                    let src = './sounds/eventually.ogg ';
                    let audio = new Audio(src);
                    audio.volume = .2;
                    audio.play();
                    // console.log(json.from + '_detail');

                    var userContDiv = document.getElementById(json.from + '_detail');
                    if(userContDiv){
                    var activeUserId = document.getElementById('user_id');
                    userContDiv.children[1].innerHTML = data.mess_time;
                    userContDiv.children[2].innerHTML = data.last_mess;

                    if (activeUserId == json.from) {
                        if (activeUserId == json.from) {
                            div = document.getElementById('message_inner');
                            // console.log(messages['to']);
                            var li = create_el('li', '');
                            var p = document.createElement('p');
                            var node = document.createTextNode(json.msg);
                            p.appendChild(node);
                            if (json.img != '') {

                                // console.log('inside Image==>' + json.img);
                                img = create_el('img', 'src=./uploads/' + json.img + ',onclick=display_image(this.src)');
                                li.appendChild(img);
                            }
                            li.appendChild(p);
                            time_stamp = create_el('p', 'class=time_stamp');
                            time_node = document.createTextNode(data.mess_time)
                            time_stamp.appendChild(time_node);
                            li.appendChild(time_stamp);
                            // console.log(li);
                            div.appendChild(li);

                        }
                    }}
                    loadContacts();

                })
        }
        conn.onclose = function(e) {
            // fetch('./ajax/connectionUpdate.php');
        }
    </script>
    <script src="./js/modules.js"></script>
    <script src="./js/contactImage.js"></script>
    <script src="./js/messagDiv.js"></script>
    <script src="./js/inputBox.js"></script>
    <script src="./js/home.min.js"></script>
    <script src="./js/sendMessage.js"></script>
    <script src="./js/searchContact.js"></script>
    <!-- <script src="./js/websocket.js"></script> -->
    <!-- <script type="text/javascript" src="https://cdn.rawgit.com/asvd/dragscroll/master/dragscroll.js"></script> -->
    <link href="https://fonts.googleapis.com/css?family=Big+Shoulders+Display|Caveat|Nanum+Gothic|Pontano+Sans|Satisfy|Yanone+Kaffeesatz&display=swap" rel="stylesheet">
    <title>Document</title>

</head>

<body>
    <div class="bodyDiv col-12">
        <!-- <?php echo 'session->' . $_SESSION['username']; ?><br> -->
        <!-- REMOVE PADDING FOR ADDING OUTER BORDER  -->
        <div class="main_div">
            <!-- <<<<<<<<<<<<<<<<<<<<=================== PopUp image_show end here ================>>>>>>>>>>>>>> -->

            <div class="contact_details_popup col-12" onmouseover="hideDiv(this,this.children[0])" id="contact_details_popup">
                <div class="container col-12">
                    <div class="col-12 name_header"> </div>
                    <div class="image_block col-12">
                        <div class="col-3">.</div>
                        <div class="image_block_circle col-6">
                            <img src="./image/7800887621.JPG" alt="image">
                        </div>
                        <div class="col-3"></div>
                    </div>
                    <div class="media_block col-12">
                        Photo,Video,link
                        <div class=" media_block_contents dragscroll col-12" id="media_block_contents">
                            <!-- <div id="scrollB" onclick="console.log(this.parentElement.scrollLeft+=350)">More</div> -->
                        </div>
                    </div>
                    <div class="details_block col-12">
                        <table id="infoTable" class="col-12">
                            <!-- <tr><td>Name</td><td>Zubair Ahmad</td></tr>
                        <tr><td>Date Of Birth</td><td>02/05/2001 </td></tr>
                        <tr><td>Mobile Number</td><td>7800887621</td></tr>
                        <tr><td>Name</td><td>Zubair Ahmad</td></tr>
                        <tr><td>Date Of Birth</td><td>02/05/2001 </td></tr>
                        <tr><td>Mobile Number</td><td>7800887621</td></tr>
                        <tr><td>Name</td><td>Zubair Ahmad</td></tr>
                        <tr><td>Date Of Birth</td><td>02/05/2001 </td></tr>
                        <tr><td>Mobile Number</td><td>7800887621</td></tr> -->
                        </table>
                    </div>
                </div>
            </div>
            <div id="image_show">
                <div id="image" class="image">
                    <img src="" onerror="onError(this)" alt="image" />
                    <!-- <img src="foo.jpg" onerror="if (this.src != 'error.jpg') this.src = 'error.jpg';"> -->
                    <span class="imageHide" title="Hide Picture">x</span>
                </div>
            </div>
            <!-- <<<<<<<<<<<<<<<<<<<<=================== PopUp End here ================>>>>>>>>>>>>>> -->
            <div class="chatbook_header">
                <div style="position: relative;" >
                    <img onerror="onError(this)"onclick="display_image(this.src)" src="./uploads/7800887621.jpg" style="cursor:pointer;" alt="icon" srcset="">
                    <a href="#" onclick="updateProfile(this)" style="bottom: -5px;right: 0;"><label for="profileImg" class="" style=""> Change</label></a>
                    <input type="file" name="profile" style="display: none" id="profileImg" accept="image/jpeg">
                    
            </div>
                <div>
                    <h3></h3>
                </div>
                <div style="position:absolute;right: 2%;bottom:2%">
                <a class="col-6" href="./checkLogin.php?logout=true" >LogOut <i class="fa fa-lock" style="color: white"></i></a>
                    <h1>Chatbook</h1>
                </div>
            </div>
            <!-- <header> ANsari Zubair hjghf</header> -->
            <!-- <<<<<<<<<<<<<<<<<<<<=================== PopUp start here ================>>>>>>>>>>>>>> -->
            <!-- <<<<<<<========= Preview input_container start here   =========>>>>>>>>> -->
            <!-- <div class="col-11_5 input_preview_outer" id="input_preview_outer" onclick="hideDiv(this,this.children[0])">
            <div class="col-5" style="height: 1%;"></div>
            <div class="image_preview_border">
                <div class="title">
                    image.jpg
                </div>
                <div class="input_preview_inner" id="input_preview_inner">
                    <img src="./image/IMG2.jpg" alt="Image" id="image_preview_tag">
                </div>
                <div class="imageMessage" style="padding: 2%;">
                    <div class="col-12 chat-box-tray-outer" id='chat-box-tray-outer'>
                        <div class="chat-box-tray col-12">
                            <i class="fa fa-smile-o" onclick="insertAtCursor(this.nextElementSibling,'&#128647')"></i>
                            <input type="text" placeholder="Type your message here...">
                            <textarea name="" id="inputTextArea" cols="30" rows="1" placeholder="Type your message here..." onfocus="detectKeyUp(this)"></textarea>
                            <i class="fa fa-send-o" style="padding: 8px 7px;"></i>
                            <i class="material-icons">send</i>
                        </div>
                    </div>
                </div>
            </div>
        </div> -->
            <!-- <<<<<<<========= Preview input_container start here   =========>>>>>>>>> -->



            <!-- <<<<<<<<<<<<<<<<<<<<=================== contact_div Start here ================>>>>>>>>>>>>>> -->

            <div class="contact_div col-4" id='contact_div'>
                <div class="col-12 contact_search_box">
                    <input class="col-5" id="searchBox" type="search" name="cont_search" title="" onfocus="search(this)">
                    <button class="col-6" id='searchBtn'>Search</button>
                    <!-- <button class="col-5" id='addBtn'>Add+</button> -->
                </div>
                <div id="contact_inner" class="col-12">
                    <div class="search_result col-12" style="background: rgb(245, 243, 243);padding-top:20px;display:none;">
                        <p> Search Result</p>
                        <hr>
                        <p style="padding-top: 10px"> Contact Lists</p>
                        <hr>
                        <p></p>
                    </div>
                    <div id="contact_list" class="col-12"></div>
                </div>
            </div>

            <!-- <<<<<<<<<<<<<<<<<<<<=================== contact_div End here ================>>>>>>>>>>>>>> -->
            <!-- <<<<<<<<<<<<<<<<<<<<=================== Message_div Start here ================>>>>>>>>>>>>>> -->
            <div class="rightDiv col-8">
                <div class=" rightDivdefault col-12">
                    <div class="col-12 adsense"></div>
                    <div class="col-12 ">
                        <h1>Click on contact to open Chat.</h1>
                        <a href="#"><h3>click for More info.</h3></a>
                    </div>
                    <div class="col-12 adsense"></div>
                    <!-- <img src="./uploads/8948927734.jpg" alt="" srcset=""> -->
                </div>

                <div class="col-12 message_maindiv" id="message_maindiv">
                    <!-- <<<<<<<========= contact_header Start here =========>>>>>>>>> -->

                    <!-- <header> -->
                    <div class="col-12" id="contact_header">
                        <div id="contact_header_div">
                            <!-- <div class="col-0 btn" id="backBtn" style="padding: 2.5% 3% 2.5% 1%;border-radius: 50%;" onclick="backToContact()">← -->
                        </div>
                        <div class="col-1 btn " onclick="backToContact()" id="backBtn" style="padding: 2.5% 0% 2.5% 2%;border-radius: 50%;padding-right: 2%;font-size: 2em;padding-top: 1%;padding-bottom: 1.5%;"><span>←</span></div>
                        <div class="contact_detail col-10" id="user_header" onclick="showDiv('contact_details_popup')">
                            <div class="contact_icon col-2"><img src=''></div>
                            <div class="contact_title col-9" id="user_name">
                            </div>
                            <div class="col-9 last_message">

                            </div>
                        </div>
                        <div class="btn col-1" style="padding: 2.5% 0% 2.5% 3%;border-radius: 50%;padding-right: 3%;"><span>☰</span></div>
                        <div id="user_id" style="display: none;"></div>


                    </div>
                    <div class='messageMain col-12' id="messageMain">
                    <div class="messages-container_box" id="messageContainer">

                        <!-- <div class="messages-container"> -->
                        <ol class="messages col-12" id="message_inner">
                        <li id="loadingEl"> loading...</li>
                        </ol>
                        <!-- </div> -->


                        <!-- <<<<<<<========= input_container start here   =========>>>>>>>>> -->



                    </div>
                    <footer class='inputFooter col-12' id="inputFooter">
                        <!-- <div class="col-12 chat-box-tray-outer" id='chat-box-tray-outer'>
                                <form class="chat-box-tray col-12" id="messagForm">
                                    <i class="fa fa-smile-o" onclick="insertAtCursor(this.nextElementSibling,'&#128647')"></i>
                                    <textarea name="message" id="inputTextArea" cols="30" rows="1" value="message" placeholder="Type your message here..." onfocus="detectKeyUp(this)"></textarea>
                                    <label for="image_input"><i class="fa fa-image" style="padding: 8px 5px;" oncl_ick="previewFile('image_input')"></i></label>
                                    <input type="file" name="image" id="image_input" style="display: none;" accept="image/*">
                                    <label for="submit"><i class="fa fa-send-o" style="padding: 8px 7px;" title="Send"></i></label>
                                    <input type="submit" id='submit' style="display: none;">
                                </form>
                            </div> -->
                    </footer>
                </div>

                <!-- <<<<<<<========= input_container End here =========>>>>>>>>> -->
                </div>
                <!-- </header> -->
                <!-- <<<<<<<=========    contact_header End here   =========>>>>>>>>> -->
                <!-- <<<<<<<========= message_container start here =========>>>>>>>>> -->
            

            </div>
        </div>
    </div>
    </div>
</body>
<script>
    deviceHandler();
</script>

</html>