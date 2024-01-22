<?php
session_start();

// Retrieve the clicked user data from the POST request
$clickedUserData = isset($_POST['clickedUserData']) ? json_decode($_POST['clickedUserData'], true) : null;
$_SESSION['chatuser'] = $clickedUserData;

// Respond with the updated user data 
echo json_encode($_SESSION['chatuser']);
?>
