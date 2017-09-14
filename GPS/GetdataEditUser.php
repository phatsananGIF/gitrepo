<?php

$userid = $_POST["userID"];

// Connect to mongo //
include 'workshopConnect.php';
	
// Search user //
	$SearchUser=$people->find(array("userid"=>$userid));
	
	foreach($SearchUser as $doc){
		$Data['userid'] = $doc['userid'];
		$Data['password'] = $doc['password'];
		$Data['name'] = $doc['name'];
		$Data['branch'] = $doc['branch'];
		$Data['position'] = $doc['position'];
		$Data['head'] = $doc['head'];
		
	}
echo json_encode($Data);
?>