<?php
session_start();
header("Content-Type: application/json");
include_once "database.php";
include_once "user.php";

$database = new Database();
$db = $database->getConnection();
$user = new User($db);

$data = json_decode(file_get_contents("php://input"), true);

$email = filter_var(trim($data['email']), FILTER_SANITIZE_EMAIL);
$password = trim($data['password']);

$user->email = $email;
$userInfo = $user->getUserByEmail(); 

if ($userInfo && password_verify($password, $userInfo['password'])) {
    // Authentication successful
    $_SESSION['user_id'] = $userInfo['id'];
    $_SESSION['role'] = $userInfo['role'];

    http_response_code(200);
    echo json_encode([
        "message" => "Login successful!",
        "success" => true,
        "role" => $userInfo['role']
    ]);
} else {
    // Authentication failed
    http_response_code(401); // Unauthorized
    echo json_encode([
        "message" => "Invalid credentials.",
        "success" => false
    ]);
}
?>
