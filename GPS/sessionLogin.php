<?php

session_start();
$sessionLogin = $_SESSION["userLogin"];

 $username = $sessionLogin[0]['userid'];
 $password = $sessionLogin[0]['password'];


// Connect to mongo //
include 'workshopConnect.php';
	
// Search user //

$SearchUser=$people->find(array("userid"=>$username,"password"=>$password));
	if(count(iterator_to_array($SearchUser)) != 0){
		$no=0;
		foreach($SearchUser as $doc1){
			$Data[$no]['userid'] = $doc1['userid'];
			$Data[$no]['password'] = $doc1['password'];
			$Data[$no]['name'] = $doc1['name'];
			$Data[$no]['branch'] = $doc1['branch'];
			$Data[$no]['position'] = $doc1['position'];
		    $userid = $doc1['userid'];
			$branch = $doc1['branch'];
			$position = $doc1['position'];
			$no++;
		}
		
		if($userid == "admin"){
			$SearchStaff=$people->find(array("userid"=>array('$ne' => $userid))); //ดึงข้อมูลทั้งหมด
				foreach($SearchStaff as $doc2){
					$Data[$no]['userid'] = $doc2['userid'];
					$Data[$no]['password'] = $doc2['password'];
					$Data[$no]['name'] = $doc2['name'];
					$Data[$no]['branch'] = $doc2['branch'];
					$Data[$no]['position'] = $doc2['position'];
					$Data[$no]['head'] = $doc2['head'];
					$no++;
				}
			
		}else if($position == "MG"){
			if($branch == "UCC"){
				$SearchStaff=$people->find(array("userid"=>array('$ne' => $userid))); //ดึงข้อมูลทั้งหมด
				foreach($SearchStaff as $doc2){
					$Data[$no]['userid'] = $doc2['userid'];
					$Data[$no]['password'] = $doc2['password'];
					$Data[$no]['name'] = $doc2['name'];
					$Data[$no]['branch'] = $doc2['branch'];
					$Data[$no]['position'] = $doc2['position'];
					$Data[$no]['head'] = $doc2['head'];
					$no++;
				}
				
			}else{
				$SearchStaff=$people->find(array("branch"=>$branch,"position"=>array('$ne' => $position))); //ดึงข้อมูลทั้งหมด
					foreach($SearchStaff as $doc2){
						$Data[$no]['userid'] = $doc2['userid'];
						$Data[$no]['password'] = $doc2['password'];
						$Data[$no]['name'] = $doc2['name'];
						$Data[$no]['branch'] = $doc2['branch'];
						$Data[$no]['position'] = $doc2['position'];
						$Data[$no]['head'] = $doc2['head'];
						$no++;
					}		
			}
			
		}else{	
			$SearchStaff=$people->find(array("branch"=>$branch,"head"=>$position)); //ดึงข้อมูลทั้งหมด
				foreach($SearchStaff as $doc2){
					$Data[$no]['userid'] = $doc2['userid'];
					$Data[$no]['password'] = $doc2['password'];
					$Data[$no]['name'] = $doc2['name'];
					$Data[$no]['branch'] = $doc2['branch'];
					$Data[$no]['position'] = $doc2['position'];
					$Data[$no]['head'] = $doc2['head'];
					$no++;
				}
				
				
			}
		session_start();
		$_SESSION["userData"] = $Data;
	
		echo json_encode($Data);
		
	}

?>