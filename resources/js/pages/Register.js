import { focusNonHiddenInput } from "../components/Form";
import despatchCustomEvent from "../traits/DespatchCustomEvent";





export const registerFirstForm= ()=>{

  document.addEventListener('register-first-step-succeeded', function(event) {
 const {email}= event.detail
 const registerFirstForm = document.querySelector(".form--1");
 const registerSecondForm = document.querySelector(".form--2");
 const registerForms = document.querySelector(".forms");
 registerForms.classList.add("slide");
localStorage.setItem('registration-email', email);
despatchCustomEvent('email-registration-is-set', {email});
registerFirstForm.setAttribute("inert", "");
registerSecondForm.removeAttribute("inert");
setTimeout(() => {
focusNonHiddenInput(registerSecondForm);
}, 500);
     })
}

export const registerSecondForm= ()=>{

  document.addEventListener('register-second-step-succeeded', function(event) {
    const registerFirstForm = document.querySelector(".form--1");
    const registerSecondForm = document.querySelector(".form--2");
    const registerForms = document.querySelector(".forms");
        registerForms.classList.remove("slide");
        localStorage.removeItem('registration-email');
        registerSecondForm.setAttribute("inert", "");
        registerFirstForm.removeAttribute("inert");
     })
}
