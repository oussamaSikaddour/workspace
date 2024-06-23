import { focusNonHiddenInput } from "../components/Form";
import despatchCustomEvent from "../traits/DespatchCustomEvent";


export const forgetPasswordFirstForm= ()=>{


document.addEventListener('forget-password-first-step-succeeded', function(event) {
    const {email}= event.detail
    despatchCustomEvent("email-forget-password-is-set",{email})
    const forgetPasswordFirstForm = document.querySelector(".form--1");
    const forgetPasswordSecondForm = document.querySelector(".form--2");
    const forgetPasswordForms = document.querySelector(".forms");
    forgetPasswordForms.classList.add("slide");
    forgetPasswordFirstForm.setAttribute("inert", "");
    forgetPasswordSecondForm.removeAttribute("inert");
    setTimeout(() => {
    focusNonHiddenInput(forgetPasswordSecondForm);
}, 500);
 })

}



export const forgetPasswordSecondForm = ()=>{
 document.addEventListener('forget-password-second-step-succeeded', function(event) {
    const forgetPasswordForms = document.querySelector(".forms");
    const forgetPasswordFirstForm = document.querySelector(".form--1");
    const forgetPasswordSecondForm= document.querySelector(".form--2");
       forgetPasswordForms.classList.remove("slide");
        forgetPasswordSecondForm.setAttribute("inert", "");
        forgetPasswordFirstForm.removeAttribute("inert");

 })
}
