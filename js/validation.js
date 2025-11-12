document.addEventListener('DOMContentLoaded', function() {
    // Age calculation
    document.getElementById('birthdate').addEventListener('change', function() {
        var birthdate = new Date(this.value);
        if (!isNaN(birthdate)) {
            var today = new Date();
            var age = today.getFullYear() - birthdate.getFullYear();
            var m = today.getMonth() - birthdate.getMonth();
            if (m < 0 || (m === 0 && today.getDate() < birthdate.getDate())) {
                age--;
            }
            document.getElementById('age').value = age;
        } else {
            document.getElementById('age').value = '';
        }
    });
});

function validateform() {
    // Name validation
    if (!validateName('fname', 'First Name')) return false;
    if (document.getElementById('mname').value.length > 0 && !validateName('mname', 'Middle Name', false)) return false;
    if (!validateName('familyname', 'Family Name')) return false;
    if (document.getElementById('extension').value.length > 0 && !validateName('extension', 'Extension', false)) return false;

    // Birthdate and Age
    var birthdate = document.getElementById('birthdate').value;
    if (birthdate === "") {
        alert("Birthdate is required.");
        return false;
    }
    var age = parseInt(document.getElementById('age').value);
    if (isNaN(age) || age < 18) {
        alert("You must be at least 18 years old to register.");
        return false;
    }

    // Registration ID
    var regid = document.getElementById('regid').value;
    if (!/^\d{4}-\d{4}$/.test(regid)) {
        alert("Registration ID must be in the format xxxx-xxxx.");
        return false;
    }

    // Email
    var email = document.getElementById('email').value;
    if (!/^\S+@\S+\.\S+$/.test(email)) {
        alert("Please enter a valid email address.");
        return false;
    }

    // Username
     var username = document.getElementById('username').value;
    if (username.length < 5) {
        alert("Username must be at least 5 characters long.");
        return false;
    }

    // Password
    var password = document.getElementById('password').value;
    var repassword = document.getElementById('repassword').value;
    if (password.length < 8) {
        alert("Password must be at least 8 characters long.");
        return false;
    }
    if (password !== repassword) {
        alert("Passwords do not match.");
        return false;
    }
    // Simple password strength check
    var strength = 0;
    if (password.match(/[a-z]+/)) strength++;
    if (password.match(/[A-Z]+/)) strength++;
    if (password.match(/[0-9]+/)) strength++;
    if (password.match(/[$@#&!]+/)) strength++;

    if(strength < 3) {
        alert("Password is too weak. It must contain at least three of the following: lowercase letters, uppercase letters, numbers, and special characters ($@#&!).");
        return false;
    }


    // Address
    if (!validateAddressField('purok', 'Purok/Street')) return false;
    if (!validateAddressField('barangay', 'Barangay')) return false;
    if (!validateAddressField('city', 'Municipal/City')) return false;
    if (!validateAddressField('province', 'Province')) return false;
    if (!validateAddressField('country', 'Country')) return false;
    if (!/^\d{4,5}$/.test(document.getElementById('zip').value)) {
        alert("Please enter a valid Zip Code.");
        return false;
    }

    // Auth Questions
    if (document.getElementById('a1').value.length === 0) {
        alert("Answer for Question 1 is required.");
        return false;
    }
     if (document.getElementById('a2').value.length === 0) {
        alert("Answer for Question 2 is required.");
        return false;
    }
     if (document.getElementById('a3').value.length === 0) {
        alert("Answer for Question 3 is required.");
        return false;
    }

    return true;
}

function validateName(fieldId, fieldName, isRequired = true) {
    var value = document.getElementById(fieldId).value;
    if (isRequired && value === "") {
        alert(fieldName + " can't be blank.");
        return false;
    }
    if (value.includes("  ")) {
        alert(fieldName + " cannot contain double spaces.");
        return false;
    }
    if (value === value.toUpperCase() && value.length > 1) {
        alert(fieldName + " cannot be all in capital letters.");
        return false;
    }
    if (hasThreeRepeatedLetters(value)) {
        alert(fieldName + " cannot contain three repeated letters in a row.");
        return false;
    }
    if (!/^[A-Z][a-z]+(?: [A-Z][a-z]+)*$/.test(value) && value.length > 0) {
        alert("Every first letter of " + fieldName + " must start with a capital letter, and the rest must be lowercase. Example: Juan Carlo");
        return false;
    }
     if (/[^a-zA-Z\s]/.test(value)) {
        alert(fieldName + " cannot contain special characters or numbers.");
        return false;
    }

    return true;
}

function validateAddressField(fieldId, fieldName) {
    var value = document.getElementById(fieldId).value;
     if (value === "") {
        alert(fieldName + " can't be blank.");
        return false;
    }
    return true;
}


function hasThreeRepeatedLetters(str) {
    var lowerStr = str.toLowerCase();
    for (var i = 0; i <= lowerStr.length - 3; i++) {
        if (lowerStr[i] === lowerStr[i + 1] && lowerStr[i] === lowerStr[i + 2]) {
            return true;
        }
    }
    return false;
}
