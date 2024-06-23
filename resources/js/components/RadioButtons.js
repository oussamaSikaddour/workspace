export  const  checkRadio = (radio,radios=null) => {

    radios?.forEach(radio => {
    const radioInput = radio.querySelector("input[type='radio']");
      radioInput.checked = false;
      radioInput.setAttribute('aria-checked', 'false');
    });
    if (!radio.checked) {
      radio.checked = true;
  radio.setAttribute('aria-checked', 'true')
 }
}
