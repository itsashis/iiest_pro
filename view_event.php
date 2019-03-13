<?php

header("Access-Control-Allow-Origin:*");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once 'config/db_connection.php';



$sql = $db_con->prepare("SELECT * FROM events ");

if($sql->execute()){


 	$dbdata = array();
                          
                            //Fetch into associative array
       while ( $row = $sql->fetch(PDO::FETCH_OBJ) )  {
                $dbdata[]=$row;
                }

              $res = [ 'code' => 0, 'result' => $dbdata, 'msg' => 'Event details shown' ];
               echo json_encode($res);

     }
     else{
     	      $res = [ 'code' =>1 , 'result' => [], 'msg' => 'There are no data' ];
              echo json_encode($res);
     }


?>