import React, { useEffect, useRef, useState } from 'react'
import FirstForm from '../scenes/forgetPassword/FirstForm'
import SecondForm from '../scenes/forgetPassword/SecondForm'
import Footer from '../components/Footer';
import { useNavigate } from 'react-router-dom';
import { navigation } from '../util/util';
import { useStateContext } from '../contexts/ContextProvider';
import Header from '../components/Header';

const ForgetPassword = () => {
  const { currentUser, userToken } = useStateContext();
  const navigate = useNavigate();


  const [emailUser, setEmailUser] = useState(
    JSON.parse(localStorage.getItem("emailUser")) || false
  );
  const formsRef = useRef(null);

  const slideForms = ()=>{
    formsRef.current.style.transform = "translateX(calc(-100% + -2rem))";
  }




  useEffect(() => {
    if (userToken) {
      navigation(currentUser.userableType, currentUser.userableId, navigate);
    }

    if(emailUser){
      slideForms();
   }}, [])


  return (
    <>

<Header/>
    <main className="container__fluid">
      <section className="section ">
        <h2>Changement du mot de passe</h2>
        <div className="form__container small">
          <div className="forms" ref={formsRef} >
           <FirstForm slideForms={slideForms}/>
           <SecondForm/>
          </div>
        </div>
      </section>
    </main>
    <Footer/>
    </>
  )
}

export default ForgetPassword