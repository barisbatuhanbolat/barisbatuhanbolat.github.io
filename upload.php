<?php

session_start();

include("firebaseRDB.php");

// Default image link
$default_image_url = 'https://i.ibb.co/sV3QrNQ/Yeni-Proje.png';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $event_photo = $default_image_url;

    // Check if an image file is uploaded
    if (!empty($_FILES['image']['name'])) {
        $return = save_record_image($_FILES['image'], 'test');
        $event_photo = $return['data']['url'];
    }

    $userid = $_SESSION['user']['userid'];
    $event_name = $_POST['event-name'];
    $event_desc = $_POST['event-desc'];
    $event_location = $_POST['event-location'];
    $event_date = $_POST['event-date'];
    $event_last_date = $_POST['event-last-date'];

    $rdb = new firebaseRDB("https://silicode-58565-default-rtdb.firebaseio.com");
	
    $insert = $rdb ->insert("/events",[
        "author_id" => $userid,
        "event_name" => $event_name,
        "event_desc" => $event_desc,
        "event_location" => $event_location,
        "event_date" => $event_date,
        "event_last_date" => $event_last_date,
        "event_photo" => $event_photo
    ]);

    $result = json_decode($insert,1);

    $retrieve = $rdb->retrieve("/events","event_photo","EQUAL",$event_photo);
    $data = json_decode($retrieve,1);
    $id = array_keys($data)[0];
    
    $update = $rdb ->update("/events",$id,[
        "eventid" => $id
    ]);

    header("Location: dashboard");
}

// If the form is submitted
function save_record_image($image, $name = null)
{
    $API_KEY = 'eb56ad47de2d09015ec205a98507447a';
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://api.imgbb.com/1/upload?key=' . $API_KEY);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
    $extension = pathinfo($image['name'], PATHINFO_EXTENSION);
    $file_name = ($name) ? $name . '.' . $extension : $image['name'];
    $data = array('image' => base64_encode(file_get_contents($image['tmp_name'])), 'name' => $file_name);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    $result = curl_exec($ch);
    if (curl_errno($ch)) {
        return 'Error:' . curl_error($ch);
    } else {
        return json_decode($result, true);
    }
    curl_close($ch);
}
?>
