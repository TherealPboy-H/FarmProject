<?php
require_once 'db_config.php';

$personID = $_GET['id'];
$action   = $_GET['action'];

if ($action == 'accept') {
    // 1. Generate the unique Login ID (ST + Year + Counter)
    $countRes = $conn->query("SELECT COUNT(*) as total FROM Person WHERE status = 'active'");
    $countRow = $countRes->fetch_assoc();
    $nextNum  = str_pad($countRow['total'] + 1, 3, "0", STR_PAD_LEFT);
    $newLoginID = "ST26-" . $nextNum;

    // 2. Update the user to Active and give them their ID
    $stmt = $conn->prepare("UPDATE Person SET status = 'active', Login_ID = ? WHERE UserID = ?");
    $stmt->bind_param("si", $newLoginID, $personID);
    $stmt->execute();

    header("Location: farmer_dashboard.php?msg=UserApproved");

} else if ($action == 'reject') {
    // Set to rejected so they can't log in
    $conn->query("UPDATE Person SET status = 'rejected' WHERE UserID = $personID");
    header("Location: farmer_dashboard.php?msg=UserRejected");
}
?>