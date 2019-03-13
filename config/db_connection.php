
 <?php
	$db_host = "localhost";
	$db_name = "iiest_db";
	$db_user = "root";
	$db_pass = "";
	
	try{
		
		$db_con = new PDO("mysql:host={$db_host};dbname={$db_name}",$db_user,$db_pass);
        $db_con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        //echo "Database connected Sucessfully";
	}
	catch(PDOException $e){
		echo $e->getMessage();
	}
?>
