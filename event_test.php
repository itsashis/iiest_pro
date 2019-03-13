<?php



header("Access-Control-Allow-Origin:*");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once 'config/db_connection.php';
/*

$email = $_POST["email"];
$fname = $_POST['firstname'];
$lname = $_POST['lastname'];
$password = $_POST['password'];
$passout_year = $_POST['passout_year'];
$current_location = $_POST['current_location'];
$address = $_POST['address'];
$phn_number = $_POST['phn_number'];
$salt = $_POST['salt'];
$user_type = $_POST['user_type'];
*/
/*	 $host = "localhost";
     $db_name = "iiest_db";
     $username = "root";
     $password = "";*/
   // $conn;

// Create connection
//$conn = mysqli_connect($host, $username, $password, $db_name);
// Check connection
/*if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}*/

$data = json_decode(file_get_contents("php://input"));
 
// set product property values
//$user->id = $data->id;
$created_by = $data->created_by;
$end_date = $data->end_date;
$event_type = $data->event_type;
$start_date = $data->start_date;
$title = $data->title;
$venue = $data->venue;
//$location = $data->location



$event_status = 0;
//echo $created_by;
//echo $event_type;

//$pass = md5($password);



$sql1 = $db_con->prepare("SELECT chapter_id FROM event_reach WHERE event_type=:event_type");
            $sql1->execute(array(":event_type"=>$event_type));
//$row = mysql_fetch_array($result, MYSQL_ASSOC);
$res = $sql1 -> fetch();

$event_reach_id = $res['chapter_id'];

//echo $event_reach_id;



//echo $event_status;
/*
$sql = "INSERT INTO events (event_id, tittle, start_date,end_date,venue,lat,lng,event_reach_id,created_by,	event_status)
VALUES ('NULL', '$title', '$start_date', '$end_date', '$venue', '$lat','$lng','$event_reach_id','$created_by', 0)";

if (mysqli_query($conn, $sql)) {
    echo json_encode(array("message" => " Event was created successfully."));
} else {
    echo json_encode(array("message" => "Unable to create user."));
}
*/
$sq=$db_con->prepare( "SELECT user_type FROM user WHERE id= :created_by");
$sq->execute(array(":created_by"=>$created_by));
//$user = $rst->fetch();
$rest = $sq -> fetch();
	//echo $row['chapter_id'];	
	$user_type = $rest['user_type'];
   // echo $user_type;


			if($user_type == "admin")
			{
				$stmt = $db_con->prepare("INSERT INTO events(event_id, tittle, start_date,end_date,venue,event_reach_id,created_by,	event_status) 
                VALUES(NULL, :title, :start_date, :end_date, :venue, :event_reach_id,:created_by, 1)");
                $stmt->bindParam(":title",$title);
                $stmt->bindParam(":start_date",$start_date);
                $stmt->bindParam(":end_date",$end_date);
                $stmt->bindParam(":venue",$venue);
           
                $stmt->bindParam(":event_reach_id",$event_reach_id);
                $stmt->bindParam(":created_by",$created_by);                             
               

				if ($stmt->execute()) {
				    //echo json_encode(array("message" => " Event was created successfully by Admin."));
				 $res = [ 'code' => 0, 'result' => [], 'msg' => 'Event Successfully Created by Admin' ];
                            echo json_encode($res);
				}
				 else {		
				     $res = [ 'code' => 1, 'result' => [], 'msg' => 'Unable to create Event by Admin' ];
                            echo json_encode($res);
					}
			}else{
				$s = $db_con->prepare("INSERT INTO events(event_id, tittle, start_date,end_date,venue,event_reach_id,created_by,	event_status) 
                VALUES(NULL, :title, :start_date, :end_date, :venue, :event_reach_id,:created_by, 0)");
      			$s->bindParam(":title",$title);
                $s->bindParam(":start_date",$start_date);
                $s->bindParam(":end_date",$end_date);
                $s->bindParam(":venue",$venue);
        
                $s->bindParam(":event_reach_id",$event_reach_id);
                $s->bindParam(":created_by",$created_by);

				if ($s->execute()) {
				     $res = [ 'code' => 3, 'result' => [], 'msg' => 'Event Successfully Created by other user' ];
                            echo json_encode($res);
				}
				 else {
				     	 $res = [ 'code' => 4, 'result' => [], 'msg' => 'Unable to  Created Event by other user' ];
                            echo json_encode($res);
					}
				}




?>
