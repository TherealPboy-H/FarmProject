<?php
session_start();
require_once 'db_config.php';

// Security Check: If not logged in or not a farmer, kick them back to login
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'farmer') {
    header("Location: Frontend.php?action=login");
    exit();
}

$currentFarmID = $_SESSION['farm_id']; 
$adminName     = $_SESSION['user_name'];

// Fetch pending people for the logged-in admin's farm
$query = "SELECT UserID, name, Email, role FROM Person WHERE FarmID = $currentFarmID AND status = 'pending'";
$pendingUsers = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="farm.css">
    <title>Farm Dashboard - Approvals</title>
    <style>
        .dashboard-container { display: flex; min-height: 100vh; }
        .sidebar { width: 250px; background: #1a2a1a; color: white; padding: 20px; }
        .main-content-area { flex: 1; padding: 40px; background: #f9fbf9; }
        .approval-card { 
            background: white; 
            padding: 20px; 
            border-radius: 10px; 
            box-shadow: 0 2px 10px rgba(0,0,0,0.05); 
            margin-bottom: 15px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .btn-approve { background: #4CAF50; color: white; padding: 8px 15px; border-radius: 5px; text-decoration: none; font-weight: bold; }
        .btn-reject { background: #f44336; color: white; padding: 8px 15px; border-radius: 5px; text-decoration: none; margin-left: 10px; }
        .badge { padding: 4px 8px; border-radius: 4px; font-size: 0.8em; background: #e8f5e9; color: #2e7d32; }
    </style>
</head>
<body>

<div class="dashboard-container">
    <aside class="sidebar">
        <h2>FarmBase</h2>
        <nav>
            <p><strong>Dashboard</strong></p>
            <p>Spray Log</p>
            <p>Harvest Log</p>
            <p>Fields</p>
        </nav>
    </aside>

    <main class="main-content-area">
        <h1>Pending Approvals</h1>
        <p>Review new farmers and employees requesting to join your farm.</p>

        <?php if ($pendingUsers->num_rows > 0): ?>
            <?php while($row = $pendingUsers->fetch_assoc()): ?>
                <div class="approval-card">
                    <div>
                        <strong><?php echo $row['name']; ?></strong> 
                        <span class="badge"><?php echo $row['role']; ?></span>
                        <br>
                        <small><?php echo $row['Email']; ?></small>
                    </div>
                    <div>
                        <a href="approve_handler.php?id=<?php echo $row['UserID']; ?>&action=accept" class="btn-approve">Accept</a>
                        <a href="approve_handler.php?id=<?php echo $row['UserID']; ?>&action=reject" class="btn-reject">Reject</a>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <div class="approval-card">
                <p>No pending requests at the moment.</p>
            </div>
        <?php endif; ?>
    </main>
</div>

</body>
</html>