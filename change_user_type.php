<?php

include_once'config/database.php';
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// instantiate user object
$var = new ChaneUserType($db);

$data = json_decode(file_get_contents("php://input"));


$var->id = $data->id;
$var->newuser = $data->newuser;
$var->olduser = $data->olduser;
echo $var->olduser;
$var->change();

/**
 * 
 */
class ChaneUserType
{
	
		    // constructor
    public function __construct($db){
        $this->conn = $db;
    }

    public function change(){
    	try{
    	$sql=$this->conn->prepare('UPDATE user set user_type=:newuser where id=:id AND user_type=:olduser');
    	$sql->bindParam(':id', $this->id);
    	$sql->bindParam(':newuser', $this->newuser);
    	$sql->bindParam(':olduser', $this->olduser);

    	    $sql->execute();
    			echo json_encode(array("message" => "Successfully updated User Type."));
			//echo "Successfully updated Profile";
			}// End of if profile is ok 
			catch(PDOException $e){
			print_r($sql->errorInfo()); // if any error is there it will be posted
			//$msg=" Database problem, please contact site admin ";
				echo json_encode(array("message" => "Failed to updated User Type."));
			}

    }
}


?>