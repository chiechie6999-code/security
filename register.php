<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$error_message = "";
$success_message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include 'php/db_connection.php';
    include 'php/email.php';

    // Sanitize and retrieve POST data
    $fname = trim($_POST['fname']);
    $mname = trim($_POST['mname']);
    $familyname = trim($_POST['familyname']);
    $extension = trim($_POST['extension']);
    $birthdate = $_POST['birthdate'];
    $age = $_POST['age'];
    $regid = $_POST['regid'];
    $email = trim($_POST['email']);
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    $repassword = $_POST['repassword'];

    // Address fields
    $purok = trim($_POST['purok']);
    $barangay = trim($_POST['barangay']);
    $city = trim($_POST['city']);
    $province = trim($_POST['province']);
    $country = trim($_POST['country']);
    $zip = trim($_POST['zip']);
    $full_address = "$purok, $barangay, $city, $province, $country, $zip";

    $q1 = $_POST['q1'];
    $a1 = trim($_POST['a1']);
    $q2 = $_POST['q2'];
    $a2 = trim($_POST['a2']);
    $q3 = $_POST['q3'];
    $a3 = trim($_POST['a3']);

    // --- Server-side validation ---

    // Name validation (same as before)
    if (!preg_match("/^[A-Z][a-z]+(?: [A-Z][a-z]+)*$/", $fname)) $error_message .= "Invalid First Name format.<br>";
    if (!empty($mname) && !preg_match("/^[A-Z][a-z]+$/", $mname)) $error_message .= "Invalid Middle Name format.<br>";
    if (!preg_match("/^[A-Z][a-z]+(?: [A-Z][a-z]+)*$/", $familyname)) $error_message .= "Invalid Family Name format.<br>";
    if (!empty($extension) && !preg_match("/^[A-Za-z\s]+$/", $extension)) $error_message .= "Invalid Extension format.<br>";
    if (preg_match('/(.)\\1\\1/', $fname) || preg_match('/(.)\\1\\1/', $mname) || preg_match('/(.)\\1\\1/', $familyname)) $error_message .= "Names cannot contain three consecutive identical letters.<br>";
    if (ctype_upper($fname) || ctype_upper($familyname)) $error_message .= "Names cannot be all uppercase.<br>";
    if (strpos($fname, '  ') !== false || strpos($mname, '  ') !== false || strpos($familyname, '  ') !== false) $error_message .= "Names cannot contain double spaces.<br>";
    if (!preg_match("/^[a-zA-Z\s]*$/", $fname) || !preg_match("/^[a-zA-Z\s]*$/", $mname) || !preg_match("/^[a-zA-Z\s]*$/", $familyname) || !preg_match("/^[a-zA-Z\s.]*$/", $extension)) $error_message .= "Names and Extension cannot contain special characters or numbers.<br>";

    // Age validation
    if ($age < 18) $error_message .= "You must be at least 18 years old.<br>";

    // Registration ID
    if (!preg_match("/^\d{4}-\d{4}$/", $regid)) $error_message .= "Invalid Registration ID format.<br>";

    // Email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $error_message .= "Invalid email format.<br>";

    // Password
    if (strlen($password) < 8) $error_message .= "Password must be at least 8 characters long.<br>";
    if ($password !== $repassword) $error_message .= "Passwords do not match.<br>";

    // Check for existing user
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ? OR registration_id = ? OR email = ?");
    $stmt->bind_param("sss", $username, $regid, $email);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $error_message .= "Username, Registration ID, or Email already exists.<br>";
    }
    $stmt->close();

    if (empty($error_message)) {
        // Hash password and answers
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $hashed_a1 = password_hash($a1, PASSWORD_DEFAULT);
        $hashed_a2 = password_hash($a2, PASSWORD_DEFAULT);
        $hashed_a3 = password_hash($a3, PASSWORD_DEFAULT);

        $stmt = $conn->prepare("INSERT INTO users (registration_id, firstname, middlename, familyname, extension, birthdate, age, address, email, username, password, auth_question1, auth_answer1, auth_question2, auth_answer2, auth_question3, auth_answer3) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssssissssssssss", $regid, $fname, $mname, $familyname, $extension, $birthdate, $age, $full_address, $email, $username, $hashed_password, $q1, $hashed_a1, $q2, $hashed_a2, $q3, $hashed_a3);

        if ($stmt->execute()) {
            send_registration_email($email, $username);
            $success_message = "Registration successful!";
        } else {
            $error_message = "Error: " . $stmt->error;
        }
        $stmt->close();
    }
    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CCMart - Register</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <?php include 'header.php'; ?>

    <div class="container">
        <form name="myform" action="register.php" method="post" onsubmit="return validateform()">
            <h2>CCMart Registration</h2>
            <?php if(!empty($error_message)): ?>
                <div class="error" style="color:red; text-align: center; margin-bottom: 10px;"><?php echo $error_message; ?></div>
            <?php endif; ?>
            <?php if(!empty($success_message)): ?>
                <div class="success" style="color:green; text-align: center; margin-bottom: 10px;"><?php echo $success_message; ?></div>
            <?php endif; ?>
            <div class="form-row">
                <div class="form-group">
                    <label for="fname">First Name <span class="required">*</span></label>
                    <input type="text" id="fname" name="fname" required>
                </div>
                <div class="form-group">
                    <label for="mname">Middle Name / Initial <span class="optional">optional</span></label>
                    <input type="text" id="mname" name="mname">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label for="familyname">Family Name <span class="required">*</span></label>
                    <input type="text" id="familyname" name="familyname" required>
                </div>
                <div class="form-group">
                    <label for="extension">Extension (e.g., Jr., Sr.) <span class="optional">optional</span></label>
                    <input type="text" id="extension" name="extension">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label for="birthdate">Birthdate <span class="required">*</span></label>
                    <input type="date" id="birthdate" name="birthdate" required>
                </div>
                <div class="form-group">
                    <label for="age">Age</label>
                    <input type="text" id="age" name="age" readonly>
                </div>
            </div>
             <div class="form-row">
                <div class="form-group">
                    <label for="username">Username <span class="required">*</span></label>
                    <input type="text" id="username" name="username" required>
                </div>
                <div class="form-group">
                    <label for="email">Email <span class="required">*</span></label>
                    <input type="email" id="email" name="email" required>
                </div>
            </div>
            <div class="form-row">
                 <div class="form-group">
                    <label for="regid">Registration ID <span class="required">*</span></label>
                    <input type="text" id="regid" name="regid" placeholder="xxxx-xxxx" required>
                </div>
            </div>
            <div class="form-row">
                 <div class="form-group password-group">
                    <label for="password">Password <span class="required">*</span></label>
                    <input type="password" id="password" name="password" required>
                    <i class="toggle-password fa fa-eye"></i>
                </div>
                 <div class="form-group password-group">
                    <label for="repassword">Re-enter Password <span class="required">*</span></label>
                    <input type="password" id="repassword" name="repassword" required>
                    <i class="toggle-password fa fa-eye"></i>
                </div>
            </div>
             <div class="full-width">
                <label>Address</label>
            </div>
             <div class="form-row">
                <div class="form-group">
                     <label for="purok">Purok/Street <span class="required">*</span></label>
                    <input type="text" id="purok" name="purok" required>
                </div>
                <div class="form-group">
                     <label for="barangay">Barangay <span class="required">*</span></label>
                    <input type="text" id="barangay" name="barangay" required>
                </div>
            </div>
             <div class="form-row">
                <div class="form-group">
                     <label for="city">Municipal/City <span class="required">*</span></label>
                    <input type="text" id="city" name="city" required>
                </div>
                <div class="form-group">
                     <label for="province">Province <span class="required">*</span></label>
                    <input type="text" id="province" name="province" required>
                </div>
            </div>
             <div class="form-row">
                <div class="form-group">
                    <label for="country">Country <span class="required">*</span></label>
                    <input type="text" id="country" name="country" required>
                </div>
                <div class="form-group">
                    <label for="zip">Zip Code <span class="required">*</span></label>
                    <input type="text" id="zip" name="zip" required>
                </div>
            </div>
             <div class="full-width">
                <label>Authentication Questions</label>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label for="q1">Question 1 <span class="required">*</span></label>
                    <select id="q1" name="q1" required>
                        <option value="">Select a question</option>
                        <option value="Who is your best friend in Elementary?">Who is your best friend in Elementary?</option>
                        <option value="What is the name of your favorite pet?">What is the name of your favorite pet?</option>
                        <option value="Who is your favorite teacher in high school?">Who is your favorite teacher in high school?</option>
                    </select>
                </div>
                 <div class="form-group">
                    <label for="a1">Answer 1 <span class="required">*</span></label>
                    <input type="password" id="a1" name="a1" required>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label for="q2">Question 2 <span class="required">*</span></label>
                    <select id="q2" name="q2" required>
                         <option value="">Select a question</option>
                        <option value="What is your mother's maiden name?">What is your mother's maiden name?</option>
                        <option value="What was the name of your first school?">What was the name of your first school?</option>
                        <option value="In what city were you born?">In what city were you born?</option>
                    </select>
                </div>
                 <div class="form-group">
                    <label for="a2">Answer 2 <span class="required">*</span></label>
                    <input type="password" id="a2" name="a2" required>
                </div>
            </div>
            <div class="form-row">
                 <div class="form-group">
                    <label for="q3">Question 3 <span class="required">*</span></label>
                    <select id="q3" name="q3" required>
                         <option value="">Select a question</option>
                        <option value="What is your favorite movie?">What is your favorite movie?</option>
                        <option value="What is your favorite food?">What is your favorite food?</option>
                        <option value="What is your dream job?">What is your dream job?</option>
                    </select>
                </div>
                 <div class="form-group">
                    <label for="a3">Answer 3 <span class="required">*</span></label>
                    <input type="password" id="a3" name="a3" required>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <input type="submit" value="Register">
                </div>
            </div>
        </form>
    </div>

    <?php include 'footer.php'; ?>
    <script src="js/validation.js"></script>
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</body>
</html>
