<?php
    session_start();

    header("Content-Type: application/json");
    include_once "database.php";
    include_once "user.php";

    $database = new Database();
    $db = $database -> getConnection();
    $user = new User($db);

    // READ INPUT JSON DATA
    $data = json_decode(file_get_contents("php://input"), true);

    // SANITIZE & TRIM INPUTS
    $user -> first_name = htmlspecialchars(strip_tags(trim($data['first_name'])));
    $user -> last_name = htmlspecialchars(strip_tags(trim($data['last_name'])));
    $user -> email = filter_var(trim($data['email']), FILTER_SANITIZE_EMAIL);
    $user -> mobile = preg_replace('/\D/', '', trim($data['mobile'])); //REMOVE NON-NUMERIC CHARACTERS
    $user -> password = trim($data['password']);
    $user -> role = $data['role'];
    $user -> status = $data['status']; //DEFAULT STATUS UPON REGISTRATION

    //HASH THE PASSWORD
    $user ->  password = password_hash($user->password, PASSWORD_BCRYPT);

    //CHECK IF EMAIL ALREADY EXISTS USING EMAIL emailExists() function
    if ($user -> emailExists()){
        http_response_code(409);
        echo json_encode(["message" => "Email already exists.", "succes" => false]);
        exit();
    }

    //CREATE USER
    if ($user->create()){
        http_response_code(201);
        echo json_encode(["message" => "User registered successfully. Please verify your account.", "success" => true]);
    } else {
        http_response_code(500);
        echo json_encode(["message" => "Error registering user.", "success" => false]);
    }

?>
