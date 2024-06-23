import { focusNonHiddenInput } from "../components/Form";
import { handleTabTriggersKeyEvents, updateTabTriggerStates } from "../components/Tabs";
import despatchCustomEvent from "../traits/DespatchCustomEvent";






export const manageUserModalTabs = ()=>{
document.addEventListener('user-modal-tabs-event', function(event) {
despatchCustomEvent('fil-upload');
 const userForm = document.querySelector('.form');
focusNonHiddenInput(userForm);
const userTabsTriggers = userForm.querySelectorAll('.tab__trigger');
const userTabsPanels = userForm.querySelectorAll('.tab__panel');
userTabsTriggers.forEach((trigger, i) => {
trigger.addEventListener("click", () => {
 userTabsTriggers.forEach((t) => t.classList.remove('active'));
 trigger.classList.add('active');
 updateTabTriggerStates(userTabsTriggers, userTabsPanels);
});
trigger.addEventListener("keydown", (e) => {
if(e.key ==="ArrowRight" || e.key==="ArrowLeft"){
     handleTabTriggersKeyEvents(e,i,userTabsTriggers,userTabsPanels);
}
});
});
userTabsTriggers[0].click()
})
}
