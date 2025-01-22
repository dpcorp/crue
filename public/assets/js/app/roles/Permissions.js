const toggleCheckboxes = (key) => {
    const checkboxes = document.querySelectorAll(`.all_${key}`);
    const masterCheckbox = document.querySelector(`#${key}_all`);
    const isChecked = masterCheckbox.checked;
    checkboxes.forEach(function (checkbox) {
        checkbox.checked = isChecked;
    });
}