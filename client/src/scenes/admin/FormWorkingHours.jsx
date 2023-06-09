import React, { useEffect, useState } from 'react'
import Toast from '../../components/Toast';
import Errors from '../../components/Errors';
import { handleChange, handleRequest } from '../../util/util';
import axiosClient from '../../axios';
import Loading from '../../components/Loading';
import DayOfWeekSelector from '../../components/selectors/DayOfWeekSelector';
import TimeSelector from '../../components/selectors/TimeSelector';

const FormWorkingHours = ({setRenderWorkingHours,workSpaceId=null, workingHoursId=null})  => {
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
    dayOfWeek:"",
    openTime:"",
    closeTime:""

  });



  const setWorkingHours = () => {
    return ({openingHour}) => {
const{workSpaceId, dayOfWeek,openTime,closeTime} = openingHour
      setInputs(prev => ({
        ...prev,
        workSpaceId,
        dayOfWeek,
        openTime,
        closeTime
      }));
    }
  }

  const handleSubmit = (e) => {
    e.preventDefault();
    if(workingHoursId){
      handleRequest(
        () => axiosClient
      .patch(`/openingHours/${workingHoursId}`,inputs),
        setLoading,
        setWorkingHours(),
        setErrors,
        setToast,
        "heurs de travail  modifier avec succès"
        )

    }else{
      inputs.workSpaceId=workSpaceId
      handleRequest(
        () => axiosClient
      .post("/openingHours",inputs),
        setLoading,
        setWorkingHours(),
        setErrors,
        setToast,
        "heurs de travail  ajouté avec succès"
        )

    }
    setRenderWorkingHours();

  }

  useEffect(()=>{
    if(workingHoursId){
      handleRequest(
        () => axiosClient
      .get(`/openingHours/${workingHoursId}`),
        setLoading,
        setWorkingHours(),
        setErrors
        )

    }
  },[])
  return (
<>
  <div className="form__container">
    <form className="form etablissement__form" onSubmit={handleSubmit} method="POST">
      <div>
          <p>jour de la semaine : </p>  <DayOfWeekSelector inputs={inputs} handleChange={(e)=>{handleChange(e,setInputs)}}/>
      </div>
      <div>
        <p>heur d ouverture :</p> <TimeSelector inputs={inputs} handleChange={(e)=>{handleChange(e,setInputs)}} type="openTime"/>

        <p>heur de fermeture :</p> <TimeSelector inputs={inputs} handleChange={(e)=>{handleChange(e,setInputs)}} type="closeTime"/>
      </div>
      <div className='form__actions'>
        {loading ? (
          <div><Loading/></div>
        ) : (
          <button className="button button--primary" type="submit">
            Valider
          </button>
        )}
      </div>
    </form>
  </div>

  <Toast isOpened={toast.isToastOpen} onClose={()=>setToast(prevState => ({ ...prevState, isToastOpen: false }))}>
    {toast.content}
  </Toast>

  <Errors isOpened={errors.isErrorsOpen} onClose={()=>setErrors(prevState => ({ ...prevState, isErrorsOpen: false }))}>
    {errors.content}
  </Errors>
</>

  )
}


export default FormWorkingHours