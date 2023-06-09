import {createPortal} from 'react-dom'

const Errors = ({ isOpened, children,onClose}) => {
  if(!isOpened){
    return null;
  }
  return  createPortal(
<div className="error__container">
  <span className="error__close" onClick={onClose} >&times;</span>
  <ul className="errors">
 {children}
  </ul>
    </div>
    ,document.getElementById("errors")
  )
}

export default Errors