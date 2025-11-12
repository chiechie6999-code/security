<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - CCMart</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/register.css">
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

    <main class="register-container">
        <form name="myform" action="php/register_process.php" method="POST" onsubmit="return validateform()">
            <div class="form-row">
                <div class="form-group">
                    <label for="id_number">ID Number*</label>
                    <input type="text" id="id_number" name="id_number" placeholder="xxxx-xxxx" required>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label for="fname">First Name*</label>
                    <input type="text" id="fname" name="fname" required>
                </div>
                <div class="form-group">
                    <label for="mname">Middle Name <span class="optional">(optional)</span></label>
                    <input type="text" id="mname" name="mname">
                </div>
                <div class="form-group">
                    <label for="familyname">Family Name*</label>
                    <input type="text" id="familyname" name="familyname" required>
                </div>
                <div class="form-group">
                    <label for="extension">Extension <span class="optional">(optional)</span></label>
                    <input type="text" id="extension" name="extension">
                </div>
                <div class="form-group">
                    <label for="suffix">Suffix <span class="optional">(optional)</span></label>
                    <input type="text" id="suffix" name="suffix">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label for="birthdate">Birthdate*</label>
                    <input type="date" id="birthdate" name="birthdate" required>
                </div>
                 <div class="form-group">
                    <label for="age">Age*</label>
                    <input type="number" id="age" name="age" readonly required>
                </div>
            </div>
            <div class="form-row address-row">
                <div class="form-group">
                    <label for="purok_street">Purok/Street*</label>
                    <input type="text" id="purok_street" name="purok_street" required>
                </div>
                <div class="form-group">
                    <label for="barangay">Barangay*</label>
                    <input type="text" id="barangay" name="barangay" required>
                </div>
                <div class="form-group">
                    <label for="municipal_city">Municipal/City*</label>
                    <input type="text" id="municipal_city" name="municipal_city" required>
                </div>
            </div>
             <div class="form-row address-row">
                <div class="form-group">
                    <label for="province">Province*</label>
                    <input type="text" id="province" name="province" required>
                </div>
                <div class="form-group">
                    <label for="country">Country*</label>
                    <input type="text" id="country" name="country" required>
                </div>
                <div class="form-group">
                    <label for="zip_code">Zip Code*</label>
                    <input type="text" id="zip_code" name="zip_code" required>
                </div>
            </div>
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
                <div class="form-group">
                    <label for="re_password">Re-enter Password*</label>
                    <input type="password" id="re_password" name="re_password" required>
                </div>
            </div>
            <div class="form-row">
                 <div class="form-group">
                    <label for="auth_q1">Authentication Question 1*</label>
                    <select id="auth_q1" name="auth_q1" required>
                        <option value="" disabled selected>Choose a question</option>
                        <option value="Who is your best friend in Elementary?">Who is your best friend in Elementary?</option>
                        <option value="What is the name of your favorite pet?">What is the name of your favorite pet?</option>
                        <option value="Who is your favorite teacher in high school?">Who is your favorite teacher in high school?</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="auth_a1">Answer*</label>
                    <input type="password" id="auth_a1" name="auth_a1" required>
                    <i class="far fa-eye" id="toggleAuthA1"></i>
                </div>
            </div>
             <div class="form-row">
                 <div class="form-group">
                    <label for="auth_q2">Authentication Question 2*</label>
                    <select id="auth_q2" name="auth_q2" required>
                        <option value="" disabled selected>Choose a question</option>
                        <option value="What is your mother's maiden name?">What is your mother's maiden name?</option>
                        <option value="What was the name of your first school?">What was the name of your first school?</option>
                        <option value="In what city were you born?">In what city were you born?</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="auth_a2">Answer*</label>
                    <input type="password" id="auth_a2" name="auth_a2" required>
                    <i class="far fa-eye" id="toggleAuthA2"></i>
                </div>
            </div>
             <div class="form-row">
                 <div class="form-group">
                    <label for="auth_q3">Authentication Question 3*</label>
                    <select id="auth_q3" name="auth_q3" required>
                        <option value="" disabled selected>Choose a question</option>
                        <option value="What is your favorite food?">What is your favorite food?</option>
                        <option value="What is your favorite movie?">What is your favorite movie?</option>
                        <option value="What is your favorite color?">What is your favorite color?</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="auth_a3">Answer*</label>
                    <input type="password" id="auth_a3" name="auth_a3" required>
                    <i class="far fa-eye" id="toggleAuthA3"></i>
                </div>
            </div>
            <div class="form-row">
                <button type="submit">Register</button>
            </div>
        </form>
    </main>

    <footer>
        <p>&copy; 2024 CCMart. All rights reserved.</p>
    </footer>
    <script src="js/validation.js"></script>
</body>
</html>