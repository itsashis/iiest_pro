<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: *');
header('Access-Control-Max-Age: 3600');
header('Access-Control-Allow-Headers: X-Requested-With, Content-Type, Origin, Authorization, Accept, Client-Security-Token, Accept-Encoding');
include_once'config/database.php';
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// instantiate user object
$var = new createEvent($db);

//getting database connection
$data = json_decode(file_get_contents("php://input"));

$var->title = $data->title;
$var->start_date = $data->start_date;
$var->end_date = $data->end_date;
$var->venue = $data->venue;
$var->lat = $data->lat;
$var->lng = $data->lng;
//$var->event_type = $data->event_type;
$var->created_by = $data->created_by;
echo $var->title ;
$var->event();

class createEvent
{
	private $status = 0;
	//$status = 0; 
	    // constructor
    public function __construct($db){
        $this->conn = $db;
    }

    public function event()
    {
    	$sql = "INSERT INTO events (event_id, title, start_date,end_date,venue,lat,lng,event_reach_id,created_by,	event_status) VALUES (NUll,:title,:start_date,:end_date,:venue,:lat,:lng,:event_reach_id,:created_by,:status)";


    		$stmt = $this->conn->prepare($sql);
    		$stmt->bindParam(':title', $this->title);
			$stmt->bindParam(':start_date', $this->start_date);
			$stmt->bindParam(':end_date', $this->end_date);
			$stmt->bindParam(':venue', $this->venue);

			$stmt->bindParam(':lat', $this->lat);
			$stmt->bindParam(':lng', $this->lng);
			//$stmt->bindParam(':event_reach_id', $this->event_reach_id);
			$stmt->bindParam(':created_by', $this->created_by);
			//$num = $stmt->rowCount();
			//$stmt= $this->conn->prepare($sql);
			if($stmt->execute()){
    			//echo json_encode(array("message" => "Successfully Created event."));
    		    $res = [ 'code' => 0,'result'=> []  ,'msg' => 'Successfully Event added' ];
    			echo json_encode($res);
			//echo "Successfully updated Profile";
			}// End of if profile is ok 
			else{
			//print_r($sql->errorInfo()); // if any error is there it will be posted
			//$msg=" Database problem, please contact site admin ";
				//echo json_encode(array("message" => "failed to create event."));
				    $res = [ 'code' => 1,'result'=> []  ,'msg' => 'Event is not added ' ];
    				echo json_encode($res);
			}
    }
}