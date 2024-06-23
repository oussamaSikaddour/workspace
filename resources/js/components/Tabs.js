


const whenTriggerIsActive = (index,isActive,triggers,panels)=>{
  triggers[index].setAttribute("aria-selected", isActive);
  triggers[index].setAttribute("tabindex", isActive ? "0" : "-1");
  panels[index].setAttribute("tabindex", isActive ? "0" : "-1");
  triggers[index].classList.toggle("active", isActive);
  panels[index].style.display = isActive ? "flex" : "none";

}


const handelPressedTrigger = (index, tabTriggers,tabPanels)=>{
  tabTriggers.forEach((__ ,i) => {
      const isActive = index === i;
      whenTriggerIsActive(i,isActive,tabTriggers,tabPanels)
        });
tabTriggers[index].focus();
}


const handelActiveTrigger=(index,tabTriggers,tabPanels)=>{
  {
      const isActive = tabTriggers[index].classList.contains("active");
      whenTriggerIsActive(index,isActive,tabTriggers,tabPanels)
      if (isActive) tabTriggers[index].focus();
    }
}


export const updateTabTriggerStates = (tabTriggers,tabPanels) => {
  tabTriggers.forEach((__, i) =>  handelActiveTrigger(i,tabTriggers,tabPanels))
};

export  const handleTabTriggersKeyEvents = (event, index,tabTriggers,tabPanels) => {
    const { key } = event;
    const currentIndex = index;
    const lastIndex = tabTriggers.length - 1;
    switch (key) {
      case 'ArrowRight':
        event.preventDefault();
        if (currentIndex < lastIndex) {
          handelPressedTrigger(currentIndex + 1,tabTriggers,tabPanels);
        }
        break;
      case 'ArrowLeft':
        event.preventDefault();
        if (currentIndex > 0) {
          handelPressedTrigger(currentIndex - 1,tabTriggers,tabPanels);
        }
        break;
      default:
        break;
    }
  };



