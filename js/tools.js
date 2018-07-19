function checkEmail(input) {
    if (input.value != document.getElementById('email').value && input.value != 0) {
        input.setCustomValidity('L\'e-mail doit correspondre.');
    } else {
        input.setCustomValidity('');
    }
}

function checkPassword(input) {
    if (input.value != document.getElementById('password').value && input.value != 0) {
        input.setCustomValidity('Le mot de passe doit correspondre.');
    } else {
        input.setCustomValidity('');
    }
}

function checkPhoneNumber(input) {
    if (isNaN(input.value) || input.value.length < 10 && input.value != 0) {
        input.setCustomValidity('Veuillez renseigner un numéro valide.');
    } else {
        input.setCustomValidity('');
    }
}

function checkPostalCode(input) {
    if (isNaN(input.value) || input.value.length < 5 && input.value != 0) {
        input.setCustomValidity('Veuillez renseigner un code postal valide.');
    } else {
        input.setCustomValidity('');
    }
}

document.addEventListener('click', function (e) {
    if (document.activeElement.toString() != '[object HTMLInputElement]' && document.activeElement.toString() != '[object HTMLTextAreaElement]' && document.activeElement.toString() != '[object HTMLSelectElement]') {
        document.activeElement.blur();
    }
});