function validateForm(fields) {
    let deleteButton = document.getElementById('deleteButton');
    if (deleteButton) {
        return true;
    }

    let isValid = true;

    fields.forEach(function(field) {
        let inputElement = document.getElementById(field);
        inputElement.classList.remove('invalid-input');

        if (inputElement.value.trim() === '') {
            inputElement.classList.add('invalid-input');
            isValid = false;
        }
    });

    return isValid;
}
