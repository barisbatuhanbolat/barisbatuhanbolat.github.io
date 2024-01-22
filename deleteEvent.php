<?php

session_start();

include("firebaseRDB.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $event_photo = $_POST['event_photo'];
    $rdb = new firebaseRDB("https://silicode-58565-default-rtdb.firebaseio.com");
    $retrieve = $rdb->retrieve("/events","event_photo","EQUAL",$event_photo);
    $data = json_decode($retrieve,1);

    $delete = $rdb ->delete("/events",array_keys($data)[0]);

    $result = json_decode($delete,1);
    $back = "user?id=" . $_SESSION['user']['username'];
    header("Location: $back");
}
?>
