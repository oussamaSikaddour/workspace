import React, { useEffect, useState } from 'react'
import Errors from '../../components/Errors'
import Toast from '../../components/Toast';
import Loading from '../../components/Loading';
import { handleChange, handleRequest } from '../../util/util';
import axiosClient from '../../axios';

const GeneralSettings = () => {
  const[loading, setLoading]=useState(false);
  const[loadingBackup, setLoadingBackup]=useState(false);
  const [errors, setErrors]= useState({
    isErrorsOpen : false,
    content:null, 
  })
  const [toast ,setToast] = useState({
    isToastOpen:false,
    content:""
  })
  const [inputs, setInputs] = useState({
    maintenance:""
  });

  
  const setGeneralSetting = () =>  ({generalSettings}) => {
      console.log(generalSettings);
      const {maintenance} = generalSettings;
      setInputs(prev => ({
        ...prev,
        maintenance
      }));
    }
  

  const handleSubmit = (e) => {

    e.preventDefault();

    handleRequest(
      () => axiosClient.patch(`gSettings/1`,inputs),
      setLoading,
       setGeneralSetting(),
      setErrors,
      setToast,
      "Vous avez mis à jour avec succès ces paramètres généraux"
      )
  

  }

  useEffect(()=>{
    handleRequest(
      () => axiosClient.get("gSettings/1"),
      setLoading,
      setGeneralSetting(),
      setErrors,
      )
  },[])


  const downloadBackup = () =>{
    handleRequest(
      () => axiosClient.get("/createBackup"),
      setLoadingBackup,
      ({data})=>{
        const url = window.URL.createObjectURL(new Blob([data]));
        const a = document.createElement('a');
        a.href = url;
        a.download = 'backup.sql';
        document.body.appendChild(a);
        a.click();
        a.remove();
      },
      setErrors,
      )
  }
  return (
<>
<main className="container__fluid">
      <section className="section withForm">
        <h2>paramètre general de la platform</h2>


        <div className="form__actions">
              { loadingBackup ? <div><Loading/></div>:
                <button className="button button--primary" onClick={downloadBackup}>
                  donwload backup
                </button> }
  </div>
        <div className="form__container">
          <form className="form" onSubmit={handleSubmit} method="POST">
            <h3 className="primary">
            Veuillez fournir les renseignements suivants :
            </h3>
     
      

<div className="chooseDate">
  <input
    type="radio"
    id="choice1"
    name="maintenance"
    value="1"
    checked={parseInt(inputs.maintenance) === 1}
    onChange={(e) => {
      handleChange(e, setInputs);
    }}
  />
  <label htmlFor="choice1">activer le mode maintenance</label>
  <input
    type="radio"
    id="choice2"
    name="maintenance"
    value="0"
    checked={parseInt(inputs.maintenance) === 0}
    onChange={(e) => {
      handleChange(e, setInputs);
    }}
  />
  <label htmlFor="choice2">desactiver le mode maintenance</label>
</div>


            <div>
            { loading ? <div><Loading/></div>:
             <button className="button button--primary" type="submit">
              Valider
             </button>}
            </div>
          </form>
        </div>
      </section>
    </main>

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

export default GeneralSettings