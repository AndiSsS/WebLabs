<?php 
error_reporting(0);

session_start();
if(!$_SESSION["loggedin"])
	die();

require("resources/config.php");
require("resources/library/helpers.php");

if($_SERVER["REQUEST_METHOD"] == "POST"){
	$message = htmlspecialchars($_POST["message"]);

	$data = [
		'userId' => $_SESSION['id'],
		'username' => $_SESSION['username'],
		'message' => $message
	];

	$sql = "INSERT INTO `chat_messages` (`id`, `user_id`, `username`, `message`, `when`)
			VALUES (NULL, :userId, :username, :message, UNIX_TIMESTAMP());";

	$stmt = $pdo->prepare($sql)->execute($data);
}
else if($_SERVER["REQUEST_METHOD"] == "GET"){
	if($stmt = $pdo->prepare("SELECT `id`, `username`, `message`, `when` FROM `chat_messages` WHERE `id` > :lastMessageId ORDER BY `when` LIMIT 50")){
        $stmt->bindParam(":lastMessageId", $_SESSION["lastMessageId"], PDO::PARAM_INT);

        if($stmt->execute()){
        	$messages = $stmt->fetchAll();

        	for ($i = 0; $i < count($messages); $i++) {
        		$messages[$i]["when"] = date('m/d/Y G:i:s', $messages[$i]["when"]);
        		$messages[$i]["imgUrl"] = getUserImageUrl($messages[$i]["username"]);
        	}

        	if((count($messages) > 0) == true){
	        	$_SESSION["lastMessageId"] = end($messages)["id"];

	        	echo json_encode($messages);
        	}
        }
	}
}
?>