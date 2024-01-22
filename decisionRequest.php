<?php

session_start();

include("firebaseRDB.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $event_photo = $_POST['event_photo'];
    $decision = $_POST['decision'];
    $rdb = new firebaseRDB("https://silicode-58565-default-rtdb.firebaseio.com");
    $retrieve = $rdb->retrieve("/event_requests","event_photo","EQUAL",$event_photo);
    $data = json_decode($retrieve,1);

    $update = $rdb ->update("/event_requests",array_keys($data)[0],[
        "accepted" => $decision
    ]);

    header("Location: dashboard");
}

?>