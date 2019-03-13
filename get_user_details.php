<?php
// required headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: GET');
header('Access-Control-Max-Age: 3600');
header('Access-Control-Allow-Headers: X-Requested-With, Content-Type, Origin, Authorization, Accept, Client-Security-Token, Accept-Encoding');

//required for connect db
//include_once 'config/database.php';
//include_once 'objects/user.php';
 


// retrieve gieve jwt here
 include_once 'jwt.php';
 include_once 'constant.php';

// files for decoding jwt will be here

// get posted data
//$payload = json_decode(file_get_contents("php://input"));
$token = $_GET["token"];
//$tok = $payload->token;
 //echo $token;

// decode jwt here

// if jwt is not empty
if($token){
 
    // if decode succeed, show user details
    try {
        // decode jwt
        //$decoded = JWT::decode($jwt, $key, array('HS256'));
        $decoded = JWT::decode($token, SECRETE_KEY, ['HS256']);
 
        // set response code

        
            $res = [ 'code' => 0,'result'=>$decoded->data  ,'msg' => 'Access granted' ];
            echo json_encode($res);
    }
 
    // catch will be here
		    catch (Exception $e){
		 

	
		    // tell the user access denied  & show error message

             $res = [ 'code' => 1,'result'=>[]  ,'msg' => 'Access denied' ];
            echo json_encode($res);
		}
}
 


// show error message if jwt is empty
else{
 
    $res = [ 'code' => 3,'result'=>[]  ,'msg' => 'Access denied token not found.' ];
     echo json_encode($res);
}
?>