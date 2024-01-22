<?php
error_reporting(E_ERROR | E_PARSE);
session_start();

include("firebaseRDB.php");

if($_SESSION['user'] == null){
    header("location: index");
}
$username = $_GET['id'];

$rdb = new firebaseRDB("https://silicode-58565-default-rtdb.firebaseio.com");
$retrieveEvents = $rdb->retrieve("/events");
$events = json_decode($retrieveEvents, true);

$users = $rdb->retrieve("/users");
$user_datas = json_decode($users,1);
$found_user_data = null;

foreach ($user_datas as $user_data) {
    if ($user_data['username'] === $username) {
        $found_user_data = $user_data;
        break;
    }
}

$profile_photo = $found_user_data['profile_photo'];
$profile_back = $found_user_data['profile_background'];

$full_name = $found_user_data['full_name'];
$about = $found_user_data['about'];

$friendreq = $rdb->retrieve("/friend_requests");
$friend_requests = json_decode($friendreq, 1);
$friend_request = null;
foreach ($friend_requests as $temprequest) { 
    if (($temprequest['receiverid'] == $found_user_data['userid'] && $temprequest['senderid'] == $_SESSION['user']['userid'])||
        ($temprequest['senderid'] == $found_user_data['userid'] && $temprequest['receiverid'] == $_SESSION['user']['userid'])){
        $friend_request = $temprequest;
    }
}

$friendsq = $rdb->retrieve("/friends");
$friends = json_decode($friendsq, 1);

$messageq = $rdb->retrieve("/chat");
$messages = json_decode($messageq, 1);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OPIUM</title>
    <!-- IconScout CDN -->
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v2.1.6/css/unicons.css">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet"/>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css' rel='stylesheet'>
    <!-- Stylesheet -->
    <link rel="stylesheet" type="text/css" href="user-style.css?<?php echo filemtime('user-style.css'); ?>">


</head>
<body>
    <nav>
        <div class="container">
            <?php echo '<h2><a href="' . "dashboard" . '">' . "OPIUM" . '</a></h2>'; ?>
        </div>
    </nav>

    <!-------------------------------- MAIN ----------------------------------->
    <main>
        <div class = "head-profile">
            <div class="profile-back"  style="background-image: url('https://cdn.discordapp.com/attachments/1079470969602707498/1185562639900868749/bbbaris_dark_orange_abstract_4k_14fdadb4-4f06-49e0-bed9-67d3b4d87763.png?ex=65901040&is=657d9b40&hm=fc10c83d09ccfd961c9e3d82ed092f2f473e11a1531a311c90cddda8f92306f3&'); background-size: cover; background-position: center; background-repeat: no-repeat;">
                <div class= "profile_info">
                    <div class="profile-photo-2" style="background-image: url('<?php echo $profile_photo; ?>'); background-size: cover; background-position: center; background-repeat: no-repeat;">
                    </div>
                    <div class="profile act" id="profile">
                        <div class="handle">
                            <h4 ><?php echo $full_name; ?>  </h4>
                            <p class="text-muted">
                                @<?php echo $username; ?> 
                            </p>
                            <p class="text-muted" style = "font-style: italic;">
                                <?php echo $about; ?> 
                            </p>                                
                        </div>
                    </div>
                    <?php 
                        if ($_SESSION['user']['username'] == $username){
                            echo '<input type="submit" class = "edit-btn"  value="Edit">';
                        }
                        else{
                            echo '<input type="hidden" class = "edit-btn"  value="Edit">';
                        }
                    
                    ?>                    
                </div>
                <form id="sendfriend" action= "requestFriend.php" method="post">
                    <input type="hidden" name="receiverid" value="<?php echo $found_user_data['userid']; ?>">
                    <?php 
                        if($friend_request != null){
                            if($friend_request['accepted'] == 0){
                                echo '<input type="submit" class="btn btn-primary" id="friendbtn" value="Requested" style = "background: #FFFF00; color : #000000 ;cursor: not-allowed">';
                            }
                            else if($friend_request['accepted'] == 1){
                                echo '<input type="submit" class="btn btn-primary" id="friendbtn" value="Friend" style = "background: #008000; cursor: not-allowed">';
                            }
                        }
                        else{
                            if($found_user_data['userid'] == $_SESSION['user']['userid']){
                                echo '<input type="hidden" class="btn btn-primary" id="friendbtn" value="Send Request">';
                            }
                            else{
                                echo '<input type="submit" class="btn btn-primary" id="friendbtn" value="Send Request">';
                            }
                        }
                    ?>
                </form>
            </div>
        </div>
        <div class="container">
            <!----------------- LEFT -------------------->
            <div class="left">
                <div class="messages">
                    <div class="heading">
                        <h4>Friends</h4>
                    </div>
                    <!------- SEARCH BAR ------->
                    <div class="search-bar">
                        <i class="uil uil-search"></i>
                        <input type="search" placeholder="Search friends" id="message-search">
                    </div>
                    <!------- MESSAGES CATEGORY ------->
                    <!------- MESSAGES ------->
                        <?php foreach ($friend_requests as $friend_request) : ?>
                            <?php if ($friend_request['receiverid'] == $found_user_data['userid'] || $friend_request['senderid'] == $found_user_data['userid']) : ?>
                                <?php if ($friend_request['accepted'] == 1) : ?>
                                    <?php
                                        if($found_user_data['userid'] != $friend_request['senderid']){
                                            foreach ($user_datas as $user_data) {
                                                if ($user_data['userid'] === $friend_request['senderid']) {
                                                    $found_user_data2 = $user_data;
                                                    break;
                                                }
                                            }
                                        }
                                        else{
                                            foreach ($user_datas as $user_data) {
                                                if ($user_data['userid'] === $friend_request['receiverid']) {
                                                    $found_user_data2 = $user_data;
                                                    break;
                                                }
                                            }                                            
                                        }
                                    ?>
                                    <a class="message" href = "<?php echo "user.php?id=" . $found_user_data2['username']; ?>" style = "display : flex">
                                        <div class="profile-photo">
                                            <img src="<?php echo $found_user_data2['profile_photo'];?>">
                                        </div>
                                        <div class="message-body">
                                            <h5><?php echo $found_user_data2['full_name']; ?></h5>
                                            <p class="text-muted">@<?php echo $found_user_data2['username']; ?></p>
                                        </div>
                                    </a>
                                <?php endif; ?>
                            <?php endif; ?>
                        <?php endforeach; ?>
                </div>            
            </div>
            
            <!----------------- MIDDLE -------------------->
            <div class="middle">
                <!----------------- FEEDS -------------------->
                <div class="feeds">
                    <!----------------- FEED 1 -------------------->
                    <?php foreach ($events as $event) : ?>
                        <?php if ($event['author_id'] == $found_user_data['userid']) : ?>
                            <form id="editForm" action= "deleteEvent.php" method="post" enctype="multipart/form-data">
                                <div class="feed">
                                    <div class="photo">
                                        <img src="<?php echo $event['event_photo'];?>">
                                    </div>

                                    <div class="caption">
                                        <p><b><?php echo $event['event_name']; ?></b></p>
                                    </div>
                                    <div class="user">
                                        <div class="profile-photo">
                                            <img src="<?php echo $found_user_data['profile_photo']; ?>">
                                        </div>
                                        <div class="info">
                                            <p>Organized by <b>@<?php echo $username; ?></b></p>
                                        </div>
                                    </div>
                                    <div class="description">
                                        <p><?php echo $event['event_desc']; ?></p>
                                    </div>
                                    <div class="bottom">
                                        <div class="bottom-left">
                                            <div class="date">
                                                <i class="ri-calendar-line"></i>
                                                <p><?php echo $event['event_date']; ?></p>
                                            </div>

                                            <div class="last-date">
                                                <p>Last Registration Date is <?php echo $event['event_last_date']; ?></p>
                                            </div>

                                            <div class="date">
                                                <i class="ri-map-pin-line"></i>
                                                <p><?php echo $event['event_location']; ?></p>
                                            </div>
                                        </div>
                                        <input type="hidden" name="event_photo" value="<?php echo $event['event_photo']; ?>">
                                        <?php
                                            if($found_user_data['userid'] == $_SESSION['user']['userid']){
                                                echo '<input type="submit" value="Delete">';
                                            }
                                            else{
                                                echo '<input type="hidden" value="Delete">';
                                            }
                                        ?>                                        
                                    </div>
                                </div>
                            </form>
                        <?php endif; ?>
                    <?php endforeach; ?>
                    <!----------------- END OF FEED 1 -------------------->
                </div>
                <!----------------- END OF FEEDS -------------------->
            </div>
             <!----------------- END OF MIDDLE -------------------->
             <!--------------------- RIGHT------------------------->               
            <!----------------- END OF RIGHT -------------------->
        </div>
    </main>
    
    <div class="create-event">
        <div class="wrapper">
            <form id="editForm" action= "<?php echo "editProfile.php?id=" . $username; ?>" method="post" enctype="multipart/form-data">
                <h3 class="upper">Edit Profile</h3>
                <div class="input-box">
                    <div class="name-area">
                        <input type="text" name = "full_name_edit" placeholder = "Full name">
                    </div>
                </div>
                <div class="input-box">
                    <div class="date-area">
                        <input type="text" name = "username_edit" placeholder = "Username">
                    </div>
                </div>       
                <div class="input-box">
                    <div class="desc-area">
                        <textarea id="msg" name = "bio_edit" rows="7" cols="54" placeholder = "About"></textarea>
                    </div>
                </div>              
                <div class="container-image">
                    <h3>Profile photo</h3>
                    <div class="drag-area">
                        <div class="icon">
                            <i class="fas fa-images"></i>
                        </div>
                        <span class="header">Drag & Drop</span>
                        <span class="header2">or <span class="button">browse</span></span>
                        <input type="file" name="profile_image" id="profile_image"  accept="image/*" hidden>
                        <span class="support">Supports: JPEG, JPG, PNG</span>
                    </div>
                </div>                      
                <div class="bottom">
                    <input type="submit" class="btn btn-primary" id = "createbtn" value="Save">
                </div>
            </form>
        </div>
    </div>

    <script src="user-script.js?rand=<?php echo rand(); ?>"></script>

</body>
</html>