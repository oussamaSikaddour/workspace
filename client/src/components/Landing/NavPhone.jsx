import React, { useRef } from 'react';
import Login from '../../pages/Login';

const NavPhone = ({ handleStepClick, activePhoneLinkRef }) => {
  const openLoginButtonRef = useRef();
  const landingOverlayRef = useRef();
  const loginMobileRef = useRef();

  const setSceneActiveOnPhone = (index) => {
    handleStepClick(index);
    setTimeout(() => {
      landingOverlayRef.current.classList.remove('open');
    }, 600);
  };

  const toggleOpenClasses = () => {
    openLoginButtonRef.current.classList.toggle('open');
    landingOverlayRef.current.classList.toggle('open');
  };

  const openLoginMobile = () => {
    loginMobileRef.current.classList.add('active');
  };

  return (
    <>
      <div className="landing__login__btn" onClick={openLoginMobile}>
        <i className="fa-solid fa-right-to-bracket"></i>
      </div>
      <div className="login--mobile" ref={loginMobileRef}>
        <Login reference={loginMobileRef} />
      </div>
      <div className="landing__humb" ref={openLoginButtonRef} onClick={toggleOpenClasses}>
        <span></span>
        <span></span>
      </div>
      <div className="landing__overlay" ref={landingOverlayRef}>
        <div className="landing__nav landing__nav--mobile">
          <ul className="landing__steps">
            <div className="landing__step--active" ref={activePhoneLinkRef}></div>
            <li onClick={()=> setSceneActiveOnPhone(0)}>Accueil</li>
            <li onClick={() => setSceneActiveOnPhone(1)}>Qui sommes nous</li>
            <li onClick={()=> setSceneActiveOnPhone(2)}>Nos Produits</li>
            <li onClick={()=> setSceneActiveOnPhone(3)}>WorkSpace</li>
            <li onClick={()=> setSceneActiveOnPhone(4)}>Contactez-Nous</li>
          </ul>
        </div>
      </div>
    </>
  );
};

export default NavPhone;
