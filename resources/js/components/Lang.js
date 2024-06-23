
import { handleKeyEvents } from "../traits/KeyEventHandlers";
import despatchCustomEvent from "../traits/DespatchCustomEvent";
import { getBaseURL } from "../traits/general";

const setLanguagePreference = (language) => {
  localStorage.setItem('language', language);
  document.documentElement.classList.toggle('arabic', language === 'Ar');
};

const toggleMenu = (langBtn, langMenu) => {
  const isOpen = langMenu.classList.toggle("open");
  langBtn.setAttribute("aria-expanded", isOpen);
  langMenu.setAttribute("aria-hidden", !isOpen);
};

const getIndexByLang = (languageCode, initialLanguages) =>
  initialLanguages.findIndex((language) => language.lang === languageCode);

const populateLangMenu = (initialLanguages, selectedLang) => {
  const index = getIndexByLang(selectedLang, initialLanguages);
  const selectedLanguage = initialLanguages[index];

  const langMenus = document.querySelectorAll(".lang__menu");
  const langBtns = document.querySelectorAll(".lang__btn");

  const remainingLanguages = initialLanguages.filter((language) => language.lang !== selectedLang);

  langBtns.forEach((langBtn)=>{
    langBtn.innerHTML = `
    <div class="lang">
      <p>${selectedLanguage.lang}</p>
      <img src="${selectedLanguage.flag}" alt="${selectedLanguage.lang} language" />
    </div>
  `;
  langMenus.forEach(langMenu =>{
    langMenu.innerHTML = remainingLanguages.map((language) => `
    <li role="menuitem" class="lang__menu__item" tabindex="0">
      <div class="lang">
        <p>${language.lang}</p>
        <img src="${language.flag}" alt="${language.lang} language" />
      </div>
    </li>
  `).join("");
  })
  })

  setLanguagePreference(selectedLang);
};

const handleLangBtnClick = (langBtn, langMenu) => {
  toggleMenu(langBtn, langMenu);
  const langMenuItems = Array.from(langMenu.querySelectorAll('.lang__menu__item'));
  langMenuItems[1]?.focus();
};

const selectLang = (index, langBtn, langMenu, initialLanguages) => {
  const langMenuItems = Array.from(langMenu.querySelectorAll('.lang__menu__item'));
  const selectedLang = langMenuItems[index]?.querySelector("p").textContent;
  populateLangMenu(initialLanguages, selectedLang);
  toggleMenu(langBtn, langMenu);
  langBtn.focus();
  despatchCustomEvent('set-locale', { lang: selectedLang });
};

const manageLangMenuOnClickOrKeyDownEvents = (event, langBtn, langMenu, initialLanguages) => {
  const langMenuItem = event.target.closest('.lang__menu__item');
  if (!langMenuItem) return;
  const langMenuItems = Array.from(langMenu.querySelectorAll('.lang__menu__item'));
  const index = langMenuItems.indexOf(langMenuItem);

  if (event.type === "keydown") {
    handleKeyEvents(event, index, () => selectLang(index, langBtn, langMenu, initialLanguages), langMenuItems);
  } else if (event.type === "click") {
    selectLang(index, langBtn, langMenu, initialLanguages);
  }
};

const handleLangMenu = (langMenuContainer, initialLanguages) => {
  const langMenu = langMenuContainer.querySelector(".lang__menu");
  const langBtn = langMenuContainer.querySelector(".lang__btn");

  if (langBtn) {
    const selectedLang = localStorage.getItem('language') || 'Fr';
    populateLangMenu(initialLanguages, selectedLang);
    langBtn.addEventListener('click', () => handleLangBtnClick(langBtn, langMenu));
    setLanguagePreference(selectedLang);
  }

  langMenuContainer.addEventListener('keydown', (event) => {
    manageLangMenuOnClickOrKeyDownEvents(event, langBtn, langMenu, initialLanguages);
  });

  langMenuContainer.addEventListener('click', (event) => {
    manageLangMenuOnClickOrKeyDownEvents(event, langBtn, langMenu, initialLanguages);
  });
};

const Lang = () => {
    const currentURL = window.location.href;

 const currentURLOrigin= getBaseURL(currentURL)
  const initialLanguages = [
    { lang: 'Fr', flag: `${currentURLOrigin}/img/fr.png` },
    { lang: 'En', flag: `${currentURLOrigin}/img/En.png` },
    { lang: 'Ar', flag: `${currentURLOrigin}/img/ar.png` },
  ];

  const langMenuContainers = document.querySelectorAll(".lang__menu__container");

  langMenuContainers.forEach(langMenuContainer => {
    handleLangMenu(langMenuContainer, initialLanguages);
  });
};

export default Lang;
