import React, { useEffect, useState } from 'react'
import Toast from '../../components/Toast';
import Errors from '../../components/Errors';
import { handleChange, handleRequest, minDateRequired } from '../../util/util';
import axiosClient from '../../axios';
import Loading from '../../components/Loading';
import StatusSelector from '../../components/selectors/StatusSelector';

const FormPlan = ({setRenderPlans,workSpaceId=null, planId=null})  => {
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
 workSpaceId:"",
 capacity:"",
 startDate:"",
 endDate:"",
 status:"",

  });

  const today= new Date();
  const tomorrow = today.setDate(today.getDate() + 1)

  const minDate = useState(minDateRequired(tomorrow))[0];

  const setPlan = () => {
    return ({plan}) => {
const{workSpaceId, capacity,startDate,endDate,status} = plan
      setInputs(prev => ({
        ...prev,
        workSpaceId,
        capacity,
        startDate,
        endDate,
        status
      }));
    }
  }

  const handleSubmit = (e) => {
    e.preventDefault();
    if(planId){
      handleRequest(
        () => axiosClient
      .patch(`/plans/${planId}`,inputs),
        setLoading,
        setPlan(),
        setErrors,
        setToast,
        "Planning modifier avec succès"
        )

    }else{
      inputs.workSpaceId =workSpaceId
      inputs.status="inactive"
      handleRequest(
        () => axiosClient
      .post("/plans",inputs),
        setLoading,
        setPlan(),
        setErrors,
        setToast,
        "Planning  ajouté avec succès"
        )

    }
    setRenderPlans();

  }

  useEffect(()=>{
    if(planId){
      handleRequest(
        () => axiosClient
      .get(`/plans/${planId}`),
        setLoading,
        setPlan(),
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
                    type="date"
                    className="input"
                    placeholder="date début"
                    name="startDate"
                    id="startDate"
                    value={inputs.startDate ||""}
                   onChange={(e)=>{handleChange(e,setInputs)}}
                   min={minDate}
                  />
                  <label htmlFor="startDate" className="input__label">date début</label>
                </div>
                <div className="input__group">
                  <input
                    type="date"
                    className="input"
                    placeholder="date Fin"
                    name="endDate"
                    id="endDate"
                    value={inputs.endDate ||""}
                   onChange={(e)=>{handleChange(e,setInputs)}}
                   min={minDate}
                  />
                  <label htmlFor="endDate" className="input__label">date Fin</label>
                </div>
              </div>
              <div>
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
                {
                    planId &&                 
                    <StatusSelector inputs={inputs} handleChange={(e)=>{handleChange(e,setInputs)}}/>
                }
     
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


export default FormPlan