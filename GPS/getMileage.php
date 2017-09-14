<?php
include 'workshopConnect.php';

$dataUser = ($_POST["dataUser"]);
$sendStart = ($_POST["sendStartML"]." 00:00:00");
$sendEnd = ($_POST["sendEndML"]." 24:59:59");

/*
$sendStart = ("2017/03/01 00:00:00");
$sendEnd = ("2017/04/30 24:59:59");
$dataUser = array("543234","590131");
*/

$no=0;
for($i=0; $i<count($dataUser);$i++){
	$SearchTimeAttendance=$Mileage->find(array("userid"=>$_POST["dataUser"][$i],"startTime"=>array('$gte' => $sendStart , '$lte' => $sendEnd)));
	foreach($SearchTimeAttendance as $doc){
		$Data[$no]['userid'] = $doc["userid"];
		$Data[$no]['name'] = $doc["name"];
		$Data[$no]['startTime'] = $doc["startTime"];
		$Data[$no]['locationStartTime'] = $doc["locationStartTime"];
		$Data[$no]['endTime'] = $doc["endTime"];
		$Data[$no]['locationEndTime'] = $doc["locationEndTime"];
		$Data[$no]['timeTravel'] = $doc["timeTravel"];
		$Data[$no]['mileage'] = $doc["mileage"];

		$no++;
	}
}
	// echo "<pre>";
	// var_dump($Data);
	// echo "</pre>";
//sleep(10);
echo json_encode($Data);


?>