<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Database connection
    include 'db_connect.php';

    // Get form data
    $id_number = $_POST['id_number'];
    $fname = $_POST['fname'];
    $mname = $_POST['mname'];
    $familyname = $_POST['familyname'];
    $extension = $_POST['extension'];
    $suffix = $_POST['suffix'];
    $birthdate = $_POST['birthdate'];
    $age = $_POST['age'];
    $purok_street = $_POST['purok_street'];
    $barangay = $_POST['barangay'];
    $municipal_city = $_POST['municipal_city'];
    $province = $_POST['province'];
    $country = $_POST['country'];
    $zip_code = $_POST['zip_code'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $auth_q1 = $_POST['auth_q1'];
    $auth_a1 = $_POST['auth_a1'];
    $auth_q2 = $_POST['auth_q2'];
    $auth_a2 = $_POST['auth_a2'];
    $auth_q3 = $_POST['auth_q3'];
    $auth_a3 = $_POST['auth_a3'];


    // Server-side validation
    // ... (to be implemented)

    // Hash password and answers
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $hashed_a1 = password_hash($auth_a1, PASSWORD_DEFAULT);
    $hashed_a2 = password_hash($auth_a2, PASSWORD_DEFAULT);
    $hashed_a3 = password_hash($auth_a3, PASSWORD_DEFAULT);

    // Check for existing ID number or username
    $stmt = $conn->prepare("SELECT * FROM users WHERE id_number = ? OR username = ?");
    $stmt->bind_param("ss", $id_number, $username);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        echo "Error: ID Number or Username already exists.";
        exit;
    }


    // Insert data into database
    $stmt = $conn->prepare("INSERT INTO users (id_number, firstname, middlename, familyname, extension, suffix, birthdate, age, purok_street, barangay, municipal_city, province, country, zip_code, username, password, auth_q1, auth_a1, auth_q2, auth_a2, auth_q3, auth_a3) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssisssssssssssssss", $id_number, $fname, $mname, $familyname, $extension, $suffix, $birthdate, $age, $purok_street, $barangay, $municipal_city, $province, $country, $zip_code, $username, $hashed_password, $auth_q1, $hashed_a1, $auth_q2, $hashed_a2, $auth_q3, $hashed_a3);

    if ($stmt->execute()) {
        echo "Registration successful!";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();

} else {
    echo "Invalid request method.";
}
?>