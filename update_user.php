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
$user = new Update($db);

//getting database connection
$data = json_decode(file_get_contents("php://input"));

$user->email = $data->email;
$user->id = $data->id;
$user->fname = $data->fname;
$user->lname = $data->lname;
$user->password = $data->password;
$user->passout_year = $data->passout_year;
$user->current_location = $data->current_location;
$user->address = $data->address;
$user->phone = $data->phone;
$user->salt = $data->salt;
$user->user_type = $data->user_type;
$user->editUser();
/*
 $email = $data->email;
 $id = $data->id;
 $fname = $data->fname;
 $lname = $data->lname;
 $password = $data->password;
 $passout_year = $data->passout_year;
 $current_location = $data->current_location;
 $address = $data->address;
 $phone = $data->phone;
 $salt = $data->salt;
 $user_type = $data->user_type;*/

class Update
{
	    // constructor
    public function __construct($db){
        $this->conn = $db;
    }

    public function editUser(){

    	$sql=$this->conn->prepare('UPDATE user set email=:email, fname=:fname, lname=:lname, password=:password1, passout_year=:passout_year, current_location=:current_location, address=:address, phn_number=:phone, salt=:salt,user_type=:user_type where id=:id');
    		//$stmt = $this->dbConn->prepare($sql);
    		//$sql->bindParam(':id', $this->id);
    		$sql->bindParam(':fname', $this->fname);
			$sql->bindParam(':email', $this->email);
			$sql->bindParam(':lname', $this->lname);
			$pass = password_hash($this->password, PASSWORD_BCRYPT);
			$sql->bindParam(':password1', $this->pass);

			$sql->bindParam(':passout_year', $this->passout_year);
			$sql->bindParam(':current_location', $this->current_location);
			$sql->bindParam(':phone', $this->phone);
			$sql->bindParam(':address', $this->address);
			$sql->bindParam(':salt', $this->salt);
			$sql->bindParam(':user_type', $this->user_type);
    	if($sql->execute()){
    		echo json_encode(array("message" => "Successfully updated Profile."));
			//echo "Successfully updated Profile";
			}// End of if profile is ok 
			else{
			//print_r($sql->errorInfo()); // if any error is there it will be posted
			//$msg=" Database problem, please contact site admin ";
				echo json_encode(array("message" => "Update failed."));
			}
    }

}

?>