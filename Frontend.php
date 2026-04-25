<?php
// We use the 'action' variable in the URL to determine which section to show
$action = isset($_GET['action']) ? $_GET['action'] : 'home';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Soil Track - <?php echo ucfirst($action); ?></title>
    <style>
        /* Shared Styles */
        body {
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            box-sizing: border-box;
            background-color: #f4f7f6;
            overflow-x: hidden;
        }

        .page-header {
            background-color: #4CAF50; /* Grass Green */
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 30px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.2);
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 1000;
        }

        .header-left .brand-name {
            font-size: 1.8em;
            color: white;
            font-weight: bold;
            margin: 0;
            text-decoration: none;
        }

        .header-right {
            display: flex;
            gap: 10px;
            padding-right: 40px;
        }

        .header-btn {
            text-decoration: none;
            color: #333;
            font-size: 0.95em;
            font-weight: 500;
            padding: 8px 16px;
            border-radius: 4px;
            background-color: #f8f9fa;
            transition: all 0.3s ease;
            white-space: nowrap;
        }

        .header-btn:hover {
            background-color: #e2e6ea;
            transform: translateY(-1px);
        }

        .main-content {
            margin-top: 60px; 
            background-image: url('Coverpage.png'); 
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            position: relative;
        }

        /* Overlay Container for Landing Page */
        .overlay-container {
            display: flex;
            justify-content: center;
            width: 90%;
            max-width: 1100px;
            gap: 30px;
            z-index: 10;
        }

        /* Form Box for Login/Register */
        .form-box {
            background-color: rgba(255, 255, 255, 0.95);
            padding: 35px;
            border-radius: 12px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 450px;
            text-align: center;
        }

        .overlay-box {
            background-color: rgba(255, 255, 255, 0.92);
            padding: 35px;
            border-radius: 12px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.15);
            flex: 1;
        }

        /* Typography */
        h2 { color: #2e7d32; margin-bottom: 20px; }
        .large-brand { font-size: 3em; font-weight: 800; color: #2e7d32; margin: 0 0 20px 0; }
        
        input, select {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }

        .submit-btn {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 12px;
            width: 100%;
            border-radius: 5px;
            font-weight: bold;
            cursor: pointer;
            font-size: 1.1em;
            margin-top: 10px;
        }

        .submit-btn:hover { background-color: #388E3C; }

        .feature-list { list-style: none; padding: 0; text-align: left; }
        .feature-list li { margin-bottom: 12px; display: flex; align-items: center; }
        .feature-list li::before { content: '✔'; color: #4CAF50; margin-right: 12px; font-weight: bold; }

        @media (max-width: 850px) {
            .overlay-container { flex-direction: column; align-items: center; }
            .header-right { padding-right: 10px; }
        }
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
                        Maintain detailed, organized records of all your field activities, 
                        right where they happen. Access your data anytime, anywhere.
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
                    
                    <select name="role" required>
                        <option value="" disabled selected>Select your role</option>
                        <option value="farmer">Farmer</option>
                        <option value="employee">Employee</option>
                    </select>

                    <button type="submit" class="submit-btn">Create Account</button>
                </form>
                <p style="font-size: 0.9em; margin-top: 15px;">
                    Already registered? <a href="Frontend.php?action=login" style="color:#4CAF50;">Log In</a>
                </p>
            </div>
        <?php endif; ?>

    </main>

</body>
</html>