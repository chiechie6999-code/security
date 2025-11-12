document.addEventListener('DOMContentLoaded', function() {
    const birthdateInput = document.getElementById('birthdate');
    const ageInput = document.getElementById('age');
    const togglePassword = document.getElementById('togglePassword');
    const password = document.getElementById('password');
    const toggleAuthA1 = document.getElementById('toggleAuthA1');
    const authA1 = document.getElementById('auth_a1');
    const toggleAuthA2 = document.getElementById('toggleAuthA2');
    const authA2 = document.getElementById('auth_a2');
    const toggleAuthA3 = document.getElementById('toggleAuthA3');
    const authA3 = document.getElementById('auth_a3');

    birthdateInput.addEventListener('change', function() {
        const birthdate = new Date(this.value);
        const today = new Date();
        let age = today.getFullYear() - birthdate.getFullYear();
        const m = today.getMonth() - birthdate.getMonth();
        if (m < 0 || (m === 0 && today.getDate() < birthdate.getDate())) {
            age--;
        }
        ageInput.value = age;
    });

    function toggleVis(button, input){
        button.addEventListener('click', function (e) {
            const type = input.getAttribute('type') === 'password' ? 'text' : 'password';
            input.setAttribute('type', type);
            this.classList.toggle('fa-eye-slash');
        });
    }

    toggleVis(togglePassword, password);
    toggleVis(toggleAuthA1, authA1);
    toggleVis(toggleAuthA2, authA2);
    toggleVis(toggleAuthA3, authA3);
});


function validateform() {
    var id_number = document.myform.id_number.value;
    var fname = document.myform.fname.value;
    var mname = document.myform.mname.value;
    var familyname = document.myform.familyname.value;
    var extension = document.myform.extension.value;
    var suffix = document.myform.suffix.value;
    var birthdate = document.myform.birthdate.value;
    var age = document.myform.age.value;
    var purok_street = document.myform.purok_street.value;
    var barangay = document.myform.barangay.value;
    var municipal_city = document.myform.municipal_city.value;
    var province = document.myform.province.value;
    var country = document.myform.country.value;
    var zip_code = document.myform.zip_code.value;
    var username = document.myform.username.value;
    var password = document.myform.password.value;
    var re_password = document.myform.re_password.value;
    var auth_q1 = document.myform.auth_q1.value;
    var auth_a1 = document.myform.auth_a1.value;
    var auth_q2 = document.myform.auth_q2.value;
    var auth_a2 = document.myform.auth_a2.value;
    var auth_q3 = document.myform.auth_q3.value;
    var auth_a3 = document.myform.auth_a3.value;


    // ID Number Validation
    if (!/^\d{4}-\d{4}$/.test(id_number)) {
        alert("ID Number must be in the format xxxx-xxxx.");
        return false;
    }

    // Name Validation
    if (!validateName(fname, "First Name")) return false;
    if (mname && !validateName(mname, "Middle Name")) return false;
    if (!validateName(familyname, "Family Name")) return false;
    if (extension && !/^[a-zA-Z\s.-]*$/.test(extension)) {
        alert("Name extension can only contain letters, spaces, dots, and hyphens.");
        return false;
    }
     if (suffix && !/^[a-zA-Z\s.-]*$/.test(suffix)) {
        alert("Name suffix can only contain letters, spaces, dots, and hyphens.");
        return false;
    }


    // Age Validation
    if (age < 18) {
        alert("You must be at least 18 years old to register.");
        return false;
    }

    // Address Validation
    if (!purok_street) { alert("Purok/Street is required."); return false; }
    if (!barangay) { alert("Barangay is required."); return false; }
    if (!municipal_city) { alert("Municipal/City is required."); return false; }
    if (!province) { alert("Province is required."); return false; }
    if (!country) { alert("Country is required."); return false; }
    if (!/^\d{4,5}$/.test(zip_code)) { alert("Zip code must be 4 or 5 digits."); return false; }


    // Username Validation
     if (username.length < 6) {
        alert("Username must be at least 6 characters long.");
        return false;
    }

    // Password Validation
    if (password.length < 8) {
        alert("Password must be at least 8 characters long.");
        return false;
    }
    if (password !== re_password) {
        alert("Passwords do not match.");
        return false;
    }

    return true;
}

function validateName(name, fieldName) {
    if (name == null || name == "") {
        alert(fieldName + " can't be blank");
        return false;
    }
    if (name.length < 2) {
        alert(fieldName + " must be at least 2 characters long.");
        return false;
    }
    if (containsNumber(name)) {
        alert(fieldName + " cannot contain numbers.");
        return false;
    }
    if (!/^[A-Z][a-z]+(\s[A-Z][a-z]+)*$/.test(name)) {
        alert("First letter of " + fieldName + " should be capitalized and the rest should be lowercase.");
        return false;
    }
     if (hasThreeRepeatedLetters(name)) {
        alert(fieldName + " cannot contain three repeated letters in a row.");
        return false;
    }
    if (/[^a-zA-Z\s]/.test(name)) {
        alert(fieldName + " cannot contain special characters.");
        return false;
    }
    if (/\s\s/.test(name)) {
        alert(fieldName + " cannot contain double spaces.");
        return false;
    }
    if (name === name.toUpperCase()){
        alert(fieldName + " cannot be all capital letters.")
        return false;
    }
    return true;
}


function containsNumber(inputText) {
    return /\d/.test(inputText);
}

function hasThreeRepeatedLetters(str) {
    return /(.)\1\1/.test(str);
}
