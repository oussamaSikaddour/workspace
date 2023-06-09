import React, { useRef, useState } from 'react'
import { NavLink } from 'react-router-dom'
import { useStateContext } from '../contexts/ContextProvider';
import { setNavLink } from '../util/util';


const NavPhone = ({handleLogout,showNotifications}) => {
  const {userToken, abilities ,notifications} = useStateContext();
  const [navOpen, setNavOpen]= useState(false);
  const navPhoneRef = useRef(null);
  const navBtnRef = useRef(null);
  const navPhoneLinksRef = useRef(null);

  const handelNavPhone = () =>{
    const navPhone =navPhoneRef.current;
    const navPhoneLinks = navPhoneLinksRef.current;
    const navBtn = navBtnRef.current;
    setNavOpen(!navOpen);
    if(navOpen ){
    
      navPhone.style.transform = "scale(1)";
      navPhoneLinks.style.transform = "translate(0,-50%)";
      navBtn.classList.add("open");
    }else{
      navPhone.style.transform = "scale(0)";
      navPhoneLinks.style.transform = "translate(100%,-50%)";
      navBtn.classList.remove("open");
    }
  }
  return (
<>
    <div  className="nav__humb" ref={navBtnRef} onClick={handelNavPhone}>
      <span></span>
      <span></span>
    </div>
 <nav ref={navPhoneRef}  className="nav--mobile">
 {userToken ?

      <ul  ref={navPhoneLinksRef} className="nav__links">
      {setNavLink(abilities)}

      { !abilities.includes("admin")?"" :<li className="nav__link" onClick={showNotifications}> notifications <i className="fa-solid fa-bell"></i>{notifications?.length > 0 ?<span>{notifications.length}</span> :""}</li>}
      <li className='nav__link' onClick={handleLogout}>
              Se déconnecter<i className="fa-solid fa-right-from-bracket"></i>
      </li>
        
      </ul>
     :
    <ul  ref={navPhoneLinksRef} className="nav__links">
        <li className="nav__link"><NavLink to="/" end>Accueil</NavLink></li>
        <li className='nav__link'><NavLink to="/forgetPassword" end>mot de passe oublié </NavLink></li>
      </ul>}
      </nav>

</>
  )
}

export default NavPhone