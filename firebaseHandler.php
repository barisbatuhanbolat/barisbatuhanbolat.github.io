<?php
// Include your existing firebaseRDB class here
include 'firebaseRDB.php';

// Initialize firebaseRDB with your Firebase Database URL
$firebaseDB = new firebaseRDB('https://silicode-58565-default-rtdb.firebaseio.com');

// Handle AJAX requests from app.js
if (isset($_POST['action'])) {
    $action = $_POST['action'];

    switch ($action) {
        case 'insertChat':
            $participant1 = $_POST['participant1'];
            $participant2 = $_POST['participant2'];
            $message = $_POST['message'];
            $result = $firebaseDB->insertChat($participant1, $participant2, $message);
            echo $result;
            break;

        case 'updateChatMessage':
            $chatId = $_POST['chatId'];
            $message = $_POST['message'];
            $result = $firebaseDB->updateChatMessage($chatId, $message);
            echo $result;
            break;

        case 'retrieveChatMessages':
            $participant1 = $_POST['participant1'];
            $participant2 = $_POST['participant2'];
            $result = $firebaseDB->retrieveChatMessages($participant1, $participant2,);
            echo $result;
            break;

        // Add more cases for other actions as needed

        default:
            // Handle invalid action
            break;
    }
}
?>
