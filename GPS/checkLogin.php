<?php

$username = $_POST["username"];
$password = $_POST["password"];

// Connect to mongo //
include 'workshopConnect.php';
	
// Search user //

$SearchUser=$people->find(array("userid"=>$username,"password"=>$password));
	if($SearchUser != null){
		$no=0;
		foreach($SearchUser as $doc1){
			$value[$no]['userid'] = $doc1['userid'];
			$value[$no]['password'] = $doc1['password'];
			$value[$no]['name'] = $doc1['name'];
			$value[$no]['branch'] = $doc1['branch'];
			$value[$no]['position'] = $doc1['position'];
			$userid = $doc1['userid'];
			$branch = $doc1['branch'];
			$position = $doc1['position'];
			$no++;
		}
		session_start();
		$_SESSION["userLogin"] = $value;
		
		echo json_encode($value);
	}


?>