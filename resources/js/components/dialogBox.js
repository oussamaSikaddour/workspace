
import {toggleInertForAllExceptOpenedElement} from '../traits/Inert'
import {setAriaAttributes} from '../traits/Aria'
import despatchCustomEvent from '../traits/DespatchCustomEvent';

const closeDialog = (dialog) => {
 dialog.classList.remove("open");
const isOpen = dialog.classList.contains("open");
 setAriaAttributes(!isOpen, isOpen ? "0" : "-1",dialog);
despatchCustomEvent('dialog-will-be-close');
toggleInertForAllExceptOpenedElement(dialog,"open")
 };


 const DialogBox = ()=>{
document.addEventListener('open-dialog-box', function(event) {
const boxCloser = document.querySelector(".box__closer");
const dialog = document.querySelector(".box");
dialog.classList.add("open");
const isOpen = dialog.classList.contains("open");
setAriaAttributes(!isOpen, isOpen ? "0" : "-1",dialog);
toggleInertForAllExceptOpenedElement(dialog,"open")
boxCloser.focus(); // Focus on the close button when the dialog opens

 boxCloser.addEventListener("click",()=>closeDialog(dialog));
})
document.addEventListener('close-dialog-box', function(event) {
    const dialog = document.querySelector(".box");
closeDialog(dialog);
})
}

export default DialogBox;
