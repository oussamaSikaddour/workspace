import { focusNonHiddenInput } from "../components/Form";



export const  SPFirstFrom=()=>{
document.addEventListener('site-params-first-step-succeeded', function(event) {
const sitParamsFirstForm = document.querySelector(".form--1");
const sitParamsSecondForm = document.querySelector(".form--2");
const sitParamsForms = document.querySelector(".forms");
sitParamsForms.classList.add("slide");
sitParamsFirstForm.setAttribute("inert", "");
sitParamsSecondForm.removeAttribute("inert");
setTimeout(() => {
focusNonHiddenInput(sitParamsSecondForm);
}, 500);
});
}

