<?php
session_start();
include("firebaseRDB.php");

$email = $_POST['emailLOG'];
$password = $_POST['passwordLOG'];

$rdb = new firebaseRDB("https://silicode-58565-default-rtdb.firebaseio.com");
$retrieve = $rdb->retrieve("/users","email","EQUAL",$email);
$data = json_decode($retrieve,1);

if(count($data) != 0){
    $id = array_keys($data)[0];
    if($data[$id]['password'] == $password){
        $_SESSION['user'] = $data[$id];
        header("location: dashboard");
    }
    else{
        header("location: index");
    }
}
else{
    header("location: index");
}
?>