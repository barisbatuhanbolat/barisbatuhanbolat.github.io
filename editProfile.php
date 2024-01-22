<?php

session_start();

include("firebaseRDB.php");

$email = $_SESSION['user']['email'];
$new_full_name = $_POST['full_name_edit'];
$new_username = $_POST['username_edit'];
$new_about = $_POST['bio_edit'];
// Default image link
$default_image_url = $_SESSION['user']['profile_photo'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $rdb = new firebaseRDB("https://silicode-58565-default-rtdb.firebaseio.com");
    $retrieve = $rdb->retrieve("/users","email","EQUAL",$email);
    $data = json_decode($retrieve,1);

    $profile_photo = $default_image_url;

    // Check if an image file is uploaded
    if (!empty($_FILES['profile_image']['name'])) {
        $return = save_record_image($_FILES['profile_image'], 'test');
        $profile_photo = $return['data']['url'];
    }

    $update = $rdb ->update("/users",array_keys($data)[0],[
        "username" => $new_username,
        "full_name" => $new_full_name,
        "about" => $new_about,
        "profile_photo" => $profile_photo
    ]);
    $_SESSION['user']['profile_photo'] = $profile_photo;
    $_SESSION['user']['username'] = $new_username;
    $_SESSION['user']['full_name'] = $new_full_name;

    $result = json_decode($update,1);
    $back = "user?id=" . $_SESSION['user']['username'];
    header("Location: $back");
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
