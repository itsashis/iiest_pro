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
$var = new ChaneUserType($db);

$data = json_decode(file_get_contents("php://input"));


$var->id = $data->id;
$var->newuser = $data->newuser;
$var->olduser = $data->olduser;
//echo $var->olduser;
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

    public function change()
    {
    	try{
    		$smt=$this->conn->prepare('SELECT * FROM user WHERE id =:id');
    		$smt->execute(array(":id"=>$this->id));
    		$count=$smt->rowCount();
    		//echo $count;
    		if($count == 1){
    	$sql=$this->conn->prepare('UPDATE user set user_type=:newuser where id=:id AND user_type=:olduser');
    	$sql->bindParam(':id', $this->id);
    	$sql->bindParam(':newuser', $this->newuser);
    	$sql->bindParam(':olduser', $this->olduser);


    	    $sql->execute();
    			//echo json_encode(array("message" => "Successfully updated User Type."));
			//echo "Successfully updated Profile";
			// End of if profile is ok 

			 //Initialize array variable
                            $dbdata = array();
                            //Fetch into associative array
                                while ( $row = $sql->fetch(PDO::FETCH_OBJ) )  {
                                $dbdata[]=$row;
                                }
                    $res = [ 'code' => 1, 'result' => $dbdata, 'msg' => 'Successfully User updated' ];
                            echo json_encode($res);

		}//end of if
		else{
			   $res = [ 'code' => 0, 'result' => [], 'msg' => 'User id is not found.' ];
                            echo json_encode($res);
		}

	}//try end
			catch(PDOException $e){
			print_r($sql->errorInfo()); // if any error is there it will be posted
			//$msg=" Database problem, please contact site admin ";
				echo json_encode(array("message" => $e->getMessage()));
			}

}//function end

}

    
