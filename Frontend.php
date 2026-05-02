<?php
$action = isset($_GET['action']) ? $_GET['action'] : 'home';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Soil Track - <?php echo ucfirst($action); ?></title>
    <!-- Link to external CSS -->
    <link rel="stylesheet" href="farm.css">
</head>
<body>

    <header class="page-header">
        <div class="header-left">
            <a href="Frontend.php" class="brand-name">Soil Track</a>
        </div>
        <div class="header-right">
            <a href="Frontend.php?action=login" class="header-btn">Log In</a>
            <a href="Frontend.php?action=register" class="header-btn">Register Here</a>
        </div>
    </header>

    <main class="main-content">

        <?php if ($action == 'home'): ?>
            <div class="overlay-container">
                <div class="overlay-box">
                    <p style="color:#555;">Comprehensive crop tracking.</p>
                    <h2 class="large-brand">Soil Track</h2>
                    <ul class="feature-list">
                        <li>Smart Field Notes</li>
                        <li>Interactive Pesticide Log</li>
                        <li>Crop Budgeting</li>
                        <li>Field Mapping</li>
                    </ul>
                </div>
                <div class="overlay-box" style="text-align: center;">
                    <h2>Welcome to Soil Track</h2>
                    <p style="color:#666; line-height:1.6;">
                        Maintain detailed, organized records of all your field activities.
                    </p>
                    <div style="margin-top: 25px; color: #888; font-size: 0.85em;">
                        🔒 Secure connection established
                    </div>
                </div>
            </div>

        <?php elseif ($action == 'login'): ?>
            <div class="form-box">
                <h2>Log In</h2>
                <form action="login_handler.php" method="POST">
                    <select name="farm_id" required>
                        <option value="" disabled selected>Select Your Farm</option>
                        <option value="1">Green Valley Estate</option>
                        <option value="2">Sunrise Fields</option>
                    </select>
                    <input type="text" name="login_id" placeholder="Login ID" required>
                    <input type="password" name="password" placeholder="Password" required>
                    <button type="submit" class="submit-btn">Enter Dashboard</button>
                </form>
                <p style="font-size: 0.9em; margin-top: 15px;">
                    New here? <a href="Frontend.php?action=register" style="color:#4CAF50;">Create an account</a>
                </p>
            </div>

       <?php elseif ($action == 'register'): ?>
    <div class="form-box">
        <h2>Register</h2>
        <form action="register_handler.php" method="POST">
            <input type="text" name="first_name" placeholder="First Name" required>
            <input type="text" name="last_name" placeholder="Last Name" required>
            <input type="email" name="email" placeholder="Email Address" required>
            <input type="password" name="password" placeholder="Password" required>
            
            <select name="role" id="roleSelect" onchange="toggleFarmInput()" required>
                <option value="" disabled selected>Select your role</option>
                <option value="farmer">Farmer</option>
                <option value="employee">Employee</option>
            </select>

            <div id="farmInputContainer" class="hidden">
                <!-- Farmer writes the name to check against your pre-added list -->
                <div id="farmerInput" class="hidden">
                    <input type="text" name="farm_name_input" placeholder="Enter Registered Farm Name">
                    <p style="font-size: 0.75em; color: #666;">*Must match the name registered during consultation.</p>
                </div>

                <!-- Employees pick from the farms you have already validated -->
                <div id="employeeInput" class="hidden">
                    <select name="existing_farm_id">
                        <option value="" disabled selected>Select Farm to Join</option>
                        <?php
                        // Later, we will add PHP here to fetch names from your 'Farm' table
                        ?>
                        <option value="1">Green Valley Estate</option> 
                    </select>
                </div>
            </div>

            <button type="submit" class="submit-btn">Verify & Create Account</button>
        </form>
    </div>
<?php endif; ?>

    </main>

    <script>
        function toggleFarmInput() {
            const role = document.getElementById('roleSelect').value;
            const container = document.getElementById('farmInputContainer');
            const farmerDiv = document.getElementById('farmerInput');
            const employeeDiv = document.getElementById('employeeInput');

            container.classList.remove('hidden');

            if (role === 'farmer') {
                farmerDiv.classList.remove('hidden');
                employeeDiv.classList.add('hidden');
            } else if (role === 'employee') {
                employeeDiv.classList.remove('hidden');
                farmerDiv.classList.add('hidden');
            }
        }
    </script>
</body>
</html>