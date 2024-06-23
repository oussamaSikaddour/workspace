


 const toggleInert = (element, state = false) => {
    if (state) {
        element?.setAttribute("inert", "");
    } else {
        element?.removeAttribute("inert");
    }
};

export const toggleInertWhenState = (element, className,invertState=false) => {
  const hasClassName = element.classList.contains(className);
  toggleInert(element, invertState ? !hasClassName : hasClassName);
};

export const toggleInertForChildElement = (element, childElement, className, invertState = false) => {
const hasClassName = element.classList.contains(className);
toggleInert(childElement, invertState ? !hasClassName : hasClassName);
};



export const toggleInertForAllExceptOpenedElement = (openedElement, className,invertState=false) => {

const bodyChildren = document.body.children;
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

