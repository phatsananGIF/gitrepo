<?php

$connection=new MongoClient();
$db=$connection->Workshop;
$people=$db->people;
$LocationOnline=$db->LocationOnline;
$CheckIn=$db->CheckIn;
$TimeAttendance=$db->TimeAttendance;
$Mileage=$db->Mileage;
$DeleteUser=$db->DeleteUser;


?>