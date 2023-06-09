import React, { useEffect, useRef, useState } from 'react';
import { Link, useNavigate } from 'react-router-dom';
import { useStateContext } from '../contexts/ContextProvider';
import { navigation } from '../util/util';
import Login from './Login';
import Landing from '../scenes/landing/Landing';
import AboutUs from '../scenes/landing/AboutUs';
import Products from '../scenes/landing/Products';
import Workspace from '../scenes/landing/Workspace';
import ContactUs from '../scenes/landing/ContactUs';
import NavPhone from '../components/Landing/NavPhone';

const LandingPage = () => {
  const { userToken, abilities } = useStateContext();
  const navigate = useNavigate();
  const loginContainerRef = useRef();
  const activeLinkRef = useRef();
  const [activeIndex, setActiveIndex]= useState(JSON.parse(localStorage.getItem("activeIndex")) || 0);
  const activePhoneLinkRef = useRef();
  const [scenes, setScenes] = useState({
    0: { component: <Landing />, name: "landing", transform: 'translateX(0)', active: true, animate: true },
    1: { component: <AboutUs />, name: "aboutUs", transform: 'translateX(100%)', active: false, animate: false },
    2: { component: <Products />, name: "products", transform: 'translateX(200%)', active: false, animate: false },
    3: { component: <Workspace />, name: "workSpace", transform: 'translateX(300%)', active: false, animate: false },
    4: { component: <ContactUs />, name: "contactUs", transform: 'translateX(400%)', active: false, animate: false },
  });

  useEffect(() => {
    if (userToken) {
      navigation(abilities, navigate, true);
    }
  }, [userToken, abilities, navigate]);

  const handleStepClick = (index) => {
    setActiveIndex(index)
    localStorage.setItem("activeIndex", JSON.stringify(index));
  };
  
  

  const handleLoginClick = () => {
    const loginContainer = loginContainerRef.current;
    loginContainer.classList.add('active');
  };

  useEffect(()=>{
    const activeLink = activeLinkRef.current;
    const activePhoneLink = activePhoneLinkRef.current;
    activeLink.style.transform = `translateX(calc(100% * ${activeIndex}))`;
    activePhoneLink.style.transform = `translateY(calc(100% * ${activeIndex}))`;
    const updatedScenes = Object.entries(scenes).map(([key, scene]) => {
      const transform = key === String(activeIndex) ? `translateX(calc(-100% * ${key}))` : `translateX(calc(100% * ${key}))`;
      const active = key === String(activeIndex);
      const animate = key === String(activeIndex);
      const name = scene.name;
      return { ...scene, transform, active, animate, name };
    });
    setScenes(updatedScenes);
  },[activeIndex])
  return (
    <>
      <div className="bg__video">
        <video className="bg__video__content" autoPlay muted loop>
          <source src="/bgVideo.mp4" type="video/mp4" />
        </video>
      </div>
      <div className="landing__container">
        <div className="landing__nav landing__nav--pc">
          <div className="landing__login" ref={loginContainerRef}>
            <img src="/logo.ico" alt="logo" className="img__button" onClick={handleLoginClick} />
            <Login reference={loginContainerRef} />
          </div>
          <ul className="landing__steps">
            <div className="landing__step--active" ref={activeLinkRef}></div>
            <li onClick={() =>handleStepClick(0)}>Accueil</li>
            <li onClick={()=>handleStepClick(1)}>Qui somme nous</li>
            <li onClick={()=>handleStepClick(2)}>Nos Produits</li>
            <li onClick={()=>handleStepClick(3)}>WorkSpace</li>
            <li onClick={()=>handleStepClick(4)}>Contactez-Nous</li>
          </ul>
          <ul className="socials">
            <li>
              <i className="fa-brands fa-facebook"></i>
            </li>
            <li>
              <i className="fa-brands fa-instagram"></i>
            </li>
            <li>
              <i className="fa-brands fa-facebook"></i>
            </li>
          </ul>
          </div>
      <NavPhone handleStepClick={handleStepClick}  activePhoneLinkRef={activePhoneLinkRef}/>
      <div className="landing__scenes">
        {Object.entries(scenes).map(([key, scene]) => (
          <div
            key={key}
            className={`landing__scene ${scene.name} ${scene.active ? 'active' : ''} ${
              scene.animate ? 'animate' : ''
            }`}
            style={{ transform: scene.transform }}
          >
            {scene.component}
          </div>
        ))}
      </div>
    </div>
  </>
);
};

export default LandingPage;


