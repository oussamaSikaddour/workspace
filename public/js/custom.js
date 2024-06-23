
const bodyChildren = document.body.children;


const focusNonHiddenInput = (form) => {
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



function clearErrorsOnFocus(myForm=null) {
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

  // Replace "clearErrorsOnChange()" with "clearErrorsOnFocus()" in your code


  // Example usage




const despatchCustomEvent= (eventName,data={})=>{
const setLocaleEvent = new CustomEvent(eventName, {
    detail: {
        data
    }
});
document.dispatchEvent(setLocaleEvent);
}

const handleKeyEvents = (event, index, keyFunctionHandler = null, htmlElementsArray, escapeFunction = null) => {
  const { key } = event;
  const currentIndex = index;
  const lastIndex = htmlElementsArray.length - 1;

  switch (key) {
    case 'Escape':
      if (escapeFunction) {
        event.preventDefault();
        escapeFunction();
      }
      break;
    case 'Enter':
    case ' ':
      if (keyFunctionHandler) {
        event.preventDefault();
        keyFunctionHandler(index);
      }
      break;
    case 'ArrowDown':
      event.preventDefault();
      if (currentIndex < lastIndex) {
        htmlElementsArray[currentIndex + 1].focus();
      }
      break;
    case 'ArrowUp':
      event.preventDefault();
      if (currentIndex > 0) {

        htmlElementsArray[currentIndex - 1].focus();
      }
      break;
    case 'Home':

      htmlElementsArray[0].focus();
      break;
    case 'End':
      htmlElementsArray[lastIndex].focus();
      break;
    default:
      break;
  }
};


const  setAriaAttributes = (hidden, tabindex,element)=> {
  element.setAttribute("aria-hidden", hidden);
  element.setAttribute("tabindex", tabindex);
}

const toggleInert = (element, state = false) => {
      if (state) {
          element.setAttribute("inert", "");
      } else {
          element.removeAttribute("inert");
      }
};

const toggleInertWhenState = (element, className,invertState=false) => {
    const hasClassName = element.classList.contains(className);
    toggleInert(element, invertState ? !hasClassName : hasClassName);
};

const toggleInertForChildElement = (element, childElement, className, invertState = false) => {
  const hasClassName = element.classList.contains(className);
  toggleInert(childElement, invertState ? !hasClassName : hasClassName);
};



const toggleInertForAllExceptOpenedElement = (openedElement, className,invertState=false) => {
  const elementState = openedElement.classList.contains(className);
  [...bodyChildren].forEach((element) => {
    if (element !== openedElement) {

      if (invertState ? !elementState: elementState) {
        element.setAttribute("inert", "");
      } else {
        element.removeAttribute("inert");
      }
    }
  });
};


/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
const loaderContainer = document.createElement('div');
loaderContainer.className = 'loader__container';
const loader = document.createElement('div');
loader.className = 'loader l';
const loaderCircle1 = document.createElement('div');
loaderCircle1.className = 'loader__circle';
const loaderCircle2 = document.createElement('div');
loaderCircle2.className = 'loader__circle';
loader.appendChild(loaderCircle1);
loader.appendChild(loaderCircle2);

loaderContainer.appendChild(loader);
document.body.appendChild(loaderContainer);

document.addEventListener('DOMContentLoaded', function() {
  loaderContainer.classList.add('hide');

  const currentForm= document.querySelector(".form");
  if(currentForm){
    focusNonHiddenInput(currentForm);
  }

});



/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////                                                                                 toolTip
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
const buttonsWithTooltip = document.querySelectorAll(".hasToolTip");
const showToolTip = (toolTip, parent) => {
  toolTip.classList.add("show");
  parent.setAttribute("aria-expanded", true);
  toolTip.setAttribute("aria-hidden", false);
};

const hideToolTip = (toolTip, parent) => {
  toolTip.classList.remove("show");
  parent.setAttribute("aria-expanded", false);
  toolTip.setAttribute("aria-hidden", true);
};

buttonsWithTooltip.forEach(button => {
  const toolTip = button.querySelector(".toolTip");
  if (toolTip) {
    button.addEventListener('mouseover', () => {
      showToolTip(toolTip, button);
    });
    button.addEventListener('mouseout', () => {
      hideToolTip(toolTip, button);
    });
  }
});



/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////                                                                                 Nav
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


const navButtons = Array.from(document.querySelectorAll(".nav__btn--dropdown"));
  const HumBtn = document.querySelector(".nav__humb");
  const navPhone= document.querySelector(".nav--phone")

const dropDownMenus = document.querySelectorAll(".nav--phone .nav__item--dropDown")
const toggleSubMenuPhoneInert = (dropDownMenu) => {
  const menuItems= dropDownMenu.querySelector(".nav__items--sub")
  toggleInertForChildElement(dropDownMenu,menuItems,"clicked",true)
}

  HumBtn?.addEventListener('click', () => {
    HumBtn.classList.toggle("open")
    navPhone.classList.toggle("open")
  if (navPhone) {
    const expanded = HumBtn.classList.contains('open');
    HumBtn.setAttribute("aria-expanded", expanded);
    HumBtn.setAttribute("aria-hidden", !expanded);
    navPhone.toggleAttribute("hidden", !expanded);
  }
});



const toggleNavSubMenuVisibility = (navButton) => {
  const subItems = navButton.nextElementSibling;
  if (subItems) {
    const isExpanded = navButton.classList.contains("clicked");
    navButton.setAttribute("aria-expanded", isExpanded);
    navButton.setAttribute("aria-hidden", !isExpanded);
    navButton.toggleAttribute("hidden", !isExpanded);
  }

};

const toggleNavButtonVisibility = (index) => {
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


const quiteMenu = (index) => {
 toggleNavButtonVisibility(index);
  navButtons[index].focus()
};

const handleMenuItemKeyDown = (index) => {
  const menu = navButtons[index].nextElementSibling;
  const menuItems = Array.from(menu.querySelectorAll("[role='menuitem']"));
  menuItems[0]?.focus();

  menu.addEventListener('keydown', (event) => {
    const pressedItem = event.target.closest('[role="menuitem"]');
    const i = menuItems.indexOf(pressedItem);
    handleKeyEvents(event, i, null, menuItems,()=>quiteMenu(index));
  });
};

navButtons.forEach((navButton, index) => {
  navButton.addEventListener('click', () => toggleNavButtonVisibility(index));
  navButton.addEventListener('keydown', (e) => {
    if (e.code === 'Space' || e.code === 'Enter') {
      toggleNavButtonVisibility(index);
    }
    if (navButton.classList.contains("clicked")) {
      handleMenuItemKeyDown(index);
    }
  });
});


dropDownMenus?.forEach(d=>toggleSubMenuPhoneInert(d))



/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////                                                                                Lang
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

const initialLanguages = [
    { lang: 'En', flag: './img/en.png' },
    { lang: 'Fr', flag: './img/fr.png' },
    { lang: 'Ar', flag: './img/ar.png' },
  ];
const savedLanguage = localStorage.getItem('language') || 'Fr';
const langMenuContainer = document.querySelector(".lang__menu__container");
const langMenu = document.querySelector(".lang__menu");
const langBtn = document.querySelector(".lang__btn");
function setLanguagePreference(language) {
  localStorage.setItem('language', language);
  document.documentElement.classList.toggle('arabic', language === 'Ar');
}
const getIndexByLang = (languageCode) => initialLanguages.findIndex((language) => language.lang === languageCode);

const toggleMenu = () => {
  const isOpen = langMenu.classList.toggle("open");
  langBtn.setAttribute("aria-expanded", isOpen);
  langMenu.setAttribute("aria-hidden", !isOpen);
};

const populateLangMenu = (selectedLang) => {

  const index = getIndexByLang(selectedLang);
  langBtn.innerHTML = `
    <div class="lang">
      <p>${initialLanguages[index].lang}</p>
      <img src="${initialLanguages[index].flag}" alt="${initialLanguages[index].lang} language" />
    </div>
  `;


  const remainingLanguages = initialLanguages.filter((language) => language.lang !== selectedLang);
  langMenu.innerHTML = remainingLanguages.map(  (language) => `
    <li role="menuitem" class="lang__menu__item" tabindex="0">
      <div class="lang">
        <p>${language.lang}</p>
        <img src="${language.flag}" alt="${language.lang} language" />
      </div>
    </li>
  `).join("");
 setLanguagePreference(selectedLang);
};

const handleLangBtnClick = () => {
  toggleMenu();
  const langMenuItems = Array.from(document.querySelectorAll('.lang__menu__item'));
  langMenuItems[1]?.focus();
};

const selectLang = (index) => {
  const langMenuItems = Array.from(document.querySelectorAll('.lang__menu__item'));
  const selectedLang = langMenuItems[index]?.querySelector("p").textContent;
  populateLangMenu(selectedLang);
  toggleMenu();
  langBtn.focus();
  despatchCustomEvent('set-locale',{lang:selectedLang});
};

langMenuContainer?.addEventListener('keydown', (event) => {
  const langMenuItem = event.target.closest('.lang__menu__item');
  if (!langMenuItem) return;
  const langMenuItems = Array.from(document.querySelectorAll('.lang__menu__item'));
  const index = langMenuItems.indexOf(langMenuItem);
  handleKeyEvents(event, index, selectLang, langMenuItems);
});

langMenuContainer?.addEventListener('click', (event) => {
  const langMenuItem = event.target.closest('.lang__menu__item');
  if (!langMenuItem) return;
  const langMenuItems = Array.from(document.querySelectorAll('.lang__menu__item'));
  const index = langMenuItems.indexOf(langMenuItem);
  selectLang(index);
});

if (langBtn) {
  populateLangMenu(savedLanguage);
  langBtn.addEventListener('click', handleLangBtnClick);
}
setLanguagePreference(savedLanguage);
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////                                                                                ToggleCheckBox
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

const toggleCheckbox = (checkbox) => {

    checkbox.checked = !checkbox.checked;
    if (checkbox.getAttribute('aria-checked') === 'true') {
      checkbox.setAttribute('aria-checked', 'false');
    } else {
      checkbox.setAttribute('aria-checked', 'true');
    }
  };
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////                                                                                RadioBtn
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    const  checkRadio = (radio,radios=null) => {

        radios?.forEach(radio => {
        const radioInput = radio.querySelector("input[type='radio']");
          radioInput.checked = false;
          radioInput.setAttribute('aria-checked', 'false');
        });
        if (!radio.checked) {
          radio.checked = true;
      radio.setAttribute('aria-checked', 'true')
     }
    }

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////                                                                               Main Menu
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


    const mainMenuBtns = document.querySelectorAll(".menu__btn");
const menu = document.querySelector(".menu");

const IfMenuIsVisible = (btn) => {
  const expanded = btn.classList.contains("clicked");
  btn.setAttribute("aria-expanded", expanded);
  btn.setAttribute("aria-hidden", !expanded);
  btn.classList.toggle("clicked");
};


const toggleMenuVisibility = (btn) => {
  mainMenuBtns.forEach(b => {
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

const quiteMainMenu = (index) => {
  toggleMenuVisibility(mainMenuBtns[index]);
  mainMenuBtns[index].focus()
 };

 const handleMainMenuItemKeyDown = (index) => {
   const menuItems = Array.from(menu.querySelectorAll("[role='menuitem']"));

   menuItems[0]?.focus();
   menu.addEventListener('keydown', (event) => {
     const pressedItem = event.target.closest('[role="menuitem"]');
     const i = menuItems.indexOf(pressedItem);
     handleKeyEvents(event, i, null, menuItems,()=>quiteMainMenu(index));
   });
 };


mainMenuBtns?.forEach((btn ,index) => {
  btn.addEventListener('click', () => toggleMenuVisibility(btn));
  btn.addEventListener('keydown', (e) => {
    if (e.code === 'Space' || e.code === 'Enter') {
     e.preventDefault()
    toggleMenuVisibility(btn);
    if (btn.classList.contains("clicked")) {
      handleMainMenuItemKeyDown(index);
    }
    }
  });
});


if(menu){
toggleInertWhenState(menu,"open",true); // Set initial state of menu inertness
}

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////                                           tabs
/////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

const handleTabTriggersKeyEvents = (event, index, triggers, panels, handelFunction) => {
    const { key } = event;
    const currentIndex = index;
    const lastIndex = triggers.length - 1;

    switch (key) {
      case 'ArrowRight':
        event.preventDefault();
        if (currentIndex < lastIndex) {
          handelFunction(triggers, panels, currentIndex + 1);
          return currentIndex + 1; // Return the new index
        }
        break;
      case 'ArrowLeft':
        event.preventDefault();
        if (currentIndex > 0) {
          handelFunction(triggers, panels, currentIndex - 1);
          return currentIndex - 1; // Return the new index
        }
        break;
      default:
        break;
    }
 // Return the current index if no arrow keys pressed
  };

const whenTriggerIsActive = (index,isActive,triggers,panels)=>{
    triggers[index].setAttribute("aria-selected", isActive);
    triggers[index].setAttribute("tabindex", isActive ? "0" : "-1");
    panels[index].setAttribute("tabindex", isActive ? "0" : "-1");
    triggers[index].classList.toggle("active", isActive);
    panels[index].style.display = isActive ? "flex" : "none";

}
const handelPressedTrigger = (triggers,panels,index)=>{
    triggers.forEach((__ ,i) => {
        const isActive = index === i;
        whenTriggerIsActive(i,isActive,triggers,panels)
          });
 triggers[index].focus();
}
const handelActiveTrigger=(triggers,panels,index)=>{
    {
        const isActive = triggers[index].classList.contains("active");
        whenTriggerIsActive(index,isActive,triggers,panels)
        if (isActive) {
            triggers[index].focus()
        };
      }
}
const updateTabTriggerStates = (triggers,panels) => {
  triggers?.forEach((__, i) =>  handelActiveTrigger(triggers,panels,i))
};








