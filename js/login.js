document.addEventListener('DOMContentLoaded', function() {
    const togglePassword = document.getElementById('togglePassword');
    const password = document.getElementById('password');
    const loginButton = document.getElementById('login-button');
    const forgotPasswordLink = document.getElementById('forgot-password');

    togglePassword.addEventListener('click', function (e) {
        const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
        password.setAttribute('type', type);
        this.classList.toggle('fa-eye-slash');
    });

    const urlParams = new URLSearchParams(window.location.search);
    const error = urlParams.get('error');
    let loginAttempts = localStorage.getItem('login_attempts') || 0;

    if(error){
        loginAttempts++;
        localStorage.setItem('login_attempts', loginAttempts);
    }

    if (loginAttempts >= 2) {
        forgotPasswordLink.style.display = 'block';
    }

    if (loginAttempts >= 3 && loginAttempts < 6) {
        disableLogin(15);
    } else if (loginAttempts >= 6 && loginAttempts < 9) {
        disableLogin(30);
    } else if (loginAttempts >= 9) {
        disableLogin(60);
    }

    function disableLogin(seconds) {
        loginButton.disabled = true;
        let countdown = seconds;
        const interval = setInterval(() => {
            loginButton.textContent = `Try again in ${countdown}s`;
            countdown--;
            if (countdown < 0) {
                clearInterval(interval);
                loginButton.disabled = false;
                loginButton.textContent = 'Log-in';
                localStorage.removeItem('login_attempts');
            }
        }, 1000);
    }

    // Disable back button
    history.pushState(null, null, location.href);
    window.onpopstate = function () {
        history.go(1);
    };
});
