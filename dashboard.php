<?php
error_reporting(E_ERROR | E_PARSE);
session_start();

include("firebaseRDB.php");
if($_SESSION['user'] == null){
    header("location: index.php");
}
$userid = $_SESSION['user']['userid'];
$username = $_SESSION['user']['username'];
$full_name = $_SESSION['user']['full_name'];
$profile_photo= $_SESSION['user']['profile_photo'];

$rdb = new firebaseRDB("https://silicode-58565-default-rtdb.firebaseio.com");
$retrieveEvents = $rdb->retrieve("/events");
$events = json_decode($retrieveEvents, true);

$users = $rdb->retrieve("/users");
$user_datas = json_decode($users,1);
$found_user_data = null;
$temp_data = null;

$retrieveRequests = $rdb->retrieve("/event_requests");
$event_requests = json_decode($retrieveRequests,1);

$friendreq = $rdb->retrieve("/friend_requests");
$friend_requests = json_decode($friendreq, 1);

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
    <link rel="stylesheet" type="text/css" href="dashboard-style.css?<?php echo filemtime('dashboard-style.css'); ?>">


</head>
<body>
    <nav>
        <div class="container">
            <?php echo '<h2><a href="' . "dashboard.php" . '">' . "OPIUM" . '</a></h2>'; ?>
            <div class="search-bar">
                <i class="uil uil-search"></i>
                <input type="search" id = "searchbar" placeholder="Search">
                <div class="search-dropdown" id="searchDropdown"></div>
            </div>
            <div class="create">
                <input type="submit" class="btn btn-primary" id = "createbtn" value="Create">
                <form action="logout.php" method="post">
                    <input type="submit" class="btn btn-primary" id = "logoutbtn" value="Logout">
                </form>
            </div>
        </div>
    </nav>
<script>
document.addEventListener('DOMContentLoaded', function() {
    var searchInput = document.querySelector('.search-bar input[type="search"]');
    var dropdown = document.createElement('div');
    dropdown.classList.add('dropdown');
    document.querySelector('.search-bar').appendChild(dropdown);

    searchInput.addEventListener('input', function() {
        var searchValue = this.value.toLowerCase();
        dropdown.innerHTML = '';

        if (searchValue.length > 0) {
            var userArray = Object.values(<?php echo json_encode($user_datas); ?>);

            var filteredUsers = userArray.filter(function(user) {
                return user['username'].toLowerCase().includes(searchValue);
            });

            filteredUsers.forEach(function(user) {
                var item = document.createElement('li');
                item.classList.add('dropdown-item');
                item.textContent = user['username'];
                item.addEventListener('click', function() {
                    window.location.href = "user?id=" + item.textContent;
                });
                dropdown.appendChild(item);
            });
        }
    });
});

</script>



    <!-------------------------------- MAIN ----------------------------------->
    <main>
        <div class="container">
            <!----------------- LEFT -------------------->
            <div class="left">
                <a href = "<?php echo "user.php?id=" . $username; ?>" class="profile act" id="profile">
                    <div class="profile-photo">
                        <img src="<?php echo $profile_photo; ?> ">
                    </div>
                    <div class="handle">
                        <h4 ><?php echo $full_name; ?>  </h4>
                        <p class="text-muted">
                            @<?php echo $username; ?> 
                        </p>
                    </div>
                </a>

                <!----------------- SIDEBAR -------------------->
                <div class="sidebar">
                    <a class="menu-item active">
                        <span><i class="uil uil-home"></i></span>
                        <h3>Home</h3>   
                    </a>
                    <a class="menu-item"  id="notifications">
                        <span><i class="uil uil-bell"><small class="notification-count"></small></i></span>
                        <h3>Notification</h3>
                        <!--------------- NOTIFICATION POPUP --------------->
                        <div class="notifications-popup">
                            <?php foreach ($event_requests as $request) : ?>
                                <?php if ($request['authorid'] == $userid) : ?>
                                    <?php if ($request['accepted'] == 0) : ?>
                                        <?php
                                            foreach ($user_datas as $user_data) {
                                                if ($user_data['userid'] === $request['senderid']) {
                                                    $found_user_data = $user_data;
                                                    break;
                                                }
                                            }
                                            $temp_data = null;
                                            foreach ($events as $temp_event) {
                                                if ($temp_event['eventid'] === $request['eventid']) {
                                                    $temp_data = $temp_event;
                                                    break;
                                                }
                                            }                                            
                                        ?>
                                        <div>
                                            <div class="profile-photo">
                                                <img src="<?php echo $found_user_data['profile_photo'];?>">
                                            </div>
                                            <div class = "notif-right">
                                                <div class="notification-body">
                                                    <b><?php echo $found_user_data['full_name'];?></b> wants to join your event <b><?php echo $temp_data['event_name'];?></b>
                                                    <form action="decisionRequest.php" method="post">
                                                        <div class="decision-body">
                                                            <input type="hidden" name = "eventid" value="<?php echo $request['eventid']; ?>">
                                                            <input type="hidden" name = "decision" id = "decision" value="0">
                                                            <input type="submit" id = "acceptsign" onclick = "change1()" value="Accept">
                                                            <input type="submit" id = "declinesign" onclick = "change_1()" value="Decline">
                                                            <script>
                                                                function change1() {
                                                                    var targetInput = document.getElementById('decision');
                                                                    targetInput.value = '1';
                                                                }
                                                                function change_1() {
                                                                    var targetInput = document.getElementById('decision');
                                                                    targetInput.value = '-1';
                                                                }                                                        
                                                            </script>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endif; ?>                                        
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </div>
                        <!--------------- END NOTIFICATION POPUP --------------->
                    </a>
                    <a class="menu-item" href = "test.php">
                        <span><i class="fa-regular fa-comments"></i></span>
                        <h3>Chat</h3>
                    </a>
                    <a class="menu-item" id="theme">
                        <span><i class="uil uil-palette"></i></span>
                        <h3>Theme</h3>
                    </a>
                </div>
                <!----------------- END OF SIDEBAR -------------------->
            </div>
            <!----------------- MIDDLE -------------------->
            <div class="middle">
                <!----------------- FEEDS -------------------->
                <div class="feeds">
                    <!----------------- FEED 1 -------------------->
                    <?php if (!empty($events)) : ?>
                        <?php foreach ($events as $event) : ?>
                            <div class="feed">
                                <form action="requestEvent.php" method="post">
                                    <div class="photo">
                                        <img src="<?php echo $event['event_photo'];?>">
                                    </div>

                                    <div class="caption">
                                        <p><b><?php echo $event['event_name']; ?></b></p>
                                    </div>
                                    <?php
                                        foreach ($user_datas as $user_data) {
                                            if ($user_data['userid'] === $event['author_id']) {
                                                $found_user_data = $user_data;
                                                break;
                                            }
                                        }
                                    ?>
                                    <div class="user">
                                        <div class="profile-photo">
                                            <img src="<?php 
                                                echo $found_user_data['profile_photo'];                                    
                                                ?> ">
                                        </div>
                                        <div class="info">
                                            <p>Organized by <b>@<?php                                     
                                                echo $found_user_data['username'];                                    
                                                ?></b></p>
                                        </div>
                                    </div>
                                    <div class = "description">                            
                                        <p><?php echo $event['event_desc']; ?></p>
                                    </div>
                                    <div class = "bottom">
                                        <div class = "bottom-left">
                                            <div class = "date">
                                                <i class="ri-calendar-line"></i>
                                                <p><?php echo $event['event_date']; ?></p>
                                            </div>
                                            
                                            <div class = "last-date">
                                                <p>Last Registration Date is <?php echo $event['event_last_date']; ?></p>
                                            </div>

                                            <div class = "date">
                                                <i class="ri-map-pin-line"></i>
                                                <p><?php echo $event['event_location']; ?></p>
                                            </div>
                                        </div>
                                        <input type="hidden" name="event_photo" value="<?php echo $event['event_photo']; ?>">
                                        <input type="hidden" name="eventid" value="<?php echo $event['eventid']; ?>">
                                        <input type="hidden" name="author_id" value="<?php echo $event['author_id']; ?>">
                                        <?php 
                                            $temp1 = $rdb->retrieve("/event_requests","eventid","EQUAL",$event['eventid']);
                                            $temp2 = json_decode($temp1, 1);
                                            if ($temp2[array_keys($temp2)[0]]['senderid'] == $userid) {
                                                if($temp2[array_keys($temp2)[0]]['accepted'] == 0){
                                                    echo '<input type="submit" value="Requested" style = "background: #FFFF00; color : #000000 ;cursor: not-allowed ;opacity : 0.6">';
                                                }
                                                else if($temp2[array_keys($temp2)[0]]['accepted'] == 1){
                                                    echo '<input type="submit" value="Joined" style = "background: #008000; cursor: not-allowed ;opacity : 0.6">';
                                                }
                                                else{
                                                    echo '<input type="submit" value="Denied" style = "background: #FF0000; cursor: not-allowed ;opacity : 0.6">';
                                                }
                                            } 
                                            else if($event['author_id'] == $userid){
                                                echo '<input type="hidden" value="Send Request">';
                                            }
                                            else{
                                                echo '<input type="submit" value="Send Request">';
                                            }
                                        ?>                                  
                                    </div>
                                </form>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                    <!----------------- END OF FEED 1 -------------------->
                </div>
                <!----------------- END OF FEEDS -------------------->
            </div>
             <!----------------- END OF MIDDLE -------------------->

            <!----------------- RIGHT -------------------->
            <div class="right">
                <!------- MESSAGES ------->
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
                    <?php if ($_SESSION['user']['username'] == $username) : ?>
                        <?php foreach ($friend_requests as $friend_request) : ?>
                            <?php if ($friend_request['receiverid'] == $_SESSION['user']['userid'] || $friend_request['senderid'] == $_SESSION['user']['userid']) : ?>
                                <?php if ($friend_request['accepted'] == 1) : ?>
                                    <?php
                                        if($_SESSION['user']['userid'] != $friend_request['senderid']){
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
                    <?php endif; ?>                 
                </div>
                <!------- END OF MESSAGES ------->
                <!------- FRIEND REQUEST ------->
                <div class="friend-requests">
                    <h4>Friend Requests</h4>
                    <?php foreach ($friend_requests as $request1) : ?>
                        <?php if ($request1['receiverid'] == $userid && $request1['accepted'] == 0) : ?>
                            <?php
                            foreach ($user_datas as $user_data) {
                                if ($user_data['userid'] === $request1['senderid']) {
                                    $found_user_data = $user_data;
                                    break;
                                }
                            }
                            ?>
                            <div class="request">
                                <div class="info">
                                    <div class="profile-photo">
                                        <img src="<?php echo $found_user_data['profile_photo']; ?>">
                                    </div>
                                    <div>
                                        <h5><?php echo $found_user_data['full_name']; ?></h5>
                                        <p class="text-muted">@<?php echo $found_user_data['username']; ?></p>
                                    </div>
                                </div>
                                <form action="decisionFriend.php" method="post" class="friendForm">
                                    <div class="action">
                                        <input type="hidden" name="decisionfriend" value="0">
                                        <input type="hidden" name="senderid" value="<?php echo $request1['senderid']; ?>">
                                        <button type="button" class="btn btn-primary" onclick="change2(this)">Accept</button>
                                        <button type="button" class="btn" onclick="change_2(this)">Decline</button>
                                        <script>
                                            function change2(button) {
                                                var form = button.closest('form');
                                                var targetInput = form.querySelector('input[name="decisionfriend"]');
                                                targetInput.value = '1';
                                                submitForm(form);
                                            }

                                            function change_2(button) {
                                                var form = button.closest('form');
                                                var targetInput = form.querySelector('input[name="decisionfriend"]');
                                                targetInput.value = '-1';
                                                submitForm(form);
                                            }

                                            function submitForm(form) {
                                                form.submit();
                                            }
                                        </script>
                                    </div>
                                </form>
                            </div>
                        <?php endif; ?>
                    <?php endforeach; ?>


                </div>                
            </div>
            <!----------------- END OF RIGHT -------------------->
        </div>
    </main>

    <!----------------- THEME CUSTOMIZATION -------------------->
    <div class="customize-theme">
        <div class="card">
            <h2>Customize your view</h2>
            <p class="text-muted">Manage your font size and color theme</p>

            <!----------- FONT SIZE ----------->
            <div class="font-size">
                <h4>Font Size</h4>
                <div>
                    <h6>Aa</h6>
                    <div class="choose-size">
                        <span class="font-size-1"></span>
                        <span class="font-size-2 active"></span>
                        <span class="font-size-3"></span>
                        <span class="font-size-4"></span>
                        <span class="font-size-5"></span>
                    </div>
                    <h3>Aa</h3>
                </div>
            </div>

            <!----------- BACKGROUND COLORS ----------->
            <div class="background">
                <h4>Background</h4>
                <div class="choose-bg">
                    <div class="bg-1 active">
                        <span></span>
                        <h5 for="bg-1">Light</h5>
                    </div>
                    <div class="bg-2">
                        <span></span>
                        <h5 for="bg-2">Dim</h5>
                    </div>
                    <div class="bg-3">
                        <span></span>
                        <h5 for="bg-3">Dark</h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="create-event">
        <div class="wrapper">
            <form action="upload.php" method="post" enctype="multipart/form-data">
                <h3 class = "upper">Create Event</h3>
                <div class="input-box">
                    <div class="name-area">
                        <input type="text" name = "event-name" placeholder = "Enter name">
                    </div>
                </div>
                <div class="input-box">
                    <div class="desc-area">
                        <textarea id="msg" name = "event-desc" rows="7" cols="54" placeholder = "Enter description"></textarea>
                    </div>
                </div>
                <div class="input-box">
                    <div class="date-area">
                        <input type="text" name = "event-location" placeholder = "Enter location">
                    </div>
                </div>            
                <div class="input-box">
                    <div class="date-area">
                        <input type="text" name = "event-date" placeholder = "Enter date">
                    </div>
                </div>
                <div class="input-box">
                    <div class="last-date-area">
                        <input type="text" name = "event-last-date" placeholder = "Enter last date">
                    </div>
                </div>      
                <div class="container-image">
                    <h3>Event photo</h3>
                    <div class="drag-area">
                        <div class="icon">
                            <i class="fas fa-images"></i>
                        </div>
                        <span class="header">Drag & Drop</span>
                        <span class="header2">or <span class="button">browse</span></span>
                        <input type="file" name="image" id="image"  accept="image/*" hidden>
                        <span class="support">Supports: JPEG, JPG, PNG</span>
                    </div>
                </div>                                                        
                <div class="bottom">
                    <input type="submit" class="btn btn-primary" id = "createbtn" value="Create">
                </div>
            </form>
        </div>
    </div>

    <script src="dashboard-script.js?rand=<?php echo rand(); ?>"></script>

</body>
</html>