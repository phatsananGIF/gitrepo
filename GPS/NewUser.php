<?php

$userid = $_POST["DataUserID"];
$password = $_POST["DataPassword"];
$name = $_POST["DataName"];
$branch = $_POST["DataBranch"];
$position = $_POST["DataPosition"];
$head = $_POST["DataHead"];

// Connect to mongo //
include 'workshopConnect.php';
	
// Search user //
	$SearchUser=$people->find(array("userid"=>$userid));
	
	if(count(iterator_to_array($SearchUser)) == 0){
		$people->insert(array("userid"=>$userid,"password"=>$password,"name"=>$name,"branch"=>$branch,"position"=>$position,"head"=>$head)); //บรรนทึกข้อมูล
		echo "OK";
	}else{
		echo "have user";
	}

?>