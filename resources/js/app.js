import './bootstrap';

import {clearErrorsOnFocus}from "./components/Form.js"
import Lang from './components/Lang.js';
import Navigation from './components/Nav.js';
import Loader from './components/Loader.js';
import Tooltip from './components/Tooltip.js';
import {toggleCheckbox}from './components/CheckBoxes.js'
import {checkRadio} from './components/RadioButtons'
import DialogBox from './components/dialogBox.js';
import FileInput from './components/fileUpload.js';
import MainMenu from './components/mainMenu.js';
import Modal from './components/modal.js';
import { SPFirstFrom } from './pages/SiteParams.js';
import { setAriaAttributes } from './traits/Aria.js';
import { forgetPasswordFirstForm, forgetPasswordSecondForm } from './pages/ForgetPassword.js';
import { registerFirstForm, registerSecondForm } from './pages/Register.js';
import { manageUserModalTabs } from './modals/user.js';
import { toggleInertForAllExceptOpenedElement } from './traits/Inert.js';
import Carousel from './components/Carousel.js';
import Scroller from './components/Scroller.js';
import Showcase from './components/Showcase.js';
import Combobox from './components/Combobox.js';
import Filter from './components/Filter.js';
import Table from './components/Table.js';




Lang();
Navigation();
Loader();
Modal();
MainMenu();
DialogBox();
FileInput();
SPFirstFrom()
forgetPasswordFirstForm();
forgetPasswordSecondForm();
registerFirstForm();
registerSecondForm();
manageUserModalTabs();
Carousel()
Scroller()
Combobox()
Filter()
Table()
Tooltip()

document.addEventListener('select_tooltip',()=>{
    Tooltip()
})

document.addEventListener('clear-form-errors-on-focus', function(event) {
const form = event.detail?.form
console.log(form);
if(form){
    clearErrorsOnFocus(form)
}else{
    clearErrorsOnFocus()
}
})


document.addEventListener('radio-button-checked-event', function(event) {
const {radioButton} = event.detail
if(radioButton){
    checkRadio(radioButton)
}
})
document.addEventListener('radio-button-checked-event', function(event) {
const {checkBox} = event.detail
console.log(checkBox)
if(checkBox){
    toggleCheckbox(checkBox)
}
})
document.addEventListener('set-aria-attributes-event', function(event) {
const {hidden,tabIndex,element} = event.detail
 setAriaAttributes(hidden,tabIndex,element)
})
document.addEventListener('toggle-inert-for-all-except-opened-element', function(event) {
const {element,className} = event.detail
toggleInertForAllExceptOpenedElement(element, className)
})


Showcase();

