export const handleKeyEvents = (event, index, keyFunctionHandler = null, htmlElementsArray, escapeFunction = null) => {
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
          keyFunctionHandler();
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