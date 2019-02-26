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

// create() method will be here

    // create new user record
    /*
function create(){
 
    // insert query
    $query = "INSERT INTO " . $this->table_name . "
            SET
                id = :id,
                email = :email,
                fname = :fname,
                lname = :lname,
                password = :password,
                passout_year = :passout_year,
                current_location= :current_location,
                address = :address,
                phn_number = :phone,
                salt = :salt,
                user_type= :user_type";
 
    // prepare the query
    $stmt = $this->conn->prepare($query);
 
    // sanitize
     $this->id=htmlspecialchars(strip_tags($this->id));
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
 
    // bind the values
    $stmt->bindParam(':id', $this->id);
    $stmt->bindParam(':fname', $this->fname);
    $stmt->bindParam(':lname', $this->lname);
    $stmt->bindParam(':email', $this->email);
 
    // hash the password before saving to database
   // $password_hash = password_hash($this->password, PASSWORD_BCRYPT);
   // $stmt->bindParam(':password', $password_hash);
    $stmt->bindParam(':password', $password);
    $stmt->bindParam(':passout_year', $this->passout_year);
    $stmt->bindParam(':current_location', $this->current_location);
    $stmt->bindParam(':address', $this->address);
    $stmt->bindParam(':phone', $this->phone);
    $stmt->bindParam(':salt', $this->salt);
    $stmt->bindParam(':user_type', $this->user_type);
 
    // execute the query, also check if query was successful
    if($stmt->execute()){
        return true;
    }
 
    return false;
}
}*/


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