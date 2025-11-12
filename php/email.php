<?php
// Placeholder for email functionality
// In a real application, you would use a library like PHPMailer to send emails.
function send_registration_email($email, $username) {
    // For demonstration purposes, we'll just log this to a file.
    $log_message = "New user registration: " . $username . " with email " . $email . " at " . date("Y-m-d H:i:s") . "\n";
    file_put_contents("registration_log.txt", $log_message, FILE_APPEND);

    // In a real scenario, the code would look something like this:
    /*
    require 'PHPMailer/PHPMailerAutoload.php';
    $mail = new PHPMailer;
    $mail->isSMTP();
    $mail->Host = 'smtp.example.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'your_email@example.com';
    $mail->Password = 'your_password';
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;
    $mail->setFrom('no-reply@ccmart.com', 'CCMart');
    $mail->addAddress($email);
    $mail->isHTML(true);
    $mail->Subject = 'Welcome to CCMart!';
    $mail->Body    = '<h1>Welcome, ' . $username . '!</h1><p>Thank you for registering at CCMart.</p>';
    if(!$mail->send()) {
        // Handle email sending failure
    }
    */
}
?>
