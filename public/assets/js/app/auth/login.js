const passwordInput = document.getElementById('password');
const togglePasswordButton = document.getElementById('togglePassword');
const toggleIcon = document.getElementById('icon_view_password');

passwordInput.addEventListener('input', validatePassword);

togglePasswordButton.addEventListener('click', () => {
    const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
    passwordInput.setAttribute('type', type);
    if (type === 'text') {
        toggleIcon.classList.remove('fas', 'fa-eye');
        toggleIcon.classList.add('fa-solid', 'fa-eye-slash');
        togglePasswordButton.setAttribute('title', 'Ocultar');
    } else {
        toggleIcon.classList.remove('fa-solid', 'fa-eye-slash');
        toggleIcon.classList.add('fas', 'fa-eye');
        togglePasswordButton.setAttribute('title', 'Ver');
    }
});

function validatePassword() {
    const passwordValue = passwordInput.value;
    const regex = /^(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&.]{6,}$/;

    if (regex.test(passwordValue)) {
        passwordInput.classList.remove('is-invalid');
        passwordInput.classList.add('is-valid');
    } else {
        passwordInput.classList.remove('is-valid');
        passwordInput.classList.add('is-invalid');
    }
}