<?php
session_start();
$userid = $_POST["SelectUserVal"];
 $sendStart = (date("Y/m/d")." 00:00:00");
 $sendEnd = (date("Y/m/d")." 24:59:59");

include 'workshopConnect.php';
		
	$cursor=$LocationOnline->find(array("userid"=>$userid,"date"=>array('$gte' => $sendStart , '$lte' => $sendEnd)));
		if( count(iterator_to_array($cursor))!=0){
			$no=0;
			foreach($cursor as $docvalue){
				$Data[$no]['userid'] = $docvalue['userid'];
				$Data[$no]['lat'] = $docvalue['latitude'];
				$Data[$no]['lng'] = $docvalue['longitude'];
				$Data[$no]['location'] = $docvalue['location'];
				$Data[$no]['date'] = $docvalue['date'];
				$Data[$no]['time'] = $docvalue['time'];		
				$no++;
			}
		}

	// echo "<pre>";
	// var_dump($Data);
	// echo "</pre>";
	
echo json_encode($Data);


?>
