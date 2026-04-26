<?php
$action = isset($_GET['action']) ? $_GET['action'] : 'home';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Soil Track - <?php echo ucfirst($action); ?></title>
    <style>
        /* ... existing styles remain the same ... */
        body { margin: 0; padding: 0; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f4f7f6; }
        .page-header { background-color: #4CAF50; display: flex; justify-content: space-between; align-items: center; padding: 10px 30px; position: fixed; top: 0; width: 100%; z-index: 1000; box-shadow: 0 2px 5px rgba(0,0,0,0.2); }
        .header-left .brand-name { font-size: 1.8em; color: white; font-weight: bold; text-decoration: none; }
        .header-right { display: flex; gap: 10px; padding-right: 40px; }
        .header-btn { text-decoration: none; color: #333; font-size: 0.95em; padding: 8px 16px; border-radius: 4px; background-color: #f8f9fa; }
        
        .main-content { margin-top: 60px; background-image: url('Coverpage.png'); background-size: cover; background-attachment: fixed; min-height: 90vh; display: flex; justify-content: center; align-items: center; }
        .form-box { background-color: rgba(255, 255, 255, 0.95); padding: 35px; border-radius: 12px; width: 100%; max-width: 450px; text-align: center; box-shadow: 0 8px 32px rgba(0, 0, 0, 0.2); }
        
        input, select { width: 100%; padding: 12px; margin: 10px 0; border: 1px solid #ccc; border-radius: 5px; box-sizing: border-box; }
        .submit-btn { background-color: #4CAF50; color: white; border: none; padding: 12px; width: 100%; border-radius: 5px; font-weight: bold; cursor: pointer; margin-top: 10px; }
        
        /* New helper class to hide elements initially */
        .hidden { display: none; }
        
        .overlay-container { display: flex; gap: 30px; width: 90%; max-width: 1100px; }
        .overlay-box { background-color: rgba(255, 255, 255, 0.92); padding: 35px; border-radius: 12px; flex: 1; }
        h2 { color: #2e7d32; }
    </style>
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
                    <h2 style="font-size: 3em;">Soil Track</h2>
                    <ul class="feature-list">
                        <li>Smart Field Notes</li>
                        <li>Interactive Pesticide Log</li>
                        <li>Crop Budgeting</li>
                        <li>Field Mapping</li>
        </ul>
                </div>
                <div class="overlay-box">
                    <h2> Welcome to Soil Track</h2>
                    <p> Maintain detailed, organized records of all your field activities, right where they happen. Access your data anytime, anywhere.</p>
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
                        
                        <div id="farmerInput" class="hidden">
                            <input type="text" name="new_farm_name" placeholder="Enter New Farm Name">
                        </div>

                        <div id="employeeInput" class="hidden">
                            <select name="existing_farm_id">
                                <option value="" disabled selected>Select Farm to Join</option>
                                <option value="1">Green Valley Estate</option>
                                <option value="2">Sunrise Fields</option>
                            </select>
                        </div>
                    </div>

                    <button type="submit" class="submit-btn">Create Account</button>
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

            // Show the main container
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