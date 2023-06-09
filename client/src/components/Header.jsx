
import { Link, NavLink } from 'react-router-dom'
import NavPhone from './NavPhone';
import { useLogout } from '../contexts/ContextProvider';
import { useStateContext } from '../contexts/ContextProvider';
import { setNavLink } from '../util/util';
import Notifications from './notifications/Notifications';
import { useRef } from 'react';
const Header = ({variant}) => {

  const {userToken ,currentUser,abilities ,notifications} = useStateContext();
  const logout = useLogout();

  const handleLogout = () => {
    logout();
  };


  const notificationsRef = useRef(null);


  const showNotifications = ()=>{
const notifications = notificationsRef.current
notifications.classList.toggle("show");
  }




  return (
    <>
    {userToken ? <nav  className={ variant ? "nav " + variant : "nav "}>
      <ul className="nav__links">
      {setNavLink(abilities)}
 
      </ul>
      <ul className="nav__links">

      { !abilities.includes("admin")?"" :<li className="nav__link" onClick={showNotifications}> <i className="fa-solid fa-bell"></i>{notifications?.length > 0 ?<span>{notifications.length}</span> :""}</li>}
        <li className="nav__link">
          {currentUser?.name} <i className="fa-solid fa-user"></i>
          <ul className="nav__link--drapdown">
            <li>
              <Link to="/changePassword">Modifier votre mot de passe</Link>
            </li>
            <li onClick={handleLogout}>
              Se déconnecter<i className="fa-solid fa-right-from-bracket"></i>
            </li>
          </ul>
        </li>
      </ul>
    </nav>
    :    <nav  className={ variant ? "nav " + variant : "nav "}>

         <ul className="nav__links">
        <li className="nav__link"><NavLink to="/"end>Accueil</NavLink></li>

      </ul>
      <ul className="nav__links">
        <li className='nav__link'> <NavLink to="/forgetPassword"end>mot de passe oublié </NavLink></li>
      </ul>
    </nav>
}

<NavPhone handleLogout={handleLogout} showNotifications={showNotifications}/>

<div ref={notificationsRef} className="notifications__container">
    <Notifications  />
  </div>
</>

  )
}

export default Header