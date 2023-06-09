import React, { useEffect, useState } from 'react'
import Modal from '../../components/Modal';
import Table from '../../components/table/Table';
import Toast from '../../components/Toast';
import Errors from '../../components/Errors';
import Loading from '../../components/Loading';
import { handleRequest } from '../../util/util';
import axiosClient from '../../axios';
import { useStateContext } from '../../contexts/ContextProvider';

import { Link, useParams } from 'react-router-dom';
import FormDayOff from '../../scenes/admin/FormDayOff';







const DaysOff = () => {
  const { id } = useParams();

  const[loading, setLoading]=useState(false);
  const [errors, setErrors]= useState({
    isErrorsOpen : false,
    content:null, 
  })
  const [toast ,setToast] = useState({
    isToastOpen:false,
    content:""
  })

  const [modal, setModal]= useState({
    isModalOpen : false,
    content:null,
    title:"", 
  })

  const [daysOffs ,setDaysOffs]=useState([]);
const daysOffsThs=[ "début des jours de congé", "fin des jours de congé", "actions"]
const [dayOffId, setDayOffId]= useState(null);
const [renderDaysOffs ,setRenderDaysOff]=useState(false);
const [activeDaysOffsRow, setActiveDaysOffsRow]= useState(null)


  useEffect(()=>{
    handleRequest(
      () => axiosClient.get(`/daysOff?workSpace=${id}`),
      setLoading,
      ({daysOff }) => {
        setActiveDaysOffsRow(daysOff[0]?.id)
        const htmlData = daysOff.map(dayOff => ({
          ...dayOff,
          buttonElement:<>
          <button
          className="button rounded"
          onClick={() => {
            setActiveDaysOffsRow(dayOff.id)
            setModal((prevState) => ({
              ...prevState,
              isModalOpen: true,
              title: "Modifier jours de congé",
              content: (
                <FormDayOff
                dayOffId={dayOff.id}
                setRenderDaysOff={()=>setRenderDaysOff(prevState => !prevState)}
                />
              ),
            }));
          }}
        >
          <i className="fa-solid fa-pen-to-square"></i>
        </button>

        <button className="button rounded" onDoubleClick={() => { deleteDayOff(dayOff.id) }}>
                  <i className="fa-solid fa-trash"></i>
        </button>
        </>
        
        }));
     setDaysOffs(htmlData);
      },
      setErrors,
      )

  },[renderDaysOffs])


  const  deleteDayOff=(id)=>{

    handleRequest(
      () => axiosClient.delete(`/daysOff/${id}`),
      setLoading,
      ( data ) => {
            setDaysOffs(prevState => prevState.filter(item => item.id !== id));   
            },
      setErrors,
      setToast,
      "jours de congé supprimer avec succès"
      )
  
  }
  return (
<>

      <section className="section">
  

<div> 
        <button className="button"
                 onClick={() => {
                  setModal((prevState) => ({
                    ...prevState,
                    isModalOpen: true,
                    title:"ajouter des jour de congé",
                    content:<FormDayOff
                    workSpaceId={id}
                    setRenderDaysOff={()=>setRenderDaysOff(prevState => !prevState)
                    }
                    />,
                  }));
                }} >
          <i className="fa-solid fa-umbrella-beach"></i>
          Ajouter Jours de congés
        </button>

      </div>

        <div>{loading && <Loading/>}
        {!loading && daysOffs?.length ? <Table ths={daysOffsThs} data={daysOffs} setSortedData={setDaysOffs} activeRow={activeDaysOffsRow}/>:<div><h2>Cet jours de congé n'a pas de jours fériés</h2></div> }
        </div>
      </section>

    <Modal 
    variant={"l"} 
    title={modal.title} isOpened={modal.isModalOpen} 
  onClose={()=>setModal(prevState => ({
                  ...prevState,
                  isModalOpen: false
                                     }))}>
{modal.content}
  </Modal>

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

export default DaysOff