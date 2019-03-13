<?php

//this file to show all members who applied
include_once 'headers.php';
include_once 'config/db_connection.php';
//decode data fromjson
$data = json_decode(file_get_contents("php://input"));

$id = $data;
if($id != NULL){
	try{
		$stmt=$db_con->prepare("UPDATE members SET status = 1 WHERE mem_id=:id");

		$stmt->execute(array(":id"=>$id));
		$count = $stmt->rowCount();
		if($count== 1){
			$res = [ 'code' => 1, 'result' => [], 'msg' => 'Member approved Successfully .' ];
                            echo json_encode($res);
		}else{
			$res = [ 'code' => 0, 'result' => [], 'msg' => 'Member is not approved Successfully.' ];
             echo json_encode($res);
		}
	}
	catch(PDOException $e){
			echo $e->getMessage();
		}


}else{
	$res = [ 'code' => 3, 'result' => [], 'msg' => 'Member is not approved Successfully.' ];
     echo json_encode($res);

}


?>