<?php
require_once 'db_config.php';

// 1. Capture the data from the form
$firstName = $_POST['first_name'];
$lastName  = $_POST['last_name'];
$fullName  = $firstName . " " . $lastName;
$email     = $_POST['email'];
$password  = password_hash($_POST['password'], PASSWORD_DEFAULT); // Secure hashing
$role      = $_POST['role'];

$farmID    = null;
$status    = 'pending';
$isAdmin   = 0;
$loginID   = null;
$message   = "";
$msgClass  = "error"; // Default to error style

// 2. Scenario A & C: User selected Farmer
// --- STEP 2: ADMIN CHECK (Fixed Column Name) ---
if ($role == 'farmer') {
    $farmNameInput = $_POST['farm_name_input'];
    
    $stmt = $conn->prepare("SELECT FarmID FROM Farm WHERE FarmName = ?");
    $stmt->bind_param("s", $farmNameInput);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $farm = $result->fetch_assoc();
        $farmID = $farm['FarmID'];
        
        // Use UserID instead of PersonID here
        $adminCheck = $conn->prepare("SELECT UserID FROM Person WHERE FarmID = ? AND is_Admin = 1");
        $adminCheck->bind_param("i", $farmID);
        $adminCheck->execute();
        $adminResult = $adminCheck->get_result();
        
        if ($adminResult->num_rows == 0) {
            $status = 'active';
            $isAdmin = 1;
            
            $countRes = $conn->query("SELECT COUNT(*) as total FROM Person");
            $countRow = $countRes->fetch_assoc();
            $nextNum  = str_pad($countRow['total'] + 1, 3, "0", STR_PAD_LEFT);
            $loginID  = "ST26-" . $nextNum;
            
            $message = "Success! Farm found. You are the Admin Farmer. Your ID is: <strong>$loginID</strong>";
            $msgClass = "success";
        } else {
            $message = "Farm found! Registration sent to the primary farmer for approval.";
            $msgClass = "pending";
        }
    } else {
        $message = "Farm not found. Please ensure the Super Admin has registered your farm.";
    }

} else {
    // Scenario B: Employee
    $farmID = $_POST['existing_farm_id'];
    $message = "Registration successful! Please wait for your farmer to approve your account and assign your Login ID.";
    $msgClass = "pending";
}

// --- STEP 4: SAVE TO DATABASE (Added 'role' column) ---
if ($farmID) {
    // Added 'role' to the column list and an extra '?'
    $insert = $conn->prepare("INSERT INTO Person (name, Email, role, pass, Login_ID, status, is_Admin, FarmID) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    
    // Added 's' to the type string and added $role to the variables
    $insert->bind_param("ssssssii", $fullName, $email, $role, $password, $loginID, $status, $isAdmin, $farmID);
    
    if (!$insert->execute()) {
        $message = "System error: Could not save registration. " . $conn->error;
        $msgClass = "error";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="farm.css">
    <title>Registration Status</title>
    <style>
        .msg-card {
            background: white;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            text-align: center;
            max-width: 500px;
        }
        .success { border-top: 5px solid #4CAF50; }
        .pending { border-top: 5px solid #ff9800; }
        .error { border-top: 5px solid #f44336; }
        .btn-home { display:inline-block; margin-top:20px; padding:10px 20px; background:#4CAF50; color:white; text-decoration:none; border-radius:5px; }
    </style>
</head>
<body class="main-content">
    <div class="msg-card <?php echo $msgClass; ?>">
        <h2>Registration Update</h2>
        <p><?php echo $message; ?></p>
        <a href="Frontend.php" class="btn-home">Return Home</a>
    </div>
</body>
</html>