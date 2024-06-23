export const  getBaseURL = (url) =>{
    // Use new URL object for reliable parsing
    const parsedURL = new URL(url);
    // Return the origin (protocol + hostname + port, if specified)
    return parsedURL.origin;
  }


  export const debounce = (func, wait) => {
    let timeout;
    return (...args) => {
      clearTimeout(timeout);
      timeout = setTimeout(() => func?.apply(this, args), wait);
    };
  };

  export const getBackgroundColor = (element) => {
    // Get the computed style object for the element
    const computedStyle = window.getComputedStyle(element);
    return computedStyle.backgroundColor;
  };
export const  adjustElementPosition =(element)=> {
    const elementRect = element.getBoundingClientRect();
    if (elementRect.right > window.innerWidth) {
      const translateX = window.innerWidth - elementRect.right - 10; // 10px padding from the edge
      element.style.transform = `translateX(${translateX}px)`;
    } else if (elementRect.left < 0) {
      const translateX = -elementRect.left + 10; // 10px padding from the edge
      element.style.transform = `translateX(${translateX}px)`;
    } else {
      element.style.transform = 'translateX(0)';
    }
  }
