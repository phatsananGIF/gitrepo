<?php
session_start();
$sessionLogin = $_SESSION["userData"];

include 'workshopConnect.php';
$CountArray=count($sessionLogin);
for($no=0;$no<$CountArray;$no++){
	 $Data[$no]['userid'] = $sessionLogin[$no]['userid'];
	 $Data[$no]['name'] = $sessionLogin[$no]['name'];
		
	$cursor=$LocationOnline->find(array("userid"=>($Data[$no]['userid'])));	
		if( count(iterator_to_array($cursor))!=0){
			foreach($cursor as $docvalue){	
				$Data[$no]['lat'] = $docvalue['latitude'];
				$Data[$no]['lng'] = $docvalue['longitude'];
				$Data[$no]['location'] = $docvalue['location'];
				$Data[$no]['date'] = $docvalue['date'];	
			}
		}

}
	// echo "<pre>";
	// var_dump($Data);
	// echo "</pre>";
	
echo json_encode($Data);


?>
