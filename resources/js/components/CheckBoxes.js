

export const toggleCheckbox = (checkbox) => {

    checkbox.checked = !checkbox.checked;
    if (checkbox.getAttribute('aria-checked') === 'true') {
      checkbox.setAttribute('aria-checked', 'false');
    } else {
      checkbox.setAttribute('aria-checked', 'true');
    }
}
