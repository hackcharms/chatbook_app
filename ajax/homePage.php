<?php
require('./conection.php');
require('./modules.php');

use MyApp\Connection\database;

session_start();
if (isset($_SESSION['username']))
    $me = filter_var($_SESSION['username'], FILTER_VALIDATE_INT);
else
    $me = false;
if ($me) {
    $data = [];
    $chatbook_db = new database();
    $current_users = $chatbook_db->get_data('*', 'current_users', 'sender=' . $_SESSION['username'] . ' or receiver=' . $_SESSION['username'], 'ORDER BY `time` DESC');
    $mydata = $chatbook_db->get_data('*', 'login', 'user_name=' . $_SESSION['username'])[0];
    if(!empty($current_users)){
        // echo $me;
    foreach ($current_users as $user) {
        // echo "$user[sender] <br>";
        if($user['receiver']==$me)
        $countMess=$chatbook_db->get_data('count(message) as count','unread_messages',"`from`=".$user['sender']." and `to`=".$user['receiver']);
        $users_id = $user['receiver'] == $_SESSION['username'] ? $user['sender'] : $user['receiver'];
        $details = $chatbook_db->get_data('*', 'login', 'user_name=' . $users_id)[0];
        $details['last_mess'] = $user['message'];
        $details['mess_time'] = formatTime($user['time']);
        if($user['receiver']==$me)
        $details['new_mess']=$countMess[0]['count'];
        $last_active = formatTime($details['last_active'], true);
        if ($last_active == 'Online' || $details['online_status']) {
            $details['mess_time'] = 'Online';
        }
        array_push($data, $details);
    }}
    $data['myData'] = $mydata;
    // echo '<pre>';
    // print_r($data);
    echo json_encode($data);
} else {
    session_destroy();
    die('Error 404: not Found');
}
