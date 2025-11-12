<?php
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Database connection
    include 'db_connect.php';

    // Get form data
    $username = $_POST['username'];
    $auth_q = $_POST['auth_q'];
    $auth_a = $_POST['auth_a'];
    $new_password = $_POST['new_password'];
    $re_new_password = $_POST['re_new_password'];

    // Basic validation
    if ($new_password !== $re_new_password) {
        echo "Passwords do not match.";
        exit;
    }

    // Get user's hashed answer
    $stmt = $conn->prepare("SELECT auth_a1, auth_a2, auth_a3 FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        $hashed_a = "";

        // This is not a secure way to do this, but it's a simple implementation
        if($auth_q == 'auth_q1') $hashed_a = $user['auth_a1'];
        if($auth_q == 'auth_q2') $hashed_a = $user['auth_a2'];
        if($auth_q == 'auth_q3') $hashed_a = $user['auth_a3'];

        if (password_verify($auth_a, $hashed_a)) {
            // Update password
            $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
            $update_stmt = $conn->prepare("UPDATE users SET password = ? WHERE username = ?");
            $update_stmt->bind_param("ss", $hashed_password, $username);

            if ($update_stmt->execute()) {
                echo "Password changed successfully.";
            } else {
                echo "Error updating password.";
            }
            $update_stmt->close();
        } else {
            echo "Incorrect answer.";
        }
    } else {
        echo "Username not found.";
    }

    $stmt->close();
    $conn->close();

} else {
    echo "Invalid request method.";
}
?>