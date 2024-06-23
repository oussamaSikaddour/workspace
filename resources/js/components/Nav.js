import {handleKeyEvents} from "../traits/KeyEventHandlers";
import { toggleInertForChildElement } from "../traits/Inert";
import { inView } from "../traits/IntersectionObserver";
const toggleSubMenuPhoneInert = (dropDownMenu) => {
  const menuItems= dropDownMenu.querySelector(".nav__items--sub")
  toggleInertForChildElement(dropDownMenu,menuItems,"clicked",true)
}

const toggleNavSubMenuVisibility = (navButton) => {
  const subItems = navButton.nextElementSibling;
  if (subItems) {
    const isExpanded = navButton.classList.contains("clicked");
    navButton.setAttribute("aria-expanded", isExpanded);
    navButton.setAttribute("aria-hidden", !isExpanded);
    navButton.toggleAttribute("hidden", !isExpanded);
  }

};

const toggleNavButtonVisibility = (index,navButtons) => {
  const currentNavButton = navButtons[index];
  navButtons.forEach((navButton, i) => {
    if (navButton !== currentNavButton) {
      navButton.classList.remove("clicked");
      navButton.parentElement.classList.remove("clicked");
    }else{
    navButton.classList.toggle("clicked");
    navButton.parentElement.classList.toggle("clicked");
    }
    toggleNavSubMenuVisibility(navButton);
    toggleSubMenuPhoneInert( navButton.parentElement)
  });
};


const quiteMenu = (index,navButtons) => {
 toggleNavButtonVisibility(index,navButtons);
  navButtons[index].focus()
};

const handleMenuItemKeyDown = (index,navButtons) => {
  const menu = navButtons[index].nextElementSibling;
  const menuItems = Array.from(menu.querySelectorAll("[role='menuitem']"));
  menuItems[0]?.focus();

  menu.addEventListener('keydown', (event) => {
    const pressedItem = event.target.closest('[role="menuitem"]');
    const i = menuItems.indexOf(pressedItem);
    handleKeyEvents(event, i, null, menuItems,()=>quiteMenu(index,navButtons));
  });
};


const manageDropDownNavButtons = (navButtons)=>{
  navButtons.forEach((navButton, index) => {

    navButton.addEventListener('click', () => toggleNavButtonVisibility(index,navButtons));
    navButton.addEventListener('keydown', (e) => {
      if (e.code === 'Space' || e.code === 'Enter') {
        toggleNavButtonVisibility(index,navButtons);
      }
      if (navButton.classList.contains("clicked")) {
        handleMenuItemKeyDown(index,navButtons);
      }
    });
  });
}


const manageInertSubNavMenuState = (dropDownMenus)=>{
  dropDownMenus?.forEach(d=>toggleSubMenuPhoneInert(d))
}


const toggleNavPhoneMenu =(HumBtn,navPhone)=>{
  HumBtn.classList.toggle("open")
  navPhone.classList.toggle("open")
if (navPhone) {
  const expanded = HumBtn.classList.contains('open');
  HumBtn.setAttribute("aria-expanded", expanded);
  HumBtn.setAttribute("aria-hidden", !expanded);
  navPhone.toggleAttribute("hidden", !expanded);
}
}



const toggleTransparentClass = (isInView) => {
    const nav = document.querySelector(".nav");
    if (isInView) {

        nav.classList.add('transparent');
    } else {
      nav.classList.remove('transparent');
    }
  };

  const manageSectionOnScroll = (isInView, { id }) => {
    const navLink = document.querySelector(`.nav a[href="#${id}"]`);
    const navPhoneLink = document.querySelector(`.nav--phone a[href="#${id}"]`);
    if(!navLink || !navPhoneLink){
        return;
      }

    if (isInView) {
      const navLinks = document.querySelectorAll('nav a');
      const navPhoneLinks = document.querySelectorAll('nav--phone a');

      navLinks.forEach(nl => nl.parentElement.classList.remove('active'));
      navPhoneLinks.forEach(nl => nl.parentElement.classList.remove('active'));

      navLink.parentElement.classList.add('active');
      navPhoneLink.parentElement.classList.add('active');

      const section = document.getElementById(id);
      const hasAnimate = section?.classList.contains('animate');

      if (!hasAnimate) {
        section.classList.add('animate');
      }
    } else {
      navLink.parentElement.classList.remove('active');
      navPhoneLink.parentElement.classList.remove('active');
    }
  };
  const Navigation =()=>{
    const navButtons = Array.from(document.querySelectorAll(".nav__btn--dropdown"));
    const HumBtn = document.querySelector(".nav__humb");
    const navPhone= document.querySelector(".nav--phone")
    const hero = document.querySelector(".hero");
    const  aboutUs= document.getElementById("aboutUs");
    const  contactUs= document.getElementById("contactUs");
    const  trainings= document.getElementById("trainings");
    const  products= document.getElementById("products");
    const  classRooms= document.getElementById("classRooms");

    const dropDownMenus = document.querySelectorAll(".nav--phone .nav__item--dropDown")
    HumBtn?.addEventListener('click', () => {
        toggleNavPhoneMenu(HumBtn,navPhone)
    });
    manageDropDownNavButtons(navButtons)
    manageInertSubNavMenuState(dropDownMenus)

    inView(hero,75,toggleTransparentClass)
    inView(hero, 90, manageSectionOnScroll, { id: "hero" })
    inView(aboutUs, 90, manageSectionOnScroll, { id: "aboutUs" })
    inView(trainings, 90, manageSectionOnScroll, { id: "trainings" })
    inView(classRooms, 90, manageSectionOnScroll, { id: "classRooms" })
    inView(products, 90, manageSectionOnScroll, { id: "products" })
    inView(contactUs, 90, manageSectionOnScroll, { id: "contactUs" })
    const heroLink = document.querySelector(`.nav--phone a[href="#hero"]`);

if(heroLink){
  heroLink.click()
}

    }
export default Navigation;
