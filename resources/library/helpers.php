<?php 

function getUserColor($username){
	$colorGreen = "80D39B";
	$colorBlue = "55C1E7";

	if($username == $_SESSION["username"])
		return $colorGreen;
	else return $colorBlue;
}

function getFirstLettersOfName($username){
	$partsOfName = explode(" ", $username, 2);
	$firstLettersOfName = strtoupper($partsOfName[0][0]);

	if(count($partsOfName) > 1)
		$firstLettersOfName .= " " . strtoupper($partsOfName[1][0]);

	return $firstLettersOfName;
}

function getUserImageUrl($username){
	return "http://placehold.it/50/".getUserColor($username)."/fff&text=".getFirstLettersOfName($username);
}

?>