<?php

session_start();

include("firebaseRDB.php");
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $rdb = new firebaseRDB("https://silicode-58565-default-rtdb.firebaseio.com");
    $decision = $_POST['decisionfriend'];
    $senderid = $_POST['senderid'];
    $retrieve = $rdb->retrieve("/friend_requests","receiverid","EQUAL",$_SESSION['user']['userid']);
    $data = json_decode($retrieve,1);
    $i = 0;
    foreach ($data as $friendRequest) {
        if($friendRequest['senderid'] == $senderid){
            break;
        }
        $i = $i + 1;
    }
    $update = $rdb ->update("/friend_requests",array_keys($data)[$i],[
        "accepted" => intval($decision)
    ]);
    
    $notifaccepted = false;
    if($decision == "1"){
        $notifaccepted = true; 
    } 

    $insert2 = $rdb ->insert("/notifications",[
        "accepted" => $notifaccepted,
        "receiverid" => $data[array_keys($data)[0]]['senderid'],
        "senderid" => $data[array_keys($data)[0]]['receiverid'],
        "eventid" => "-1"
    ]);

    $result2 = json_decode($insert2,1);  

    header("Location: dashboard.php");
}
?>