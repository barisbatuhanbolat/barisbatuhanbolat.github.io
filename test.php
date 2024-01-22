<?php
error_reporting(E_ERROR | E_PARSE);
session_start();

include("firebaseRDB.php");
if($_SESSION['user'] == null){
    header("location: index.php");
}
$rdb = new firebaseRDB("https://silicode-58565-default-rtdb.firebaseio.com");
$userid = $_SESSION['user']['userid'];
$username = $_SESSION['user']['username'];
$full_name = $_SESSION['user']['full_name'];
$profile_photo= $_SESSION['user']['profile_photo'];

$users = $rdb->retrieve("/users");
$user_datas = json_decode($users,1);
$found_user_data = null;

foreach ($user_datas as $user_data) {
    if ($user_data['username'] === $username) {
        $found_user_data = $user_data;
        break;
    }
}

$friendreq = $rdb->retrieve("/friend_requests");
$friend_requests = json_decode($friendreq, 1);
$friend_request = null;

$counter = 1;

$chatsq = $rdb->retrieve("/chat");
$chats = json_decode($chatsq, 1);

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
    <link rel="stylesheet" href="tailwindcss-colors.css?<?php echo filemtime('tailwindcss-colors.css'); ?>">
    <link rel="stylesheet" href="test-style.css?<?php echo filemtime('test-style.css'); ?>">
</head>
<body>

    <!-- start: Chat -->
    <section class="chat-section">
        <div class="chat-container">
            <!-- start: Sidebar -->
            <aside class="chat-sidebar">
                <a href="dashboard.php" class="chat-sidebar-logo">
                    <i class="ri-home-2-fill"></i>
                </a>
                <ul class="chat-sidebar-menu">
                    <li class="active"><a href="#" data-title="Chats"><i class="ri-chat-3-line"></i></a></li>
                    <li class="chat-sidebar-profile">
                        <button type="button" class="chat-sidebar-profile-toggle">
                            <img src="<?php echo $profile_photo;?>">
                        </button>
                        <ul class="chat-sidebar-profile-dropdown">
                            <li><a href="#"><i class="ri-user-line"></i> Profile</a></li>
                            <li><a href="logout.php"><i class="ri-logout-box-line"></i> Logout</a></li>
                        </ul>
                    </li>
                </ul>
            </aside>
            <!-- end: Sidebar -->
            <!-- start: Content -->
            <div class="chat-content">
                <!-- start: Content side -->
                <div class="content-sidebar">
                    <div class="content-sidebar-title">Chats</div>
                    <form action="" class="content-sidebar-form">
                        <input type="search" class="content-sidebar-input" placeholder="Search...">
                        <button type="submit" class="content-sidebar-submit"><i class="ri-search-line"></i></button>
                    </form>
                    <div class="content-messages">
                        <ul id="content-messages-list" class="content-messages-list">
                            <li class="content-message-title"><span>Friends</span></li>
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
                                        <li>
                                            <a href="#" data-conversation="#conversation-<?php echo $counter; ?>" onclick="listenForMessages('<?php echo $counter; ?>','<?php echo $found_user_data2['userid']; ?>', '<?php echo $_SESSION['user']['userid']; ?>')">
                                                <img class="content-message-image" src="<?php echo $found_user_data2['profile_photo'];?>" alt="">
                                                <span class="content-message-info">
                                                    <span class="content-message-name"><?php echo $found_user_data2['full_name']; ?></span>
                                                    <span class="content-message-text">@<?php echo $found_user_data2['username']; ?></span>
                                                    <input type="hidden" class="foundemail" name="foundemail" value="<?php echo $found_user_data2['email']; ?>">
                                                    <input type="hidden" class="foundpass" name="foundpass" value="<?php echo $found_user_data2['password']; ?>">
                                                    <input type="hidden" class="foundid<?php echo $counter; ?>" name="foundid<?php echo $counter; ?>" value="<?php echo $found_user_data2['userid']; ?>">
                                                </span>
                                                <span class="content-message-more">
                                                    <span class="content-message-unread">5</span>
                                                    <span class="content-message-time">12:30</span>
                                                </span>
                                            </a>
                                        </li>
                                        <?php
                                            $counter = $counter + 1 ;
                                        ?>
                                    <?php endif; ?>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </ul>
                        <input type="hidden" id="clickedUserData" name="clickedUserData" value="">
                        <input type="hidden" id="clickedUserId" name="clickedUserId" value="">
                        <input type="hidden" id="clickedUsername" name="clickedUsername" value="">
                        <input type="hidden" id="clickedUserfull" name="clickedUserfull" value="">
                        <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
                        <script>
                            $(document).ready(function() {
                                // Add click event handler to the li elements
                                $('#content-messages-list li').click(function(e) {
                                    e.preventDefault();

                                    // Extract data from the clicked li element
                                    var profile_photo = $(this).find('.content-message-image').attr('src');
                                    var full_name = $(this).find('.content-message-name').text();
                                    var username = $(this).find('.content-message-text').text();
                                    var email = $(this).find('.foundemail').text();
                                    var password = $(this).find('.foundpass').text();
                                    var userid = $(this).find('.foundid').text();


                                    // Create an object with the extracted data
                                    var userData = {
                                        profile_photo: profile_photo,
                                        full_name: full_name,
                                        username: username,
                                        email: email,
                                        password: password,
                                        userid : userid
                                    };

                                    // Convert the object to a JSON string
                                    var jsonData = JSON.stringify(userData);

                                    // Set the hidden input field value with the JSON data
                                    $('#clickedUserData').val(jsonData);

                                    // Perform an AJAX request to send the data to a PHP script
                                    $.ajax({
                                        type: 'POST',
                                        url: 'save_clicked_data.php',
                                        data: { clickedUserData: jsonData },
                                        success: function(response) {
                                            // Parse the JSON response
                                            var updatedUserData = JSON.parse(response);

                                            // Update the displayed data without reloading the page
                                            $('.conversation-user-image').attr('src', updatedUserData.profile_photo);
                                            $('.conversation-user-name').text(updatedUserData.full_name);

                                            // Optionally, you can perform other actions here
                                        }
                                    });
                                });
                            });
                        </script>                        
                    </div>
                </div>
                <!-- end: Content side -->
                <!-- start: Conversation -->
                <div class="conversation conversation-default active">
                    <i class="ri-chat-3-line"></i>
                    <p>Select chat and view conversation!</p>
                </div>
                <?php
                    $counter = 1 ;
                ?>                
                <?php foreach ($friend_requests as $friend_request) : ?>
                    <?php if ($friend_request['receiverid'] == $_SESSION['user']['userid'] || $friend_request['senderid'] == $_SESSION['user']['userid']) : ?>
                        <?php if ($friend_request['accepted'] == 1) : ?>
                            <div class="conversation" id="conversation-<?php echo $counter; ?>">
                                <div class="conversation-top">
                                    <button type="button" class="conversation-back"><i class="ri-arrow-left-line"></i></button>
                                    <div class="conversation-user">
                                        <img class="conversation-user-image" src="" alt="">
                                        <div>
                                            <div class="conversation-user-name"></div>
                                            <div class="conversation-user-status online">online</div>
                                        </div>
                                    </div>
                                    <div class="conversation-buttons" style="display : none">
                                        <button type="button"><i class="ri-phone-fill"></i></button>
                                        <button type="button"><i class="ri-vidicon-line"></i></button>
                                        <button type="button"><i class="ri-information-line"></i></button>
                                    </div>
                                </div>
                                <div class="conversation-main" id = "conversation-main<?php echo $counter; ?>">
                                </div>
                                <div class="conversation-form">
                                    <button type="button" class="conversation-form-button"><i class="ri-emotion-line"></i></button>
                                    <div class="conversation-form-group">
                                        <textarea class="conversation-form-input" id="message-input-<?php echo $counter; ?>" rows="1" placeholder="Type here..."></textarea>
                                    </div>
                                    <button type="button" onclick="sendMessage(<?php echo $counter; ?>)" class="conversation-form-button conversation-form-submit"><i class="ri-send-plane-2-line"></i></button>
                                </div>
                            </div>
                            <?php
                                $counter = $counter + 1 ;
                            ?>
                        <?php endif; ?>
                    <?php endif; ?>
                <?php endforeach; ?>
                <script>
                    function sendMessage(counter) {
                        console.log(counter);
                        const messageInput = document.getElementById('message-input-' + counter);
                        const message = messageInput.value.trim();
                        const part1 = "<?php echo $_SESSION['user']['userid']; ?>";
                        if (message !== '') {
                            const timestamp = new Date().getTime();
                            const chatId = '654564556'; // Replace with your chat ID
                            const participants = [part1, document.querySelector('.foundid'+ counter).value]; // Replace with sender and receiver user IDs

                            const messageData = message;

                            ajaxRequest('insertChat', {'participant1': participants[0], 'participant2': participants[1], 'message': messageData}, function(response) {
                                const chatId = JSON.parse(response).name;
                            });

                            messageInput.value = '';
                        }
                    }
                    let lastMessageTimestamp = 0; // Initialize with a default value
                    function listenForMessages(counter, participant1, participant2) {
                        setInterval(function() {
                            ajaxRequest('retrieveChatMessages', {'participant1': participant1, 'participant2': participant2}, function(response) {
                                const messages = JSON.parse(response);

                                // Check if messages is an object
                                if (typeof messages === 'object' && messages !== null) {
                                    // Process each message
                                    Object.keys(messages).forEach(key => {
                                        const messageData = messages[key];

                                        // Check if the message is newer than the last displayed message
                                        if (messageData.timestamp > lastMessageTimestamp) {
                                            const isMe = messageData.senderid === '<?php echo $_SESSION['user']['userid'];?>';
                                            if(messageData.message != ""){
                                                displayMessage(counter, messageData.message, isMe);
                                            }
                                            // Update the lastMessageTimestamp
                                            lastMessageTimestamp = messageData.timestamp;
                                        }
                                    });
                                } else {
                                    // Handle non-object response (e.g., display an error message)
                                    console.error('Invalid response format:', messages);
                                }
                            });
                        }, 1000); // Fetch messages every 5 seconds (adjust as needed)
                    }                  
                    function displayMessage(counter,messageData, isMe) {
                        const conversationMain = document.getElementById('conversation-main' + counter);
                        const messageElement = document.createElement('li');
                        
                        if (isMe) {
                            messageElement.classList.add('conversation-item');
                        } else {
                            messageElement.classList.add('conversation-item', 'me');
                        }

                        const messageSide = document.createElement('div');
                        messageSide.classList.add('conversation-item-side');

                        const messageImage = document.createElement('img');
                        messageImage.classList.add('conversation-item-image');
                        messageImage.src = isMe ? '<?php echo $_SESSION['user']['profile_photo'];?>' : '<?php echo $_SESSION['chatuser']['profile_photo'];?>';
                        messageImage.alt = '';

                        const messageContent = document.createElement('div');
                        messageContent.classList.add('conversation-item-content');

                        const messageWrapper = document.createElement('div');
                        messageWrapper.classList.add('conversation-item-wrapper');

                        const messageBox = document.createElement('div');
                        messageBox.classList.add('conversation-item-box');

                        const messageText = document.createElement('div');
                        messageText.classList.add('conversation-item-text');
                        messageText.innerHTML = `<p>${messageData}</p>`;

                        const messageTime = document.createElement('div');
                        messageTime.classList.add('conversation-item-time');
                        const currentTime = new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
                        messageTime.innerText = currentTime;

                        const messageDropdown = document.createElement('div');
                        messageDropdown.classList.add('conversation-item-dropdown');

                        const dropdownButton = document.createElement('button');
                        dropdownButton.setAttribute('type', 'button');
                        dropdownButton.classList.add('conversation-item-dropdown-toggle');
                        dropdownButton.innerHTML = '<i class="ri-more-2-line"></i>';

                        const dropdownList = document.createElement('ul');
                        dropdownList.classList.add('conversation-item-dropdown-list');
                        const forwardItem = document.createElement('li');
                        forwardItem.innerHTML = '<a href="#"><i class="ri-share-forward-line"></i> Forward</a>';
                        const deleteItem = document.createElement('li');
                        deleteItem.innerHTML = '<a href="#"><i class="ri-delete-bin-line"></i> Delete</a>';

                        dropdownList.appendChild(forwardItem);
                        dropdownList.appendChild(deleteItem);

                        messageDropdown.appendChild(dropdownButton);
                        messageDropdown.appendChild(dropdownList);

                        messageBox.appendChild(messageText);
                        messageBox.appendChild(messageTime);
                        messageBox.appendChild(messageDropdown);

                        messageWrapper.appendChild(messageBox);

                        messageContent.appendChild(messageWrapper);

                        messageSide.appendChild(messageImage);

                        messageElement.appendChild(messageSide);
                        messageElement.appendChild(messageContent);

                        conversationMain.appendChild(messageElement);
                    }

                    function ajaxRequest(action, data, callback) {
                        const xhr = new XMLHttpRequest();
                        const url = 'firebaseHandler.php';

                        xhr.onreadystatechange = function() {
                            if (xhr.readyState === XMLHttpRequest.DONE) {
                                if (xhr.status === 200) {
                                    if (callback && typeof callback === 'function') {
                                        callback(xhr.responseText);
                                    }
                                } else {
                                    console.error('Error:', xhr.statusText);
                                }
                            }
                        };

                        xhr.open('POST', url, true);
                        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                        xhr.send('action=' + action + '&' + encodeFormData(data));
                    }

                    function encodeFormData(data) {
                        return Object.keys(data)
                            .map(key => encodeURIComponent(key) + '=' + encodeURIComponent(data[key]))
                            .join('&');
                    }
                </script>
                <!-- end: Conversation -->
            </div>
            <!-- end: Content -->
        </div>
    </section>
    <!-- end: Chat -->
    
    <script src="test-script.js?rand=<?php echo rand(); ?>"></script>
</body>
</html>