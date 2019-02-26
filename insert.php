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
$email = $data->email;
$fname = $data->firstname;
$lname = $data->lastname;
$password = $data->password;
$passout_year = $data->passout_year;
$current_location = $data->current_location;
$address = $data->address;
$phone = $data->phone;
$salt = $data->salt;
$user_type = $data->user_type;

$pass = md5($password);



$sql = "INSERT INTO user (id, email,lname, fname, password, passout_year, current_location, address, phn_number,salt, user_type)
VALUES ('NULL', '$email', '$fname', '$lname', '$pass', '$passout_year','$current_location','$address','$phone','$salt','$user_type')";

if (mysqli_query($conn, $sql)) {
    echo json_encode(array("message" => "User is created."));
} else {
    echo json_encode(array("message" => "Unable to create user."));
}


?>
