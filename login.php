<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
$error_message = "";

// If user is already logged in, redirect to home page
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
    header("location: index.php");
    exit;
}

// Check if the user is currently locked out
if (isset($_SESSION['lockout_time']) && time() < $_SESSION['lockout_time']) {
    $remaining_time = $_SESSION['lockout_time'] - time();
    $error_message = "Too many failed login attempts. Please try again in {$remaining_time} seconds.";
} elseif ($_SERVER["REQUEST_METHOD"] == "POST") {
    include 'php/db_connection.php';

    $username = trim($_POST['username']);
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT id, username, password FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            // Password is correct, start a new session
            $_SESSION['loggedin'] = true;
            $_SESSION['id'] = $user['id'];
            $_SESSION['username'] = $user['username'];

            // Reset login attempts
            unset($_SESSION['login_attempts']);
            unset($_SESSION['lockout_time']);

            header("location: index.php");
        } else {
            // Password is not valid
            handle_failed_login();
        }
    } else {
        // Username doesn't exist
        handle_failed_login();
    }

    $stmt->close();
    $conn->close();
}

function handle_failed_login() {
    global $error_message;
    if (!isset($_SESSION['login_attempts'])) {
        $_SESSION['login_attempts'] = 0;
    }
    $_SESSION['login_attempts']++;

    $attempts = $_SESSION['login_attempts'];
    $lockout_time = 0;

    if ($attempts % 9 == 0) {
        $lockout_time = 60; // 60 seconds
    } elseif ($attempts % 6 == 0) {
        $lockout_time = 30; // 30 seconds
    } elseif ($attempts % 3 == 0) {
        $lockout_time = 15; // 15 seconds
    }

    if ($lockout_time > 0) {
        $_SESSION['lockout_time'] = time() + $lockout_time;
        $error_message = "Too many failed login attempts. Please try again in {$lockout_time} seconds.";
    } else {
        $error_message = "Invalid username or password.";
    }
}

$show_forgot_password = isset($_SESSION['login_attempts']) && $_SESSION['login_attempts'] >= 2;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CCMart - Login</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        .password-group { position: relative; }
        .toggle-password {
            position: absolute;
            top: 70%;
            right: 15px;
            transform: translateY(-50%);
            cursor: pointer;
        }
        .login-btn:disabled {
            background-color: #ccc;
            cursor: not-allowed;
        }
    </style>
</head>
<body>
    <?php include 'header.php'; ?>
    <div class="container">
        <form action="login.php" method="post" id="login-form">
            <h2>CCMart Login</h2>
            <?php if(!empty($error_message)): ?>
                <div class="error" style="color:red; text-align: center; margin-bottom: 10px;"><?php echo $error_message; ?></div>
            <?php endif; ?>
            <div class="form-group">
                <label for="username">Username <span class="required">*</span></label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="form-group password-group">
                <label for="password">Password <span class="required">*</span></label>
                <input type="password" id="password" name="password" required>
                <i class="toggle-password fas fa-eye"></i>
            </div>
            <div class="form-group">
                <input type="submit" value="Log-in" class="login-btn">
            </div>
            <?php if ($show_forgot_password): ?>
                <div style="text-align: center; margin-top: 10px;">
                    <a href="forgot_password.php" class="forgot-password-link">Forgot Password? Reset Here</a>
                </div>
            <?php endif; ?>
        </form>
    </div>
    <?php include 'footer.php'; ?>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Show/hide password
            const togglePasswords = document.querySelectorAll('.toggle-password');
            togglePasswords.forEach(toggle => {
                toggle.addEventListener('click', function() {
                    const passwordField = this.previousElementSibling;
                    const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
                    passwordField.setAttribute('type', type);
                    this.classList.toggle('fa-eye-slash');
                });
            });

            // Lockout timer
            const loginForm = document.getElementById('login-form');
            const loginBtn = loginForm.querySelector('.login-btn');
            const forgotPasswordLink = document.querySelector('.forgot-password-link');

            <?php if (isset($_SESSION['lockout_time']) && time() < $_SESSION['lockout_time']): ?>
                let remainingTime = <?php echo $_SESSION['lockout_time'] - time(); ?>;
                loginBtn.disabled = true;
                if(forgotPasswordLink) forgotPasswordLink.style.pointerEvents = 'none';

                const interval = setInterval(() => {
                    remainingTime--;
                    if (remainingTime > 0) {
                        loginForm.querySelector('.error').textContent = `Too many failed login attempts. Please try again in ${remainingTime} seconds.`;
                    } else {
                        clearInterval(interval);
                        loginForm.querySelector('.error').textContent = '';
                        loginBtn.disabled = false;
                        if(forgotPasswordLink) forgotPasswordLink.style.pointerEvents = 'auto';
                    }
                }, 1000);
            <?php endif; ?>

            // Disable back button
            history.pushState(null, null, location.href);
            window.onpopstate = function () {
                history.go(1);
            };
        });
    </script>
</body>
</html>
