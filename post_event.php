<?php



header("Access-Control-Allow-Origin: http://localhost/rest-api-authentication-example/");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once 'config/database.php';
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
	 $host = "localhost";
     $db_name = "iiest_db";
     $username = "root";
     $password = "";
   // $conn;

// Create connection
$conn = mysqli_connect($host, $username, $password, $db_name);
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
$data = json_decode(file_get_contents("php://input"));
 
// set product property values
//$user->id = $data->id;
$title = $data->title;
$start_date = $data->start_date;
$end_date = $data->end_date;
$venue = $data->venue;
$lat = $data->lat;
$lng = $data->lng;
$event_type = $data->event_type;
$created_by = $data->created_by;
$event_status = 0;
//echo $event_type ;

//$pass = md5($password);

$sql1= "SELECT chapter_id FROM event_reach WHERE event_type= '$event_type'";
$result = $conn->query($sql1);
//$row = mysql_fetch_array($result, MYSQL_ASSOC);
while($row = $result->fetch_assoc()){
	//echo $row['chapter_id'];	
	$event_reach_id = $row['chapter_id'];
}

//$event_reach_id = $row['chapter_id'];

echo $event_reach_id;



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
$sq= "SELECT user_type FROM user WHERE id= '$created_by'";
$result = $conn->query($sq);
while($row1 = $result->fetch_assoc()){
	//echo $row['chapter_id'];	
	$user_type = $row1['user_type'];

	echo $user_type;

			if($user_type == "admin")
			{
						$sql = "INSERT INTO events (event_id, tittle, start_date,end_date,venue,lat,lng,event_reach_id,created_by,	event_status)
				VALUES ('NULL', '$title', '$start_date', '$end_date', '$venue', '$lat','$lng','$event_reach_id','$created_by', 1)";

				if (mysqli_query($conn, $sql)) {
				    echo json_encode(array("message" => " Event was created successfully by Admin."));
				}
				 else {
				    echo json_encode(array("message" => "Unable to create user by Admin."));
					}
			}else{
						$s = "INSERT INTO events (event_id, tittle, start_date,end_date,venue,lat,lng,event_reach_id,created_by,	event_status)
				VALUES ('NULL', '$title', '$start_date', '$end_date', '$venue', '$lat','$lng','$event_reach_id','$created_by', 0)";

				if (mysqli_query($conn, $s)) {
				    echo json_encode(array("message" => " Event was created successfully by other usser."));
				}
				 else {
				    echo json_encode(array("message" => "Unable to create user by other user."));
					}
				}


}


?>
