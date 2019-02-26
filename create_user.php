<?php
// required headers
header("Access-Control-Allow-Origin: http://localhost/rest-api-authentication-example/");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
// database connection will be here
// files needed to connect to database
include_once 'config/database.php';
//include_once 'objects/user.php';
 
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// instantiate product object
//$user = new User($db);
 
// submitted data will be here
// get posted data
$data = json_decode(file_get_contents("php://input"));
 
// set product property values
//$user->id = $data->id;
$user->email = $data->email;
$user->fname = $data->firstname;
$user->lname = $data->lastname;
$user->password = $data->password;
$user->passout_year = $data->passout_year;
$user->current_location = $data->current_location;
$user->address = $data->address;
$user->phone = $data->phone;
$user->salt = $data->salt;
$user->user_type = $data->user_type;

 
// use the create() method here
class User{
	private $conn;
    private $table_name = "user";
 
    // object properties
    
    public $id;
    public $email;
    public $firstname;
    public $lastname;
    public $password;
    public $passout_year;
    public $current_location;
    public $address;
    public $phone;
    public $salt;
    public $user_type;
    //public $password_hash;
 
    // constructor
    public function __construct($db){
        $this->conn = $db;
    }
 function create() {
            
            $query = 'INSERT INTO ' . $this->table_name . '(id, email,fname, lname, password, passout_year, current_location, address, phn_number, salt, user_type) VALUES(null,:email,:fname, :lname, :password, :passout_year,:current_location, :address, :phn_number, :salt, :user_type)';

            $stmt = $this->conn->prepare($query);
 
    // sanitize
     //$this->id=htmlspecialchars(strip_tags($this->id));
    $this->email=htmlspecialchars(strip_tags($this->email));
    $this->fname=htmlspecialchars(strip_tags($this->fname));
    $this->lname=htmlspecialchars(strip_tags($this->lname));    
    $this->password=htmlspecialchars(strip_tags($this->password));
    $this->passout_year=htmlspecialchars(strip_tags($this->passout_year));
    $this->current_location=htmlspecialchars(strip_tags($this->current_location));
    $this->address=htmlspecialchars(strip_tags($this->address));
    $this->phone=htmlspecialchars(strip_tags($this->phone));
    $this->salt=htmlspecialchars(strip_tags($this->salt));
    $this->user_type=htmlspecialchars(strip_tags($this->user_type));

           // $stmt = $this->dbConn->prepare($sql);
            $stmt->bindParam(':email', $this->email);
            $stmt->bindParam(':fname', $this->fname);
            $stmt->bindParam(':lname', $this->lname);
            $stmt->bindParam(':password', $this->password);
            $stmt->bindParam(':passout_year', $this->passout_year);
            $stmt->bindParam(':current_location', $this->current_location);
            $stmt->bindParam(':address', $this->address);
            $stmt->bindParam(':phn_number', $this->phn_number);
            $stmt->bindParam(':salt', $this->salt);
            $stmt->bindParam(':user_type', $this->user_type);
            
            if($stmt->execute()) {
                return true;
            } else {
                return false;
            }
        }
   }
// create the user
if($user->create()){
 
    // set response code
    http_response_code(200);
     //echo $table_name;
 
    // display message: user was created
    echo json_encode(array("message" => "User was created."));
}
 
// message if unable to create user
else{
 
    // set response code
    http_response_code(400);
 
    // display message: unable to create user
    echo json_encode(array("message" => "Unable to create user."));
}
?>