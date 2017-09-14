<?php

$userid = $_POST["DataUserID"];
$password = $_POST["DataPassword"];
$name = $_POST["DataName"];
$branch = $_POST["DataBranch"];
$position = $_POST["DataPosition"];
$head = $_POST["DataHead"];

// Connect to mongo //
include 'workshopConnect.php';
	
$people->update(array("userid"=>$userid),
array("userid"=>$userid,"password"=>$password,"name"=>$name,"branch"=>$branch,"position"=>$position,"head"=>$head));
echo "OK";


?>