<?php
include 'workshopConnect.php';

$dataUser = ($_POST["dataUser"]);
$sendStart = ($_POST["sendStart"]." 00:00:00");
$sendEnd = ($_POST["sendEnd"]." 24:59:59");

/*
$sendStart = ("2017/03/01 00:00:00");
$sendEnd = ("2017/03/30 24:59:59");
$dataUser = array("000000","444444");
*/

$no=0;
for($i=0; $i<count($dataUser);$i++){
	$SearchCheck=$CheckIn->find(array("userid"=>$_POST["dataUser"][$i],"dateCheckIn"=>array('$gte' => $sendStart , '$lte' => $sendEnd)));
	foreach($SearchCheck as $doc){
		$Data[$no]['userid'] = $doc["userid"];
		$Data[$no]['name'] = $doc["name"];
		$Data[$no]['customer'] = $doc["customer"];
		$Data[$no]['latitudeCheckIn'] = $doc["latitudeCheckIn"];
		$Data[$no]['longitudeCheckIn'] = $doc["longitudeCheckIn"];
		$Data[$no]['locationCheckIn'] = $doc["locationCheckIn"];
		$Data[$no]['dateCheckIn'] = $doc["dateCheckIn"];
		$Data[$no]['latitudeCheckOut'] = $doc["latitudeCheckOut"];
		$Data[$no]['longitudeCheckOut'] = $doc["longitudeCheckOut"];
		$Data[$no]['locationCheckOut'] = $doc["locationCheckOut"];
		$Data[$no]['dateCheckOut'] = $doc["dateCheckOut"];
		$Data[$no]['OperatingTime'] = $doc["Operating time"];
		
		$no++;
	}
}
	// echo "<pre>";
	// var_dump($Data);
	// echo "</pre>";
//sleep(10);
echo json_encode($Data);


?>