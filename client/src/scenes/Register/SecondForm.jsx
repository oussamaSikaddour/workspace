import React, { useEffect, useState } from 'react'
import { handleChange, handleRequest, navigation } from '../../util/util';
import { useNavigate } from 'react-router-dom';
import { useStateContext } from '../../contexts/ContextProvider';
import axiosClient from '../../axios';
import Errors from '../../components/Errors';
import Loading from '../../components/Loading';
import Toast from '../../components/Toast';

const SecondForm = ({extendForm,registerRef}) => {
  
  const { setCurrentUser,  setUserToken, setAbilities,abilities, currentUser,userToken } = useStateContext();
  useEffect(()=>{
    if (userToken) {
      navigation(abilities,navigate);
    }
},[userToken] )

  const navigate = useNavigate();
  const[loading, setLoading]=useState(false);
  const [ display, setDisplay] = useState(false);
  const[loading2, setLoading2]=useState(false);

  const [userId, setUserId] = useState(null)

  const [errors, setErrors]= useState({
    isErrorsOpen : false,
    content:null, 
  })
  const [toast ,setToast] = useState({
    isToastOpen:false,
    content:""
  })
  const [inputs, setInputs]= useState({
    code:"",
    email:""

  })



  const handelSubmit= (e)=>{
    e.preventDefault();
     inputs.email =JSON.parse(localStorage.getItem("userEmail"));
    handleRequest(
      () => axiosClient.post("/emailVerification",inputs),
      setLoading,
      ({user,token}) => {
          localStorage.removeItem("userEmail");
          localStorage.removeItem("userId");
          setCurrentUser(user);
          setUserToken(token);
          setAbilities(user.abilities);
          navigation(user.abilities, navigate)  
        },
      setErrors,
      setToast,
      "vous avez créé votre compte avec succès, un code de vérification a été envoyé à votre adresse e-mail",
      () => { setDisplay(true)
        setUserId(JSON.parse(localStorage.getItem("userId")))
       } 
      )
  }

  const getNewVerificationEmail =()=> {

    handleRequest(
      () => axiosClient.get(`/reSendVerificationEmail/${userId}`),
      setLoading2,
      (data) => {
        console.log(data)
      },
      setErrors,
      setToast,
      "vous avez reçu avec succès un nouveau code de vérification sur votre adresse e-mail",// <-- move the function here
    );
  }
  
  return (
<>
<form className="form" method="POST" onSubmit={handelSubmit}>
<h3>Vous devez  entrer le code de vérification envoyé à votre adresse e-maill</h3>
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
     <span className="input__span"><i className="fa-solid fa-key"></i></span>
      <label htmlFor="code" className="input__label">Code de vérification</label>
    </div>



  </div>
 {display && <div>
        { loading2 ? <div><Loading/></div>:<>
    <button className="button " onClick={(e)=>{
      e.preventDefault()
      getNewVerificationEmail()
    }}>
    obtenir un nouveau code de vérification
    </button>
      </>}
  </div>}


  <div>
        { loading ? <div><Loading/></div>:<>
    <button className="button button--primary" type='submit'>
      Valider
    </button>


    <button className="button rendezvous__annuller" onClick={(e)=>{ e.preventDefault()
      extendForm(registerRef)}}>Annuller</button>
      </>}
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