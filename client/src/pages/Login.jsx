import React, { useEffect, useRef, useState } from 'react'
import { useStateContext } from '../contexts/ContextProvider';
import { Link, useNavigate } from 'react-router-dom';
import { handleChange, handleRequest, navigation } from '../util/util';
import axiosClient from '../axios';
import Loading from '../components/Loading';
import Errors from '../components/Errors';


const Login = ({reference=null}) => {

    
  const { setCurrentUser,  setUserToken, abilities,setAbilities  ,userToken } = useStateContext();
  const navigate = useNavigate();

  useEffect(()=>{
    if (userToken) {
      navigation(abilities,navigate);
    }
},[userToken] )




  const passwordRef = useRef(null);
  const[loading, setLoading]=useState(false);
  const passwordIconRef = useRef(null);
  const [inputs, setInputs] = useState({
    email: "",
    password: "",
  });
  const [errors, setErrors]= useState({
    isErrorsOpen : false,
    content:null, 
  })
  const [isPasswordVisible, setIsPasswordVisible] = useState(false);


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
  


  const submitLogin = (e) => {
    e.preventDefault()
    handleRequest(
      () => axiosClient.post("/login",inputs),
      setLoading,
      ({user, token}) => {
          setCurrentUser(user);
          setUserToken(token);
          setAbilities(user.abilities);
          navigation(user.abilities, navigate)  
        },
      setErrors
      )
  }

  return (
<>

        <div className="form__container">
        <form className="form" onSubmit={submitLogin} method="POST">
      <div>
      <div className="input__group">
        <input
          type="email"
          className="input"
          placeholder="Email"
          name="email"
          id="email"
          onChange={(e)=>{handleChange(e,setInputs)}}
        />
      <span className="input__span"><i className="form__icon fa-solid fa-envelope fa-xl"></i></span>
        <label htmlFor="email" className="input__label">Email</label>
      </div>
      </div>
      <div>
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
      <div className="form__action">
      </div>
      <div className='form__actions'>
        { loading ? <div><Loading/></div>:<>
        <button className="button button--primary" type="submit">
          Valider
        </button>
        <button className="button " onClick={(e)=>{
          e.preventDefault()
          if(reference){
            const loginContainer = reference.current;
            loginContainer.classList.remove("active");
          }
        }} >
         Annuler 
        </button>
   
 </>
        }
      </div>
    </form>
        </div>


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

export default Login