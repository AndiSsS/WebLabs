<?php require("resources/templates/header.php"); ?>
<body>
<?php 
//error_reporting(0);

require("resources/config.php");
require('resources/library/helpers.php');

session_start();

if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true)
	include("resources/library/chat.php");
else
	header("location: login.php");

?>

</body>
</html>