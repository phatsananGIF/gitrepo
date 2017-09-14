<?php
echo $userid = $_GET["userid"];
echo "<br><br>";
// Connect to mongo //
include 'workshopConnect.php';

session_start();
$sessionLogin = $_SESSION["userLogin"];
$userDelete = $sessionLogin[0]['userid'];
$userNameDelete = $sessionLogin[0]['name'];

$SearchUser = $people->find(array("userid"=>$_GET["userid"]));
	foreach($SearchUser as $docvalue){	
		$Name = $docvalue['name'];
		$Branch = $docvalue['branch'];
		$Position = $docvalue['position'];
		$EmployeeID = $docvalue['userid'];	
	}
echo $FullName = ($Name." /".$Branch."/".$Position."/".$EmployeeID);
echo "<br><br>";
date_default_timezone_set("ASIA/BANGKOK");
echo $DateTime = (date("Y/m/d H:i:s"));
echo "<br><br>";
if($userDelete == "admin"){
	$DeleteUser->insert(array("DeleteUser"=>$FullName,"DeleteBy"=>$userNameDelete,"Dete"=>$DateTime,"Note"=>"")); //บรรนทึกข้อมูล
		$people->remove(array("userid"=>($_GET['userid'])));
		header("location:/GPS/GPS.html#Usermanagement");	
}else{
	$DeleteUser->insert(array("DeleteUser"=>$FullName,"DeleteBy"=>$userNameDelete,"Dete"=>$DateTime,"Note"=>$userNameDelete." ต้องการลบ user นี้")); //บรรนทึกข้อมูล
		header("location:/GPS/GPS.html#Home");	
}
 



?>