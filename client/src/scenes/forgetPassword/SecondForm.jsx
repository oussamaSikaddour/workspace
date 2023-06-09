import React, { useRef, useState } from 'react'
import Toast from '../../components/Toast';
import Errors from '../../components/Errors';
import Loading from '../../components/Loading';
import axiosClient from '../../axios';
import { handleChange, handleRequest } from '../../util/util';

const SecondForm = () => {
  const[loading, setLoading]=useState(false);
  const [errors, setErrors]= useState({
    isErrorsOpen : false,
    content:null, 
  })
  const [toast ,setToast] = useState({
    isToastOpen:false,
    content:""
  })
  const [inputs, setInputs] = useState({
    email: "", 
    code:"",
    password:"",
    passwordConfirmation:""
  });
  const passwordRef = useRef(null);
  const passwordIconRef = useRef(null);
  const [isPasswordVisible, setIsPasswordVisible] = useState(false);


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
     inputs.email = JSON.parse(localStorage.getItem("emailUser"));
     inputs.passwordConfirmation = inputs.password
    handleRequest(
      () => axiosClient.post("/resetPassword", inputs),
      setLoading,
      (data) => {
        localStorage.removeItem("emailUser");
        },
      setErrors,
      setToast,
      "un code de vérification a été envoyé à votre adresse e-mail",
      )
  }
  return (
  <>
          <form className="form" onSubmit={handelSubmit} method="POST">
              <p>
                mettez le code que vous avez reçu dans votre e-mail, et
                définissez votre nouveau mot de passe
              </p>
              <div>
              <div className="input__group">
                <input
                  type="text"
                  className="input"
                  placeholder="Code de vérification"
                  name="code"
                  id="code"
                 onChange={(e)=>{handleChange(e,setInputs)}}
                />
                <span className="input__span"><i className="fa-solid fa-lock"></i></span>
                <label htmlFor="code" className="input__label">Code de vérification</label>
              </div>
              </div>
              <div>
              <div className="input__group">
                <input
                  type="password"
                  className="input"
                  placeholder="Nouveau mot de passe"
                  name="password"
                  id="newPassword"
                  onChange={(e)=>{handleChange(e,setInputs)}}
                  ref={passwordRef}
                  />
                  <span className="input__span" onClick={()=>{ ChangePasswordVisibility(passwordRef,passwordIconRef ,setIsPasswordVisible) }}> <i ref={passwordIconRef}className={`form__icon fa-solid ${isPasswordVisible ? "fa-eye-slash" : "fa-eye"} fa-xl`}></i></span>
                <label htmlFor="newPassword" className="input__label">Nouveau mot de passe</label>
              </div>
              </div>
              <div className="form__actions">
              { loading ? <div><Loading/></div>:
                <button className="button button--primary" type="submit">
                  Valider
                </button>}
              </div>
            </form>

            
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

export default SecondForm