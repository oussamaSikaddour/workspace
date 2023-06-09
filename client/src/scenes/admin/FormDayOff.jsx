import React, { useEffect, useState } from 'react'
import Toast from '../../components/Toast';
import Errors from '../../components/Errors';
import { handleChange, handleRequest, minDateRequired } from '../../util/util';
import axiosClient from '../../axios';
import Loading from '../../components/Loading';

const FormDayOff = ({setRenderDaysOff,workSpaceId=null, dayOffId=null})  => {
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
 daysOffStart:"",
 daysOffEnd:""

  });

  const today= new Date();
  const tomorrow = today.setDate(today.getDate() + 1)

  const minDate = useState(minDateRequired(tomorrow))[0];

  const setDayOff = () => {
    return ({dayOff}) => {
const{workSpaceId, daysOffStart,daysOffEnd} = dayOff
      setInputs(prev => ({
        ...prev,
        workSpaceId,
        daysOffStart,
        daysOffEnd
      }));
    }
  }

  const handleSubmit = (e) => {
    e.preventDefault();
    if(dayOffId){
      handleRequest(
        () => axiosClient
      .patch(`/daysOff/${dayOffId}`,inputs),
        setLoading,
        setDayOff(),
        setErrors,
        setToast,
        "jours de congé  modifier avec succès"
        )

    }else{
      inputs.workSpaceId=workSpaceId
      handleRequest(
        () => axiosClient
      .post("/daysOff",inputs),
        setLoading,
        setDayOff(),
        setErrors,
        setToast,
        "jours de congé  ajouté avec succès"
        )

    }
    setRenderDaysOff();

  }

  useEffect(()=>{
    if(dayOffId){
      handleRequest(
        () => axiosClient
      .get(`/daysOff/${dayOffId}`),
        setLoading,
        setDayOff(),
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
                    placeholder="début des jours de congé"
                    name="daysOffStart"
                    id="daysOffStart"
                    value={inputs.daysOffStart ||""}
                   onChange={(e)=>{handleChange(e,setInputs)}}
                   min={minDate}
                  />
                  <label htmlFor="daysOffStart" className="input__label">début des jours de congé</label>
                </div>
                <div className="input__group">
                  <input
                    type="date"
                    className="input"
                    placeholder="début des jours de congé"
                    name="daysOffEnd"
                    id="daysOffEnd"
                    value={inputs.daysOffEnd ||""}
                   onChange={(e)=>{handleChange(e,setInputs)}}
                   min={minDate}
                  />
                  <label htmlFor="daysOffEnd" className="input__label">fin des jours de congé</label>
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


export default FormDayOff