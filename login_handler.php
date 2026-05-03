<?php
session_start(); // Start session to track the user
require_once 'db_config.php';

// 1. Capture data from Frontend.php
$farmID   = $_POST['farm_id'];
$loginID  = $_POST['login_id'];
$password = $_POST['password'];

// 2. Query the Person table
// We use UserID and pass as per your database structure
$stmt = $conn->prepare("SELECT UserID, name, pass, role, status FROM Person WHERE Login_ID = ? AND FarmID = ?");
$stmt->bind_param("si", $loginID, $farmID);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $user = $result->fetch_assoc();

    // 3. Check if account is approved/active
    if ($user['status'] !== 'active') {
        header("Location: Frontend.php?action=login&error=pending");
        exit();
    }

    // 4. Verify the password hash
    if (password_verify($password, $user['pass'])) {
        
        // Success! Save user info in the Session
        $_SESSION['user_id'] = $user['UserID'];
        $_SESSION['user_name'] = $user['name'];
        $_SESSION['role'] = $user['role'];
        $_SESSION['farm_id'] = $farmID;

        // 5. Redirect based on role
        if ($user['role'] === 'farmer') {
            header("Location: farmer_dashboard.php");
        } else {
            header("Location: employee_dashboard.php");
        }
        exit();
        
    } else {
        // Wrong password
        header("Location: Frontend.php?action=login&error=invalid");
        exit();
    }
} else {
    // User ID or Farm mismatch
    header("Location: Frontend.php?action=login&error=notfound");
    exit();
}
?>