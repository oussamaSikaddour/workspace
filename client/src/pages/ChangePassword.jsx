import React, { useRef, useState } from 'react'
import Footer from '../components/Footer'
import Errors from '../components/Errors'
import { Navigate, useNavigate } from 'react-router-dom';
import { useStateContext } from '../contexts/ContextProvider';
import Toast from '../components/Toast';
import axiosClient from '../axios';
import Loading from '../components/Loading';
import { handleChange, handleRequest } from '../util/util';
import Header from '../components/Header';


const ChangePassword = () => {

  const { currentUser,setCurrentUser, setUserToken, setAbilities ,abilities ,userToken } = useStateContext();


  if(!currentUser){
    return <Navigate to="/"/>
   }
 
   const[loading, setLoading]=useState(false);
   const [errors, setErrors]= useState({
     isErrorsOpen : false,
     content:null, 
   })
   const [toast ,setToast] = useState({
     isToastOpen:false,
     content:""
   })
  const passwordRef = useRef(null);
  const newPasswordRef= useRef(null);
  const passwordIconRef = useRef(null);
  const newPasswordIconRef = useRef(null);
  const [inputs, setInputs] = useState({
    password: "",
    passwordConfirmation :"",
    newPassword:"",
    newPasswordConfirmation:""
  });

  const [isPasswordVisible, setIsPasswordVisible] = useState(false);
  const [isNewPasswordVisible, setIsNewPasswordVisible] = useState(false);

  const ChangePasswordVisibility = (passwordRef,passwordIconRef ,setIsPasswordVisible) => {
    setIsPasswordVisible((prev) => !prev);
    const passwordInput = passwordRef.current;
    const passwordIcon = passwordIconRef.current;

    if (isPasswordVisible) {
      passwordInput.type = "password";
      passwordIcon.classList.remove("fa-eye-slash");
      passwordIcon.classList.add("fa-eye");
    } else {
      passwordInput.type = "text";
      passwordIcon.classList.remove("fa-eye-slash");
      passwordIcon.classList.add("fa-eye");
    }
  };
  

  const handelSubmit= (e)=>{
    e.preventDefault();

     inputs.passwordConfirmation = inputs.password
     inputs.newPasswordConfirmation = inputs.newPassword
    handleRequest(
      () => axiosClient.patch(`/changePassword/${currentUser.id}`, inputs),
      setLoading,
      (data) => {
        localStorage.removeItem("emailUser");
        },
      setErrors,
      setToast,
      "votre mot de passe a été changé avec succès"
      )
  }
  return (
<>
<Header/>
<main className="container__fluid">
      <section className="section">
        <h2>Modification Du Mot de passe</h2>
        <div className="form__container small">
          <form className="form" onSubmit={handelSubmit} method="POST">
            <h3 className="primary">
            Veuillez fournir les renseignements suivants :
            </h3>


            <div className="input__group">
              <input
                 type={isPasswordVisible ? "text" : "password"}
                className="input"
                placeholder="Mot de passe actuel"
                name="password"
                id="password"
                onChange={(e)=>{handleChange(e,setInputs)}}
                ref={passwordRef}
              />
              <span className="input__span" onClick={()=>{ChangePasswordVisibility(passwordRef,passwordIconRef ,setIsPasswordVisible)}}> <i ref={passwordIconRef}className={`form__icon fa-solid ${isPasswordVisible ? "fa-eye-slash" : "fa-eye"} fa-xl`}></i></span>
              <label htmlFor="password" className="input__label">Mot de passe actuel</label>
            </div>
            <div className="input__group">
              <input
                 type={isNewPasswordVisible ? "text" : "password"}
                className="input"
                placeholder="Nouveau Mot de passe"
                name="newPassword"
                id="newPassword"
                onChange={(e)=>{handleChange(e,setInputs)}}
                ref={newPasswordRef}
              />
              <span className="input__span" onClick={()=>{ ChangePasswordVisibility(newPasswordRef,newPasswordIconRef ,setIsNewPasswordVisible) }}> <i ref={newPasswordIconRef}className={`form__icon fa-solid ${isNewPasswordVisible ? "fa-eye-slash" : "fa-eye"} fa-xl`}></i></span>
              <label htmlFor="newPassword" className="input__label">Nouveau Mot de passe</label>
            </div>

            <div className="form__action">
            { loading ? <div><Loading/></div>:
              <button className="button button--primary" type="submit">
                Valider
              </button>}
            </div>
          </form>
        </div>
      </section>
    </main>
<Footer/>

<Toast isOpened={toast.isToastOpen} 
  onClose={()=>setToast(prevState => ({
                  ...prevState,
                  isToastOpen: false
                                     }))}>
     {toast.content}

  </Toast>
<Errors  isOpened={errors.isErrorsOpen} 
  onClose={()=>setErrors(prevState => ({
                  ...prevState,
                  isErrorsOpen: false
                                     }))}>
     {errors.content}
  </Errors>
</>
  )
}

export default ChangePassword