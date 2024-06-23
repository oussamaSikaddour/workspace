
import { toggleInertForAllExceptOpenedElement} from '../traits/Inert'
import { setAriaAttributes } from '../traits/Aria';
import { focusNonHiddenInput } from './Form';
import despatchCustomEvent from '../traits/DespatchCustomEvent';


const closeModal = (modal,openModalBtn) => {
    modal.classList.remove("open");
    const isOpen = modal.classList.contains("open");
    setAriaAttributes(!isOpen, isOpen ? "0" : "-1",modal);
    despatchCustomEvent('model-will-be-close');
    toggleInertForAllExceptOpenedElement(modal,"open")
    openModalBtn.focus();
     };




const Modal = ()=> {
document.addEventListener('open-modal-js', function(event) {
const openModalBtn = document.querySelector(".modal__opener");
const closeModalBtn = document.querySelector(".modal__closer");
const modal = document.querySelector(".modal");
modal.classList.add("open");
const isOpen = modal.classList.contains("open");
setAriaAttributes(!isOpen, isOpen ? "0" : "-1",modal);
toggleInertForAllExceptOpenedElement(modal,"open")
setTimeout(() => {
const modalForm = modal.querySelector(".form")
focusNonHiddenInput(modalForm);
}, 500);
 closeModalBtn.addEventListener("click",()=> closeModal(modal,openModalBtn));
})
}

export default Modal;
