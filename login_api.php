<?php
require("db_config.php");
require_once __DIR__ . "/device_report.php";

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);

    $username = mysqli_real_escape_string($con, $input['username']);
    $password = mysqli_real_escape_string($con, $input['password']);

    $query = "SELECT * FROM `users` WHERE username='$username' AND password='" . md5($password) . "'";
    $result = mysqli_query($con, $query);
    $rows = mysqli_num_rows($result);

    if ($rows == 1) {
        $userData = mysqli_fetch_assoc($result);

        if ($userData['banned'] == 1) {
            echo json_encode(['success' => false, 'message' => 'Your account is banned.']);
        } elseif ($userData['email_verified'] == 0) {
            echo json_encode(['success' => false, 'message' => 'Email not verified. Please check your inbox.']);
        } else {
            session_start();
            $_SESSION['username'] = $username;

            $user_agent = $_SERVER['HTTP_USER_AGENT'];
            $device_repo = new DeviceRepository($user_agent);
            collectdata($con, $device_repo, $username);

            echo json_encode(['success' => true, 'message' => 'Login successful.']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Invalid username or password.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
}
?>
