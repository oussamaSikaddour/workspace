
import { focusNonHiddenInput } from './Form.js';



const Loader =()=>{

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
}

export default Loader;
