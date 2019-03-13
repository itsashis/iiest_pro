<?php
// required headers

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: *');
header('Access-Control-Max-Age: 3600');
header('Access-Control-Allow-Headers: X-Requested-With, Content-Type, Origin, Authorization, Accept, Client-Security-Token, Accept-Encoding');
// database connection will be here
// files needed to connect to database
include_once 'config/db_connection.php';
//include_once 'objects/user.php';
 
$data = json_decode(file_get_contents("php://input"));
 

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
$pass = md5($password);
$user_type = $data->user_type;


try
        {   
            $stmt = $db_con->prepare("SELECT * FROM user WHERE email=:email");
            $stmt->execute(array(":email"=>$email));
            $count = $stmt->rowCount();
            echo $count;
            if($count==0)
                {
                $stmt = $db_con->prepare("INSERT INTO user(id,email,fname,lname,password,passout_year,
                current_location,address,phn_number,salt,user_type) 
                VALUES(NUll,:email,:fname,:lname,:password ,:passout_year, :current_location, :address, 
                :phone_number, :salt, :user_type)");
                $stmt->bindParam(":email",$email);
                $stmt->bindParam(":fname",$fname);
                $stmt->bindParam(":lname",$lname);
                $stmt->bindParam(":password",$pass);
                $stmt->bindParam(":passout_year",$passout_year);
                $stmt->bindParam(":current_location",$current_location);
                $stmt->bindParam(":address",$address);
                $stmt->bindParam(":phone_number",$phone);                             
                $stmt->bindParam(":salt",$salt);
                $stmt->bindParam(":user_type",$user_type);
                    if($stmt->execute())
                        {
                            echo "User was registered.";

                            // $dbdata = array();
                            //Fetch into associative array
                               /* while ( $row = $stmt->fetch(PDO::FETCH_OBJ) )  {
                               // $dbdata[]=$row;
                                }*/
                            
                            //Print array in JSON format
                            $res = [ 'code' => 0,'result'=>[]  'msg' => 'Successfully User registered' ];
                            echo json_encode($res);
                        }
                    else
                        {
                            $res = [ 'code' => 3,  'msg' => $db_con->errorInfo() ];
                            echo json_encode($res);
                        }
                }
            else
                {
                echo "1"; //  not available
                }
        }
        catch(PDOException $e){
            echo $e->getMessage();
        }
 


?>