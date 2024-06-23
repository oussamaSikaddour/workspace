import {  handleKeyEvents} from '../traits/KeyEventHandlers'
import { toggleInertWhenState} from '../traits/Inert'
const IfMenuIsVisible = (btn) => {
  const expanded = btn.classList.contains("clicked");
  btn.setAttribute("aria-expanded", expanded);
  btn.setAttribute("aria-hidden", !expanded);
  btn.classList.toggle("clicked");
};


const toggleMenuVisibility = (btn, mainMenuButtons,menu) => {
  mainMenuButtons.forEach(b => {
    if (b !== btn) {
      b.classList.remove("clicked");
    }
    IfMenuIsVisible(b);
  });
  menu.classList.toggle("open");
  btn.classList.toggle("clicked");
  IfMenuIsVisible(btn);
  toggleInertWhenState(menu, "open",true);
};

const quiteMainMenu = (index, mainMenuButtons,menu) => {
  toggleMenuVisibility(mainMenuButtons[index],mainMenuButtons,menu);
  mainMenuButtons[index].focus()
 };
 
 const handleMainMenuItemKeyDown = (index,mainMenuButtons,menu) => {
   const menuItems = Array.from(menu.querySelectorAll("[role='menuitem']"));

   menuItems[0]?.focus();
   menu.addEventListener('keydown', (event) => {
     const pressedItem = event.target.closest('[role="menuitem"]');
     const i = menuItems.indexOf(pressedItem);
     handleKeyEvents(event, i, null, menuItems,()=>quiteMainMenu(index,mainMenuButtons,menu));
   });
 };



 // Set initial state of menu inertness



const  MainMenu = () =>{
const mainMenuButtons = document.querySelectorAll(".menu__btn");
const menu = document.querySelector(".menu");

if(menu) {
mainMenuButtons?.forEach((btn ,index) => {
  btn.addEventListener('click', () => toggleMenuVisibility(btn,mainMenuButtons,menu));
  btn.addEventListener('keydown', (e) => {
    if (e.code === 'Space' || e.code === 'Enter') {
     e.preventDefault()
    toggleMenuVisibility(btn,mainMenuButtons,menu);
    if (btn.classList.contains("clicked")) {
      handleMainMenuItemKeyDown(index,mainMenuButtons,menu);
    }
    }
  });
});

toggleInertWhenState(menu,"open",true);
}

}


export default MainMenu