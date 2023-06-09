import {createPortal} from 'react-dom'
import Loading from './Loading'

const Loader = () => {
  return  createPortal(
    <div className="loader__container">
  <Loading variant={"l"}/>
  </div>
    , document.getElementById("loader")
  )
}

export default Loader