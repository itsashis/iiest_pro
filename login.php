<?php
//required headers


header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: *');
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
$user->password = $data->password;
$email_exists = $user->emailExists();
 include_once 'jwt.php';
 include_once 'constant.php';

           // emailExists() method will be here
            function emailExists(){
        
                        // query to check if email exists
                $query = "SELECT id, fname, lname, password,role
                        FROM user
                        WHERE email = ?
                        LIMIT 0,1";
             
                // prepare the query
                $stmt = $this->conn->prepare( $query );
             
                // sanitize
                $this->email=htmlspecialchars(strip_tags($this->email));
                $this->password =htmlspecialchars(strip_tags($this->password));
                // bind given email value
                $stmt->bindParam(1, $this->email);
             
                // execute the query
                $stmt->execute();
             
                // get number of rows
                $num = $stmt->rowCount();

     
             
                // if email exists, assign values to object properties for easy access and use for php sessions
                if($num>0){
             
                    // get record details / values
                    $row = $stmt->fetch(PDO::FETCH_ASSOC);
             
                    // assign values to object properties
                    $this->id = $row['id'];
                    $this->fname = $row['fname'];
                    $this->lname = $row['lname'];
                    $this->password = $row['password'];
                    $this->user_type = $row['user_type'];
             
                    // return true because email exists in the database
                    return true;
                }
             
                // return false if email does not exist in the database
                return false;
            }
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
                       "user_type" =>  $user->user_type
                   )
                );
 
 
 
    // generate jwt
    $jwt = JWT::encode($token, SECRETE_KEY);

    $res = [ 'code' => 1,'Token'=> $jwt  ,'msg' => 'Successfully User Loged in' ];
    echo json_encode($res);
 
}
 

else{
 
  
  // http_response_code(401);
 
    // tell the user login failed
  $res = [ 'code' => 3,'result'=> []  ,'msg' => ' User is no loged in.' ];
  echo json_encode($res);
}
?>