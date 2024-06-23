
export const  setAriaAttributes = (hidden, tabindex,element)=> {
    element.setAttribute("aria-hidden", hidden);
    element.setAttribute("tabindex", tabindex);
  }
  