import React, { useState } from 'react'
import { handleChange, handleRequest, minDateRequired } from '../../util/util';
import Toast from '../../components/Toast';
import Errors from '../../components/Errors';

import Loading from '../../components/Loading';
import WorkSpaceSelector from '../../components/selectors/WorkSpaceSelector';
import { useStateContext } from '../../contexts/ContextProvider';
import TimeSelector from '../../components/selectors/TimeSelector';
import WorkSpaces from '../../components/workSpace/Workspaces';
import axiosClient from '../../axios';




const FormBooking = ({setRenderBookings}) => {
  const { currentUser} = useStateContext();
  const[loading,setLoading]=useState(false)
  const [workSpaceId, setWorkSpaceId] = useState(null)

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
     planId:"",
     userId:currentUser.id,
     startDate:"",
     endDate:"",
     startTime:"",
     endTime:"",
     numberOfPersons:""
  });


  const today= new Date();
  const tomorrow = today.setDate(today.getDate() + 1)

  const minDate = useState(minDateRequired(tomorrow))[0];



  const handleSubmit = (e) => {
    e.preventDefault();
   inputs.workSpaceId = workSpaceId
    if(inputs.workSpaceId==="") {
    setErrors(prevState => ({
      ...prevState,
      isErrorsOpen: true,
      content: <li className='error'> vous devez au moins sélectionner un espace de travail </li> 
                         }))
                        }else{
                        

    handleRequest(
      () => axiosClient.post("/bookings", inputs),
      setLoading,
      (data) => {
        setRenderBookings();
      },
      setErrors,
      setToast,
      "rendez-vous pris avec succès"
    );
                        }
  };
  return (
<>
<div className="form__container">
          <form className="form" onSubmit={handleSubmit} method="POST"> 
      
              <div>
               <WorkSpaces inputs={inputs} handleChange={(e)=>{handleChange(e,setInputs)}}  workSpaceId={workSpaceId} setWorkSpaceId={setWorkSpaceId} />
                 </div>
                  <div>
                <div className="input__group">
                  <input
                    type="date"
                    className="input"
                    placeholder="début de la periode"
                    name="startDate"
                    id="startDate"
                    value={inputs.startDate ||""}
                   onChange={(e)=>{handleChange(e,setInputs)}}
                   min={minDate}
                  />
                  <label htmlFor="startDate" className="input__label">début de période</label>
                </div>
                <div className="input__group">
                  <input
                    type="date"
                    className="input"
                    placeholder="fin de la période"
                    name="endDate"
                    id="endDate"
                    value={inputs.endDate ||""}
                   onChange={(e)=>{handleChange(e,setInputs)}}
                   min={minDate}
                  />
                  <label htmlFor="endDate" className="input__label">fin de période</label>
                </div>
                </div>
                <div>
                <div className="input__group">
                  <input
                    type="number"
                    className="input"
                   name="numberOfPersons"
                    placeholder="Nombre de personnes"
                    id="numberOfPersons"
                    value={inputs.numberOfPersons ||""}
                   onChange={(e)=>{handleChange(e,setInputs)}}
                  />
                  <label htmlFor="numberOfPersons" className="input__label">Nombre de personnes</label>
                </div>
                  </div>

         
                    <div>
                      <h2>sélectionner l'heure de début et l'heure de fin n'est pas obligatoire</h2>
                    </div>
          
                    <div>
        <p>heur de début :</p> <TimeSelector inputs={inputs} handleChange={(e)=>{handleChange(e,setInputs)}} type="startTime"/>
        </div>
        <div>

        <p>heur de fin:</p> <TimeSelector inputs={inputs} handleChange={(e)=>{handleChange(e,setInputs)}} type="endTime"/>
      </div>
                  
                 <div>
                       <div>
                     { loading ? <div><Loading/></div>:
                        <button className="button button--primary " type='submit'>
                            Réservez  <i className="fa-solid fa-magnifying-glass"></i>
                       </button>}
                      </div>
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

export default FormBooking