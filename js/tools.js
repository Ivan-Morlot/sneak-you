function checkEmail(id1, id2) {
    generalCheck(id1, id2, "L'e-mail doit correspondre.")
}

function checkPassword(id1, id2) {
    generalCheck(id1, id2, "Le mot de passe doit correspondre.");
}

function generalCheck(id1, id2, t) {
    target = document.getElementById(id1);
    diff = document.getElementById(id2);
    if (target.value !== diff.value && target.value != "") {
        target.setCustomValidity(t);
    } else {
        target.setCustomValidity('');
    }
}

function checkPhoneNumber(input) {
    if (isNaN(input.value) || input.value.length < 10 && input.value != "") {
        input.setCustomValidity('Veuillez renseigner un numéro valide.');
    } else {
        input.setCustomValidity('');
    }
}

function checkPostalCode(input) {
    if (isNaN(input.value) || input.value.length < 5 && input.value != "") {
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