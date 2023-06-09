import React, { useEffect, useState } from 'react'
import Toast from '../../components/Toast';
import Errors from '../../components/Errors';
import { handleChange, handleRequest } from '../../util/util';
import axiosClient from '../../axios';
import Loading from '../../components/Loading';

const FormAdmin = ({setRenderAdministrators, adminId=null})  => {
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
   lastName:"",
   firstName:"",
  tel:"",
  });

  const setAdmin = () => {
    return ({user}) => {
      const { email,personnelInfo} = user;
      const { lastName,firstName,tel}=personnelInfo;
      setInputs(prev => ({
        ...prev,
      email,
      lastName,
      firstName,
      tel,
      }));
    }
  }

  const handleSubmit = (e) => {
    e.preventDefault();
    if(adminId){
      handleRequest(
        () => axiosClient
      .patch(`/users/${adminId}`,inputs),
        setLoading,
        setAdmin(),
        setErrors,
        setToast,
        "administrateur  ajouté avec succès"
        )

    }else{
      handleRequest(
        () => axiosClient
      .post("/users",inputs),
        setLoading,
        setAdmin(),
        setErrors,
        setToast,
        "administrateur  ajouté avec succès"
        )

    }
    setRenderAdministrators();

  }

  useEffect(()=>{
    if(adminId){
      handleRequest(
        () => axiosClient
      .get(`/users/${adminId}`),
        setLoading,
        setAdmin(),
        setErrors
        )

    }
  },[])
  return (
<>
<div className="form__container">
            <form className="form etablissement__form" onSubmit={handleSubmit} method="POST">
              <div>
                <div className="input__group">
                  <input
                    type="text"
                    className="input"
                    placeholder="Nom"
                    name="lastName"
                    id="name"
                    value={inputs.lastName ||""}
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
                    value={inputs.firstName ||""}
                   onChange={(e)=>{handleChange(e,setInputs)}}
                  />
                  <label htmlFor="prenom" className="input__label">Prénom</label>
                </div>
              </div>
              <div>
              <div className="input__group">
                  <input
                    type="email"
                    className="input"
                    placeholder="Email"
                    name="email"
                    id="email"
                    value={inputs.email||""}
                    onChange={(e)=>{handleChange(e,setInputs)}}
                  />
                  <label htmlFor="email" className="input__label">Email</label>
                </div>
                <div className="input__group">
                  <input
                    type="text"
                    className="input"
                    placeholder="Téléphone"
                    name="tel"
                    id="tel"
                    value={inputs.tel||""}
                    onChange={(e)=>{handleChange(e,setInputs)}}
                  />
                  <label htmlFor="tel" className="input__label">Téléphone</label>
                </div>
              </div>

              <div className='form__actions'>
            { loading ? <div><Loading/></div>:
             <button className="button button--primary" type="submit">
              Valider
             </button>}
            </div>
            </form>
          </div>

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


export default FormAdmin