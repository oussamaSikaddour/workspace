import { toggleInertForAllExceptOpenedElement } from '../traits/Inert';
import { setAriaAttributes } from '../traits/Aria';
import { debounce } from '../traits/general';

 const toggleViewerFilter = (isOpen) => {
  const viewerFilter = document.querySelector(".filter");

  if (!viewerFilter) return;

  const openButton = document.querySelector(".filter__opener");
  const closeButton = document.querySelector(".filter__closer");

  if (isOpen) {
    viewerFilter.classList.add("open");
    if (openButton) openButton.style.display = "none";
    if (closeButton) closeButton.style.display = "inline-flex";
    setAriaAttributes(true, "-1", viewerFilter);
  } else {
    viewerFilter.classList.remove("open");
    if (openButton) openButton.style.display = "inline-flex";
    if (closeButton) closeButton.style.display = "none";
    setAriaAttributes(false, "0", viewerFilter);
  }

  toggleInertForAllExceptOpenedElement(viewerFilter.parentElement, "open");
};

const Filter = () => {
  const openButton = document.querySelector(".filter__opener");
  const closeButton = document.querySelector(".filter__closer");

  if (openButton) {
    openButton.addEventListener("click", () => toggleViewerFilter(true));
  }

  if (closeButton) {
    closeButton.addEventListener("click", () => toggleViewerFilter(false));
  }
};







export default Filter;