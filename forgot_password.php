<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
include 'php/db_connection.php';
$error_message = "";
$success_message = "";
$step = 1; // 1: ask for username, 2: ask questions, 3: reset password
$username = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['username'])) {
        $username = trim($_POST['username']);
        $_SESSION['reset_username'] = $username;
        $stmt = $conn->prepare("SELECT auth_question1, auth_question2, auth_question3 FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows == 1) {
            $user = $result->fetch_assoc();
            $_SESSION['auth_questions'] = $user;
            $step = 2;
        } else {
            $error_message = "Username not found.";
        }
        $stmt->close();
    } elseif (isset($_POST['a1']) && isset($_SESSION['reset_username'])) {
        $username = $_SESSION['reset_username'];
        $a1 = trim($_POST['a1']);
        $a2 = trim($_POST['a2']);
        $a3 = trim($_POST['a3']);

        $stmt = $conn->prepare("SELECT auth_answer1, auth_answer2, auth_answer3 FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        if (password_verify($a1, $user['auth_answer1']) && password_verify($a2, $user['auth_answer2']) && password_verify($a3, $user['auth_answer3'])) {
            $step = 3;
        } else {
            $error_message = "One or more answers are incorrect.";
            $step = 2; // Stay on the questions step
        }
        $stmt->close();
    } elseif (isset($_POST['password']) && isset($_SESSION['reset_username'])) {
        $username = $_SESSION['reset_username'];
        $password = $_POST['password'];
        $repassword = $_POST['repassword'];

        if (strlen($password) < 8) {
            $error_message = "Password must be at least 8 characters long.";
            $step = 3;
        } elseif ($password !== $repassword) {
            $error_message = "Passwords do not match.";
            $step = 3;
        } else {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $conn->prepare("UPDATE users SET password = ? WHERE username = ?");
            $stmt->bind_param("ss", $hashed_password, $username);
            if ($stmt->execute()) {
                $success_message = "Password changed successfully! You can now log in.";
                unset($_SESSION['reset_username']);
                unset($_SESSION['auth_questions']);
            } else {
                $error_message = "Failed to update password.";
                $step = 3;
            }
            $stmt->close();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CCMart - Forgot Password</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>
    <?php include 'header.php'; ?>
    <div class="container">
        <h2>Forgot Password</h2>
        <?php if(!empty($error_message)): ?>
            <div class="error" style="color:red; text-align: center; margin-bottom: 10px;"><?php echo $error_message; ?></div>
        <?php endif; ?>
        <?php if(!empty($success_message)): ?>
            <div class="success" style="color:green; text-align: center; margin-bottom: 10px;"><?php echo $success_message; ?></div>
        <?php else: ?>
            <form action="forgot_password.php" method="post">
                <?php if ($step == 1): ?>
                    <div class="form-group">
                        <label for="username">Enter your username:</label>
                        <input type="text" name="username" id="username" required>
                    </div>
                    <div class="form-group">
                        <input type="submit" value="Submit">
                    </div>
                <?php elseif ($step == 2): ?>
                    <h4>Answer your security questions:</h4>
                    <div class="form-group">
                        <label><?php echo $_SESSION['auth_questions']['auth_question1']; ?></label>
                        <input type="password" name="a1" required>
                    </div>
                    <div class="form-group">
                        <label><?php echo $_SESSION['auth_questions']['auth_question2']; ?></label>
                        <input type="password" name="a2" required>
                    </div>
                    <div class="form-group">
                        <label><?php echo $_SESSION['auth_questions']['auth_question3']; ?></label>
                        <input type="password" name="a3" required>
                    </div>
                    <div class="form-group">
                        <input type="submit" value="Verify">
                    </div>
                <?php elseif ($step == 3): ?>
                     <h4>Enter your new password:</h4>
                    <div class="form-group">
                        <label for="password">New Password:</label>
                        <input type="password" name="password" id="password" required>
                    </div>
                    <div class="form-group">
                        <label for="repassword">Re-enter New Password:</label>
                        <input type="password" name="repassword" id="repassword" required>
                    </div>
                    <div class="form-group">
                        <input type="submit" value="Reset Password">
                    </div>
                <?php endif; ?>
            </form>
        <?php endif; ?>
    </div>
    <?php include 'footer.php'; ?>
</body>
</html>
