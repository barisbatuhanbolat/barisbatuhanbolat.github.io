<?php

session_start();

include("firebaseRDB.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $event_photo = $_POST['event_photo'];
    $eventid = $_POST['eventid'];
    $userid = $_SESSION['user']['userid'];
    $author_id = $_POST['author_id'];
    if($userid != $event_author){
        $rdb = new firebaseRDB("https://silicode-58565-default-rtdb.firebaseio.com");
        $insert = $rdb ->insert("/event_requests",[
            "accepted" => 0,
            "senderid" => $userid,
            "authorid" => $author_id,
            "eventid" => $_POST['eventid']
        ]);

        $result = json_decode($insert,1);      
    }
    header("Location: dashboard.php");
}
?>