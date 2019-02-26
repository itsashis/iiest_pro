<?php
//required headers

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Max-Age: 3600');
header('Access-Control-Allow-Headers: X-Requested-With, Content-Type, Origin, Authorization, Accept, Client-Security-Token, Accept-Encoding');



// files needed to connect to database
include_once 'config/database.php';
include_once 'objects/user.php';
 
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// instantiate user object
$user = new User($db);
 
// get posted data
$data = json_decode(file_get_contents("php://input"));
 
// set product property values
$user->email = $data->email;
//$db->password = $data->password;
$email_exists = $user->emailExists();
 include_once 'jwt.php';
 include_once 'constant.php';

           
// check if email exists and if password is correct
if($email_exists ){
 
    $token = array(
       'iss' => 'localhost',
       'iat' => time(),
       'exp' => time() +(2*60),
       "data" => array(
           "id" => $user->id,
           "fname" => $user->fname,
           "lname" => $user->lname,
           "email" => $user->email,
           "pass" =>  $user->password,
           "role" =>  $user->role
       )
    );
 
    // set response code
    http_response_code(200);
 
    // generate jwt
    $jwt = JWT::encode($token, SECRETE_KEY);
    echo json_encode(
            array(
                $jwt
            )
        );
 
}
 
// login failed will be here

// login failed
else{
 
    // set response code
   http_response_code(401);
 
    // tell the user login failed
    echo json_encode(array("message" => "Login failed."));
}
?>