<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - CCMart</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/login.css">
</head>
<body>
    <header>
        <div class="prospect-name">CCMart</div>
        <nav>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="register.php">Register</a></li>
            </ul>
        </nav>
    </header>

    <main class="login-container">
        <form name="loginform" action="php/login_process.php" method="POST">
            <div class="form-row">
                <div class="form-group">
                    <label for="username">Username*</label>
                    <input type="text" id="username" name="username" required>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label for="password">Password*</label>
                    <input type="password" id="password" name="password" required>
                    <i class="far fa-eye" id="togglePassword"></i>
                </div>
            </div>
            <div class="form-row">
                <button type="submit" id="login-button">Log-in</button>
            </div>
            <div id="forgot-password" style="display: none;">
                <a href="forgot_password.php">Forgot Password? Reset Here</a>
            </div>
        </form>
    </main>

    <footer>
        <p>&copy; 2024 CCMart. All rights reserved.</p>
    </footer>
    <script src="js/login.js"></script>
</body>
</html>