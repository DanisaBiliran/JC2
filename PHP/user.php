<?php
class User{
    private $conn;
    private $table_name = "users";
    public $id, $first_name, $last_name, $email, $mobile, $role, $status, $password;

    public function __construct($db){
        $this->conn = $db;
    }

    //CREATE A NEW USER
    public function create(){
        //PREPARE QUERY TO INSERT THE USER
        $query = "INSERT INTO " . $this->table_name . " (first_name, last_name, email, mobile, role, status, password)
                VALUES (:first_name, :last_name, :email, :mobile, :role, :status, :password)";

        $stmt = $this->conn->prepare($query);

        //BIND PARAMETERS
        $stmt->bindParam(":first_name", $this-> first_name);
        $stmt->bindParam(":last_name", $this-> last_name);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":mobile", $this->mobile);
        $stmt->bindParam(":role", $this->role);
        $stmt->bindParam(":status", $this->status);
        $stmt->bindParam(":password", $this->password);

        // EXECUTE THE QUERY AND RETURN SUCCESS OR FAILURE
        if ($stmt->execute()){
            return["success" => true, "message" => "User registered successfully. Please verify your account."];
        } else {
            return ["success" => false, "message" => "User registration failed. Please try again."];
        }
    }
    // CHECK IF EMAIL ALREADY EXISTS IN THE DATABASE
    public function emailExists(){
        $query = "SELECT id FROM " . $this->table_name . " WHERE email = :email LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt -> bindParam(":email", $this->email);
        $stmt -> execute();
        return $stmt->rowCount()> 0;  
    }


    public function getUserByEmail() {
        $query = "SELECT id, password, role FROM " . $this->table_name . " WHERE email = :email LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":email", $this->email);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        return $user ? $user : false; // Return user data or false if not found
    }
}
?>
