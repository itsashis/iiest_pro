<?php
//this file to show all members who applied
include_once 'headers.php';
include_once 'config/db_connection.php';

$sql = $db_con->prepare("SELECT * FROM user ");

if($sql->execute()){


 	$dbdata = array();
                          
                            //Fetch into associative array
       while ( $row = $sql->fetch(PDO::FETCH_OBJ) )  {
                $dbdata[]=$row;
                }

              $res = [ 'code' => 0, 'result' => $dbdata, 'msg' => 'User details shown' ];
               echo json_encode($res);

     }
     else{
     	      $res = [ 'code' =>1 , 'result' => [], 'msg' => 'There are no data' ];
              echo json_encode($res);
     }


?>