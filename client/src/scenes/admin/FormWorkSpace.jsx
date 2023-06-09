import React, { useEffect, useState } from 'react'
import Toast from '../../components/Toast';
import Errors from '../../components/Errors';
import { handleChange, handleRequest } from '../../util/util';
import axiosClient from '../../axios';
import Loading from '../../components/Loading';

const FormWorkSpace = ({setRenderWorkSpaces, workSpaceId=null})  => {
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
    name: "",
   description:"",
   location:"",
  capacity:"",
  pricePerHour:"",
  });

  const setWorkSpace = () => {
    return ({workSpace}) => {
const{name,description,location,capacity, pricePerHour} = workSpace
      setInputs(prev => ({
        ...prev,
      name,
      description,
      location,
      capacity,
      pricePerHour
      }));
    }
  }

  const handleSubmit = (e) => {
    e.preventDefault();
    if(workSpaceId){
      handleRequest(
        () => axiosClient
      .patch(`/workspaces/${workSpaceId}`,inputs),
        setLoading,
        setWorkSpace(),
        setErrors,
        setToast,
        "espace de travail  modifier avec succès"
        )

    }else{
      handleRequest(
        () => axiosClient
      .post("/workspaces",inputs),
        setLoading,
        setWorkSpace(),
        setErrors,
        setToast,
        "espace de travail  ajouté avec succès"
        )

    }
    setRenderWorkSpaces();

  }

  useEffect(()=>{
    if(workSpaceId){
      handleRequest(
        () => axiosClient
      .get(`/workspaces/${workSpaceId}`),
        setLoading,
        setWorkSpace(),
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
                    name="name"
                    id="name"
                    value={inputs.name ||""}
                   onChange={(e)=>{handleChange(e,setInputs)}}
                  />
                  <label htmlFor="name" className="input__label">name</label>
                </div>
                <div className="input__group">
                  <input
                    type="number"
                    className="input"
                    placeholder="Capacité"
                    name="capacity"
                    id="capacity"
                    value={inputs.capacity ||""}
                   onChange={(e)=>{handleChange(e,setInputs)}}
                  />
                  <label htmlFor="capacity" className="input__label">Capacité</label>
                </div>
              </div>
              <div>
              <div className="input__group">
                  <input
                    type="number"
                    className="input"
                    placeholder="Prix par heure"
                    name="pricePerHour"
                    id="pricePerHour"
                    value={inputs.pricePerHour||""}
                    onChange={(e)=>{handleChange(e,setInputs)}}
                  />
                  <label htmlFor="pricePerHour" className="input__label">Prix par heure</label>
                </div>
                <div className="input__group">
                  <input
                    type="text"
                    className="input"
                    placeholder="Location"
                    name="location"
                    id="location"
                    value={inputs.location||""}
                    onChange={(e)=>{handleChange(e,setInputs)}}
                  />
                  <label htmlFor="location" className="input__label">Location</label>
                </div>
              </div>

              <div className="textarea__group">
                <textarea
                  className="textarea"
                  id="description"
                  name="description"
                  rows="4"
                  cols="100"
                  maxLength="200"
                  placeholder="Enter your message here"
                  value={inputs.description||""}
                  onChange={(e) => {
                    handleChange(e, setInputs);
                  }}
                >
                </textarea>
                <label htmlFor="description" className="textarea__label">Description </label>
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


export default FormWorkSpace