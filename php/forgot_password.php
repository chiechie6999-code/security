<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password - CCMart</title>
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/forgot_password.css">
</head>
<body>
    <header>
        <div class="prospect-name">CCMart</div>
        <nav>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="login.php">Log-in</a></li>
            </ul>
        </nav>
    </header>

    <main class="login-container">
        <form name="forgotpasswordform" action="php/forgot_password_process.php" method="POST">
             <div class="form-row">
                <div class="form-group">
                    <label for="username">Username*</label>
                    <input type="text" id="username" name="username" required>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label for="auth_q">Authentication Question*</label>
                    <select id="auth_q" name="auth_q" required>
                        <option value="" disabled selected>Choose a question</option>
                        <option value="auth_q1">Who is your best friend in Elementary?</option>
                        <option value="auth_q1">What is the name of your favorite pet?</option>
                        <option value="auth_q1">Who is your favorite teacher in high school?</option>
                        <option value="auth_q2">What is your mother's maiden name?</option>
                        <option value="auth_q2">What was the name of your first school?</option>
                        <option value="auth_q2">In what city were you born?</option>
                        <option value="auth_q3">What is your favorite food?</option>
                        <option value="auth_q3">What is your favorite movie?</option>
                        <option value="auth_q3">What is your favorite color?</option>
                    </select>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label for="auth_a">Answer*</label>
                    <input type="password" id="auth_a" name="auth_a" required>
                    <i class="far fa-eye" id="toggleAuthA"></i>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label for="new_password">New Password*</label>
                    <input type="password" id="new_password" name="new_password" required>
                    <i class="far fa-eye" id="togglePassword"></i>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label for="re_new_password">Re-enter New Password*</label>
                    <input type="password" id="re_new_password" name="re_new_password" required>
                </div>
            </div>
            <div class="form-row">
                <button type="submit">Reset Password</button>
            </div>
        </form>
    </main>

    <footer>
        <p>&copy; 2024 CCMart. All rights reserved.</p>
    </footer>
    <script src="js/forgot_password.js"></script>
</body>
</html>