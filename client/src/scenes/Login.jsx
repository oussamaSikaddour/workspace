import React, { useEffect, useRef, useState } from 'react'
import Errors from '../components/Errors';
import Loading from '../components/Loading';
import { useStateContext } from '../contexts/ContextProvider';
import axiosClient from '../axios';
import { Link, useNavigate } from 'react-router-dom';
import { handleChange, handleRequest, navigation } from '../util/util';




function Login({extendForm,loginRef}) {


  const { setCurrentUser,  setUserToken, setAbilities ,abilities,currentUser ,userToken } = useStateContext();
  useEffect(()=>{
    if (userToken) {
      navigation(abilities,navigate);
    }
},[userToken] )



  const navigate = useNavigate();


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

    <form className="form" onSubmit={submitLogin} method="POST">
      <h3 className="primary">
      Veuillez fournir les renseignements suivants :
      </h3>
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
    
      <Link to="/forgetPassword">
      j'ai oublié mon mot de passe 
      </Link>
      </div>
      <div>
        { loading ? <div><Loading/></div>:<>
        <button className="button button--primary" type="submit">
          Valider
        </button>

       <button className="button " type="submit" onClick={(e)=>{
        e.preventDefault()
        extendForm(loginRef)
       }}>
        Annuller
        </button>   
</> 
        }
      </div>
    </form>

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