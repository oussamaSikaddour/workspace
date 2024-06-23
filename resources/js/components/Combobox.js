import { setAriaAttributes } from "../traits/Aria";
import { debounce } from "../traits/general";

const setListItemAttributes = (currentListItem, input, listItems) => {
  input.value = currentListItem.textContent.trim();
  currentListItem.setAttribute('tabindex', '0');
  currentListItem.classList.add('active');
  currentListItem.focus();
  listItems.forEach((item) => {
    if (item !== currentListItem) {
      item.classList.remove('active');
      item.setAttribute('tabindex', '-1');
    }
  });
};

const handleKeyEvents = (event, currentIndex, listBoxNode, buttonNode, input, state) => {
  const { key } = event;
  const listItems = Array.from(listBoxNode.querySelectorAll('li:not(.hide)'));
  const lastIndex = listItems.length - 1;
  const index = currentIndex < 0 ? 0 : currentIndex > lastIndex ? lastIndex : currentIndex;

  switch (key) {
    case 'Escape':
    case 'Enter':
    case ' ':
      event.preventDefault();
      closeListbox(listBoxNode, buttonNode, input, state);
      break;
    case 'ArrowDown':
      event.preventDefault();
      setListItemAttributes(listItems[index < lastIndex ? index + 1 : 0], input, listItems);
      break;
    case 'ArrowUp':
      event.preventDefault();
      setListItemAttributes(listItems[index > 0 ? index - 1 : lastIndex], input, listItems);
      break;
    case 'Home':
      event.preventDefault();
      setListItemAttributes(listItems[0], input, listItems);
      break;
    case 'End':
      event.preventDefault();
      setListItemAttributes(listItems[lastIndex], input, listItems);
      break;
    default:
      break;
  }
};

const focusFirstItemOnArrowDown = (input, listBoxNode) => {
  input.addEventListener('keydown', (event) => {
    if (event.key === 'ArrowDown') {
      event.preventDefault();
      const firstItem = listBoxNode.querySelector('li:not(.hide)');
      const listItems = listBoxNode.querySelectorAll('li');
      setListItemAttributes(firstItem, input, listItems);
    }
  });
};

const handleOutsideClick = (event, comboboxNode,listBoxNode, buttonNode,input,state) => {
  if (!comboboxNode.contains(event.target) && state.isOpen) {
    closeListbox(listBoxNode, buttonNode, input, state);
    const activeItem = listBoxNode.querySelector('li.active');
    if (activeItem) {
      activeItem.classList.remove('active');
      activeItem.setAttribute('tabindex', '-1');
    }
  }
};

const handleListItemKeyDown = (input, listBoxNode, buttonNode, state) => {
  listBoxNode.addEventListener('keydown', (event) => {
    const pressedItem = event.target.closest('li');
    if (pressedItem) {
      const listItems = Array.from(listBoxNode.querySelectorAll("li"));
      const currentIndex = listItems.indexOf(pressedItem);
      handleKeyEvents(event, currentIndex, listBoxNode, buttonNode, input, state);
    }
  });
};

const openListbox = (listBoxNode, buttonNode, input, state) => {

  filterOptions(input.value, listBoxNode);
  const allItemsHidden = Array.from(listBoxNode.querySelectorAll('li')).every(item => item.classList.contains('hide'));
  if (!allItemsHidden) {
    listBoxNode.classList.add('open');
  }
  setAriaAttributes("false", 0, listBoxNode);
  input.setAttribute('aria-expanded', 'true');
  buttonNode.setAttribute('aria-expanded', 'true');
  state.isOpen = true;
};

const closeListbox = (listBoxNode, buttonNode, input, state) => {
  listBoxNode.classList.remove('open');
  setAriaAttributes("true", -1, listBoxNode);
  input.setAttribute('aria-expanded', 'false');
  buttonNode.setAttribute('aria-expanded', 'false');
  state.isOpen = false;
  listBoxNode.querySelectorAll("li").forEach(item => {
    item.classList.remove('active');
    item.setAttribute('tabindex', '-1');
  });
};

const filterOptions = (inputValue, listBoxNode) => {
  const filter = inputValue.toLowerCase();
  const items = listBoxNode.querySelectorAll('li');
  let hasVisibleItems = false;

  items.forEach(item => {
    const text = item.textContent.toLowerCase();
    if (text.startsWith(filter)) {
      item.classList.remove('hide');
      hasVisibleItems = true;
    } else {
      item.classList.add('hide');
    }
  });

  listBoxNode.classList.toggle('open', hasVisibleItems);
};

const initializeComboboxAutocomplete = (comboboxNode, listBoxNode, buttonNode) => {
  const input = comboboxNode.querySelector('.input');
  const state = { isOpen: false };

  const handleInput = debounce((event) => {
    const inputValue = event.target.value.trim();
    filterOptions(inputValue, listBoxNode);
  }, 300);

  const handleFocusIn = () => openListbox(listBoxNode, buttonNode, input, state);
  const handleFocusOut = (event) => {
    if (!listBoxNode.contains(event.relatedTarget) &&
      !comboboxNode.contains(event.relatedTarget) &&
      !buttonNode.contains(event.relatedTarget) &&
      state.isOpen) {
      closeListbox(listBoxNode, buttonNode, input, state);
    }
  };

  const handleItemClick = (event) => {
    if (event.target.tagName === 'LI') {
      input.value = event.target.textContent.trim();
      filterOptions(event.target.textContent.trim(), listBoxNode);
      closeListbox(listBoxNode, buttonNode, input, state);
    }
  };

  comboboxNode.addEventListener('focusin', handleFocusIn);
  comboboxNode.addEventListener('focusout', handleFocusOut);
  input.addEventListener('input', handleInput);
  listBoxNode.addEventListener('click', handleItemClick);
  focusFirstItemOnArrowDown(input, listBoxNode);
  handleListItemKeyDown(input, listBoxNode, buttonNode, state);
  document.addEventListener('click',(event)=>handleOutsideClick(event, comboboxNode,listBoxNode, buttonNode,input,state));

};

const Combobox = () => {
  const comboboxNodes = document.querySelectorAll('.combobox__input');

  comboboxNodes.forEach((comboboxNode) => {
    const listBoxNode = comboboxNode.parentElement.querySelector('ul[role="listbox"]');
    const buttonNode = comboboxNode.querySelector('button');
    if (listBoxNode && buttonNode) {
      initializeComboboxAutocomplete(comboboxNode, listBoxNode, buttonNode);
    }
  });
};

export default Combobox;
