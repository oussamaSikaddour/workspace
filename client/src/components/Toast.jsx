import {createPortal} from 'react-dom'
import {useState, useEffect} from 'react';

const Toast = ({ isOpened, children, onClose }) => {
  const [isVisible, setIsVisible] = useState(isOpened);

  useEffect(() => {
    setIsVisible(isOpened);
    if (isOpened) {
      const timeoutId = setTimeout(() => {
        setIsVisible(false);
        onClose();
      }, 3000);
      return () => clearTimeout(timeoutId);
    }
  }, [isOpened, onClose]);

  if (!isVisible) {
    return null;
  }

  return createPortal(
    <div className="toast__container" onClick={onClose}>
      <div className="toast">{children}</div>
    </div>,
    document.getElementById("toast")
  );
}

export default Toast;
