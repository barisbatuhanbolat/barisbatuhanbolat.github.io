<?php
	include("firebaseRDB.php");

	$fullname = $_POST['fullnameREG'];
	$username = $_POST['usernameREG'];
	$email = $_POST['emailREG'];
	$password = $_POST['passwordREG'];

	$rdb = new firebaseRDB("https://silicode-58565-default-rtdb.firebaseio.com");
	$retrieve = $rdb->retrieve("/users","email","EQUAL",$email);
	$data = json_decode($retrieve,1);
	
	if(count($data) <= 0){
		$insert = $rdb ->insert("/users",[
			"full_name" => $fullname,
			"username" => $username,
			"email" => $email,
			"password" => $password,
            "profile_photo" => "https://i.ibb.co/rZd0ZtY/Orange.webp",
            "profile_background" => "https://i.ibb.co/rZd0ZtY/Orange.webp"
		]);

		$result = json_decode($insert,1);

        $retrieve2 = $rdb->retrieve("/users","email","EQUAL",$email);

        $data2 = json_decode($retrieve2,1);
        $id = array_keys($data2)[0];
        
        $update = $rdb ->update("/users",$id,[
            "userid" => $id
        ]);

		if(isset($result['name'])){
			header("Location: index.php");
		}
	}
    header("Location: index.php");
?>