     
import {toggleInertForChildElement} from '../traits/Inert'

export const focusNonHiddenInput = (form) => {
    if (!form || !form.tagName || form.tagName.toLowerCase() !== 'form') {
      return;
    }
   
    let currentInput = form.querySelector('input'); // Start with the first input
   
    while (currentInput) {
      const focusableLabel = currentInput.nextElementSibling?.matches('label[tabindex="0"]'); //
      if (focusableLabel) {
       currentInput.nextElementSibling.focus();
        return;
      } else if (!currentInput.matches('[style*="display: none"]') && !currentInput.hasAttribute('hidden')) {
        currentInput.focus();
        return;
      } else {
        currentInput = currentInput.nextElementSibling;
      }
    }
   };
   
   
   
export function clearErrorsOnFocus(myForm=null) {
       myForm = myForm ? myForm : document.querySelector('.form');
       const inputs = myForm.querySelectorAll('input, select, textarea');
       inputs.forEach(input => {
         input.addEventListener('focus', () => {
           // Get all elements with the class "input__error"
           const errors = myForm.querySelectorAll('.input__error');
   
           // Loop through each error element and set its innerHTML to an empty string
           errors.forEach(error => {
             error.innerHTML = '';
           });
         });
       });
     }
   
   
   



export const slide  = ()=>{
const slideFormBtn = document.querySelector(".slideFormBtn");
const forms = document.querySelector('.forms');
const form2 = document.querySelector(".form--2");
if (slideFormBtn) {
  slideFormBtn.addEventListener('click', (e) => {
    e.preventDefault();
    forms.classList.toggle('slide');
    toggleInertForChildElement(forms,form2,"slide",true);
  });

  toggleInertForChildElement(forms,form2,"slide",true);
}


}