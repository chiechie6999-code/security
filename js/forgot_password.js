document.addEventListener('DOMContentLoaded', function() {
    const togglePassword = document.getElementById('togglePassword');
    const password = document.getElementById('new_password');
    const toggleAuthA = document.getElementById('toggleAuthA');
    const authA = document.getElementById('auth_a');

    function toggleVis(button, input){
        button.addEventListener('click', function (e) {
            const type = input.getAttribute('type') === 'password' ? 'text' : 'password';
            input.setAttribute('type', type);
            this.classList.toggle('fa-eye-slash');
        });
    }

    toggleVis(togglePassword, password);
    toggleVis(toggleAuthA, authA);
});
