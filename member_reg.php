<?php
// files needed to headers
include_once 'headers.php';
// files needed to connect to database
include_once 'config/db_connection.php';
//include_once 'objects/user.php';
 
$data = json_decode(file_get_contents("php://input"));
 

//$user->id = $data->id;
$email = $data->email;
//$user_name = $data->user_name;
$fname = $data->fname;
$lname = $data->lname;
//$password = $data->password;
$passout_year = $data->year_of_passing;
//$current_location = $data->current_location;
$address = $data->address;
$phone = $data->phone;
$chapter = $data->chapter;
//$status = $data->status;
//$pass = md5($password);
//$user_type = $data->user_type;


try
        {   
            $stmt = $db_con->prepare("SELECT * FROM Members WHERE email=:email");
            $stmt->execute(array(":email"=>$email));
            $count = $stmt->rowCount();
            //echo $count;
            if($count==0)
                {
                $stmt = $db_con->prepare("INSERT INTO Members(mem_id,email,fname,lname,passout_year,
                address,phone,status,chapter) 
                VALUES(NUll,:email,:fname,:lname ,:passout_year,  :address, 
                :phone_number,  0,:chapter)");
                $stmt->bindParam(":email",$email);
               // $stmt->bindParam(":user_name",$user_name);
                $stmt->bindParam(":fname",$fname);
                $stmt->bindParam(":lname",$lname);
               // $stmt->bindParam(":password",$pass);
                $stmt->bindParam(":passout_year",$passout_year);
              //  $stmt->bindParam(":current_location",$current_location);
                $stmt->bindParam(":address",$address);
                $stmt->bindParam(":phone_number",$phone);                             
                $stmt->bindParam(":chapter",$chapter);
                    if($stmt->execute())
                        {
                           // echo "User was registered.";

                            // $dbdata = array();
                            //Fetch into associative array
                               /* while ( $row = $stmt->fetch(PDO::FETCH_OBJ) )  {
                               // $dbdata[]=$row;
                                }*/
                            
                            //Print array in JSON format
                            $res = [ 'code' => 0,'result'=>[] , 'msg' => 'Successfully Member registered' ];
                            echo json_encode($res);
                        }
                    else
                        {
                            $res = [ 'code' => 3, 'result'=>[] , 'msg' => $db_con->errorInfo() ];
                            echo json_encode($res);
                        }
                }
            else
                {
                $res = [ 'code' => 1, 'result'=>[] , 'msg' => 'Email id already exist.' ];
                echo json_encode($res); //  not available
                }
        }
        catch(PDOException $e){
            echo $e->getMessage();
        }
 


?>