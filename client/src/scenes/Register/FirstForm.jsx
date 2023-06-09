import React, { useRef, useState } from 'react'
import Loading from '../../components/Loading';
import Errors from '../../components/Errors';
import Toast from '../../components/Toast';
import axiosClient from '../../axios';
import { handleChange, handleRequest } from '../../util/util';

const FirstForm = ({extendForm, slideForms ,registerRef}) => {
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
    password:"",
    passwordConfirmation:"",
    lastName:"",
    firstName:"",
    birthDate:"",
    tel:"",
    
    
  });

  
  const [isPasswordVisible, setIsPasswordVisible] = useState(false);
  const passwordRef = useRef(null);
  const passwordIconRef = useRef(null);


  const ChangePasswordVisibility = () => {
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
 e.preventDefault()
    inputs.passwordConfirmation = inputs.password;

    handleRequest(
      () => axiosClient.post("/register",inputs),
      setLoading,
      (data) => {
      localStorage.setItem("userEmail", JSON.stringify(inputs.email));
      localStorage.setItem("userId", JSON.stringify(data.user.id));
      slideForms();
        },
      setErrors,
      setToast,
      "vous avez créé votre compte avec succès, un code de vérification a été envoyé à votre adresse e-mail"
      )
  }


  return (
<>
<form className="form" method="POST" onSubmit={handelSubmit}>
<h3>Votre email doit être valide, un code de vérification vous sera envoyé</h3>
  <div>

    <div className="input__group">
      <input
        type="text"
        className="input"
        placeholder="Nom"
        name="lastName"
        id="name"
        onChange={(e)=>{handleChange(e,setInputs)}}
      />
      <label htmlFor="name" className="input__label">Nom</label>
    </div>
    <div className="input__group">
      <input
        type="text"
        className="input"
        placeholder="Prénom"
        name="firstName"
        id="prenom"
        onChange={(e)=>{handleChange(e,setInputs)}}
      />
      <label htmlFor="prenom" className="input__label">Prénom</label>
    </div>
    </div>
    <div>
    <div className="input__group">
      <input
        type="date"
        className="input"
        placeholder="Date de naissance"
        name="birthDate"
        id="birthDate"
        onChange={(e)=>{handleChange(e,setInputs)}}

      />
      <label htmlFor="birthDate" className="input__label">Date de naissance</label>
    </div>
    <div className="input__group">
      <input
        type="email"
        className="input"
        placeholder="Votre email valide"
        name="email"
        id="email"
        onChange={(e)=>{handleChange(e,setInputs)}}
      />
      <label htmlFor="email" className="input__label">Votre email valide</label>
    </div>

    </div>
    <div>
    <div className="input__group">
      <input
        type="text"
        className="input"
        placeholder="Numéro de telephone"
        name="tel"
        id="tel"
        onChange={(e)=>{handleChange(e,setInputs)}}
      />
      <label htmlFor="tel" className="input__label">Numéro de telephone</label>
    </div>
    <div className="input__group">
        <input
           type={isPasswordVisible ? "text" : "password"}
          className="input"
          placeholder="Mot de passe"
          name="password"
          id="password"
          onChange={(e)=>{handleChange(e,setInputs)}}
          ref={passwordRef}
        />
        <span className="input__span" onClick={ChangePasswordVisibility}> <i ref={passwordIconRef}className={`form__icon fa-solid ${isPasswordVisible ? "fa-eye-slash" : "fa-eye"} fa-xl`}></i></span>
        <label htmlFor="password" className="input__label">Mot de passe</label>
      </div>
  </div>
  <div>
  { loading ? <div><Loading/></div>:<>
    <button className="button rendezvous__annuller" onClick={(e)=>{ e.preventDefault()
      extendForm(registerRef)}}>Annuller</button>
    <button type='submit'
      className="button button--primary newPatientChoose">
      Valider
    </button>
    </> }
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

export default FirstForm