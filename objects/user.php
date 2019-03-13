<?php
// 'user' object
class User{
 
    // database connection and table name
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

// create() method here



        function emailExists(){
        
                        // query to check if email exists
                $query = "SELECT id, fname, lname, password,user_type
                        FROM " . $this->table_name . "
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
    }