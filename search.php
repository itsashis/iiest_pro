<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
// database connection will be here
// files needed to connect to database
include_once 'config/db_connection.php';
//include_once 'objects/user.php';
 
$data = json_decode(file_get_contents("php://input"));
$fname = $data->fname;
$passout_year=$data->passout_year;
$user_type= $data->user_type;
echo $passout_year;

if($fname == NULL && $passout_year == NULL && $user_type == NULL)
{//this is for showing all data
 $stmt = $db_con->prepare("SELECT * FROM user ");
            $stmt->execute();

		if($stmt->execute()){


		 	$dbdata = array();
		                          
		                            //Fetch into associative array
		       while ( $row = $stmt->fetch(PDO::FETCH_OBJ) )  {
		                $dbdata[]=$row;
		                }

		              $res = [ 'code' => 0, 'result' => $dbdata, 'msg' => 'Sucessfully Got data ' ];
		               echo json_encode($res);

		     }
		     else{
		     	      $res = [ 'code' =>1 , 'result' => [], 'msg' => 'Not Got data Sucessfully' ];
		              echo json_encode($res);
		     }


//this is for showing data with first name
}elseif($fname !== NULL && $passout_year == NULL && $user_type == NULL)
	{
		$stmt = $db_con->prepare("SELECT * FROM user WHERE fname LIKE ? ");
            //$stmt->bindParam(':fname', $fname);
            $params = array("%$fname%");
           // $stmt->execute();
            if($stmt->execute($params)){


		 	$dbdata = array();
		                          
		                            //Fetch into associative array
		       while ( $row = $stmt->fetch(PDO::FETCH_OBJ) )  {
		                $dbdata[]=$row;
		                }

		              $res = [ 'code' => 2, 'result' => $dbdata, 'msg' => 'Sucessfully Got data with first name' ];
		               echo json_encode($res);

		     }
		     else{
		     	      $res = [ 'code' =>3 , 'result' => [], 'msg' => 'Not Sucessfully Got data with first name' ];
		              echo json_encode($res);
		     }




//this is for showing data with passout year
	}elseif($fname == NULL && $passout_year !== NULL && $user_type == NULL)
	{
			$stmt = $db_con->prepare("SELECT * FROM user WHERE passout_year LIKE ? ");
			 $params = array("%$passout_year%");
          //  $stmt->bindParam(':passout_year', $passout_year);
          //	$stmt->execute();
            if($stmt->execute($params)){
			 	$dbdata = array();
			                          
			                            //Fetch into associative array
			       while ( $row = $stmt->fetch(PDO::FETCH_OBJ) )  {
			                $dbdata[]=$row;
			                }

			              $res = [ 'code' => 4, 'result' => $dbdata, 'msg' => 'Sucessfully Got data with passout_year' ];
			               echo json_encode($res);

			     }
			     else{
			     	      $res = [ 'code' =>5 , 'result' => [], 'msg' => 'Not Sucessfully Got data with passout_year' ];
			              echo json_encode($res);
			     }




//showing data for user type
	}elseif($fname == NULL && $passout_year == NULL && $user_type !== NULL)
		{

			$stmt = $db_con->prepare("SELECT * FROM user WHERE user_type LIKE ? ");
			 $params = array("%$passout_year%");
            //$stmt->bindParam(':user_type', $user_type);
            if($stmt->execute($params)){
			 	$dbdata = array();
			                          
			                            //Fetch into associative array
			       while ( $row = $stmt->fetch(PDO::FETCH_OBJ) )  {
			                $dbdata[]=$row;
			                }

			              $res = [ 'code' => 6, 'result' => $dbdata, 'msg' => 'Sucessfully Got data with user type' ];
			               echo json_encode($res);

			     }
			     else{
			     	      $res = [ 'code' =>7 , 'result' => [], 'msg' => 'Not Sucessfully Got data with user type' ];
			              echo json_encode($res);
			     }
		}






?>