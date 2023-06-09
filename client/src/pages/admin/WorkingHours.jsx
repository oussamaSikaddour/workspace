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
import FormWorkingHours from '../../scenes/admin/FormWorkingHours';



const WorkingHours = () => {
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

  const [workingHours ,setWorkingHours]=useState([]);
const workingHoursThs=[ "Jour de semain", "heur d'ouverture","heur de fermeture", "actions"]
const [workingHoursId, setWorkingHoursId]= useState(null);
const [renderWorkingHours ,setRenderWorkingHours]=useState(false);
const [activeWorkingHoursRow, setActiveWorkingHoursRow]= useState(null)


  useEffect(()=>{
    handleRequest(
      () => axiosClient.get(`/openingHours?workSpace=${id}`),
      setLoading,
      ({openingHours }) => {
        setActiveWorkingHoursRow(openingHours[0]?.id)
        const htmlData = openingHours.map(workingHours => ({
          ...workingHours,
          buttonElement:<>
          <button
          className="button rounded"
          onClick={() => {
            setActiveWorkingHoursRow(workingHours.id)
            setModal((prevState) => ({
              ...prevState,
              isModalOpen: true,
              title: "Modifier les Heures de travail",
              content: (
                <FormWorkingHours
                workingHoursId={workingHours.id}
                setRenderWorkingHours={()=>setRenderWorkingHours(prevState => !prevState)}
                />
              ),
            }));
          }}
        >
          <i className="fa-solid fa-pen-to-square"></i>
        </button>

        <button className="button rounded" onDoubleClick={() => { deleteWorkingHours(workingHours.id) }}>
                  <i className="fa-solid fa-trash"></i>
        </button>
        </>
        
        }));
     setWorkingHours(htmlData);
      },
      setErrors,
      )

  },[renderWorkingHours])


  const  deleteWorkingHours=(id)=>{

    handleRequest(
      () => axiosClient.delete(`/openingHours/${id}`),
      setLoading,
      ( data ) => {
            setWorkingHours(prevState => prevState.filter(item => item.id !== id));   
            },
      setErrors,
      setToast,
      "espace de travail supprimer avec succès"
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
                    title:"ajouter les Heures de travail",
                    content:<FormWorkingHours
                    workSpaceId={id}
                    setRenderWorkingHours={()=>setRenderWorkingHours(prevState => !prevState)
                    }
                    />,
                  }));
                }} >
    <i className="fa-solid fa-clock"></i>
          Ajouter Heures de travail
        </button>

      </div>

        <div>{loading && <Loading/>}
        {!loading && workingHours?.length ? <Table ths={workingHoursThs} data={workingHours} setSortedData={setWorkingHours} activeRow={activeWorkingHoursRow}/>:<div><h2>Cet espace de travail n'a pas de hours de travail</h2></div> }
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

export default WorkingHours