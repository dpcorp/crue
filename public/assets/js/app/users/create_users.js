const btnCreate = document.querySelector('#btn-create');

function validatePassword() {
    const password = document.getElementById('password');
    const passwordError = document.getElementById('password-error');
    const passwordValue = password.value;
    const passwordPattern = /^(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{6,}$/;

    if (!passwordPattern.test(passwordValue)) {
        password.classList.add('is-invalid');
        password.classList.remove('is-valid');
        passwordError.textContent =
            'La contraseña debe contener al menos una letra mayúscula, un número, un carácter especial y tener al menos 6 caracteres';
    } else {
        password.classList.add('is-valid');
        password.classList.remove('is-invalid');
        passwordError.textContent = '';
    }

    validateConfirmPassword(); // Asegura que la confirmación de contraseña se vuelva a validar
}

function validateConfirmPassword() {
    const password = document.getElementById('password');
    const confirmPassword = document.getElementById('confirm-password');
    const confirmPasswordError = document.getElementById('confirm-password-error');
    const passwordValue = password.value;
    const confirmPasswordValue = confirmPassword.value;
    const passwordPattern = /^(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{6,}$/;

    if (!passwordPattern.test(passwordValue) || passwordValue !== confirmPasswordValue) {
        confirmPassword.classList.add('is-invalid');
        confirmPassword.classList.remove('is-valid');
        if (passwordValue !== confirmPasswordValue) {
            confirmPasswordError.textContent = 'Las contraseñas no coinciden';
        } else {
            confirmPasswordError.textContent = '';
        }
        btnCreate.disabled = true;
    } else {
        confirmPassword.classList.add('is-valid');
        confirmPassword.classList.remove('is-invalid');
        confirmPasswordError.textContent = '';
        btnCreate.disabled = false;
    }
}

// function submitForm() {
//     validatePassword();
//     validateConfirmPassword();

//     const password = document.getElementById('password');
//     const confirmPassword = document.getElementById('confirm-password');

//     if (password.classList.contains('is-valid') && confirmPassword.classList.contains('is-valid')) {
//         document.getElementById('create-user-form').submit();
//     } else {
//         alert('Por favor, corrija los errores antes de enviar el formulario');
//     }
// }