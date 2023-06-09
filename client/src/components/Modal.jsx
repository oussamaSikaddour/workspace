
import { memo } from 'react';
import {createPortal} from 'react-dom'

const Modal = ({variant , title, isOpened, children,onClose}) => {

  if(!isOpened){
    return null;
  }
  return  createPortal(
<div  className="modal">
<div className={variant?"modal__content "+variant :"modal__content"}>
  <div className="modal__header">
    <span className="modal__close" onClick={onClose} >&times;</span>
    <h2>{title}</h2>
  </div>
  
  <div className="modal__body">
    {children}
  </div>
</div>
</div>
    , document.getElementById("modal")
  )
}

export default memo(Modal)