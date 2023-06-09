import React, { useState } from 'react'
import Toast from '../../components/Toast';
import Errors from '../../components/Errors';
import Loading from '../../components/Loading';
import axiosClient from '../../axios';
import { handleChange, handleRequest } from '../../util/util';

const FirstForm = ({slideForms}) => {
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
  });



  




  const handelSubmit= (e)=>{

e.preventDefault();

    handleRequest(
      () => axiosClient.post("/forgotPassword", inputs),
      setLoading,
      (data) => {
      localStorage.setItem("emailUser", JSON.stringify(inputs.email));
      slideForms();
        },
      setErrors,
      setToast,
      "un code de vérification a été envoyé à votre adresse e-mail",
      )
  }


  return (
<>
  <form className="form" onSubmit={handelSubmit} method="POST">
              <h3 className="primary" >
                Veuillez fournir ou confirmer les renseignements suivants :
              </h3>
              <p>
                Inscrivez votre adresse courriel, puis demander un code de
                vérification.
              </p>
              <div>
                <div className="input__group">
                  <input
                    type="text"
                    className="input"
                    placeholder="Votre Email"
                    name="email"
                    id="email"
                  onChange={(e)=>{handleChange(e,setInputs)}}
                  />
                  <span className="input__span">
                    <i className="fa-solid fa-envelope"></i></span>
                  <label htmlFor="email" className="input__label">Votre Email</label>
                </div>
              </div>
              <div className="form__actions">
              { loading ? <div><Loading/></div>:
                <button className="button button--primary" type="submit">
                  Valider
                </button> }
  
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