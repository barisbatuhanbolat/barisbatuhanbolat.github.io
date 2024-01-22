<?php

session_start();

include("firebaseRDB.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $senderid = $_SESSION['user']['userid'];
    $receiverid = $_POST['receiverid'];
    $rdb = new firebaseRDB("https://silicode-58565-default-rtdb.firebaseio.com");
    $insert = $rdb ->insert("/friend_requests",[
        "accepted" => 0,
        "receiverid" => $receiverid,
        "senderid" => $senderid
    ]);

    $result = json_decode($insert,1);  
    header("Location: dashboard.php");
}
?>