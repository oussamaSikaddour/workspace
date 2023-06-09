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
import FormPlan from '../../scenes/admin/FromPlan';




const plans = () => {
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

  const [plans ,setPlans]=useState([]);
const plansThs=[ "capacité","date de début","date de fin",'état', "actions"]
const [plansId, setPlansId]= useState(null);
const [renderPlans ,setRenderPlans]=useState(false);
const [activePlansRow, setActivePlansRow]= useState(null)


  useEffect(()=>{
    handleRequest(
      () => axiosClient.get(`/plans?workSpace=${id}`),
      setLoading,
      ({plans }) => {
        setActivePlansRow(plans[0]?.id)
        const htmlData = plans.map(plan => ({
          ...plan,
          buttonElement:<>
          <button
          className="button rounded"
          onClick={() => {
            setActivePlansRow(plan.id)
            setModal((prevState) => ({
              ...prevState,
              isModalOpen: true,
              title: "Modifier les plannings",
              content: (
                <FormPlan
                planId={plan.id}
                setRenderPlans={()=>setRenderPlans(prevState => !prevState)}
                />
              ),
            }));
          }}
        >
          <i className="fa-solid fa-pen-to-square"></i>
        </button>

        <button className="button rounded" onDoubleClick={() => { deletePlan(plan.id) }}>
                  <i className="fa-solid fa-trash"></i>
        </button>
        </>
        
        }));
     setPlans(htmlData);
      },
      setErrors,
      )

  },[renderPlans])


  const  deletePlan=(id)=>{

    handleRequest(
      () => axiosClient.delete(`/plans/${id}`),
      setLoading,
      ( data ) => {
            setPlans(prevState => prevState.filter(item => item.id !== id));   
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
                    title:"ajouter les plannings",
                    content:<FormPlan
                    workSpaceId={id}
                    setRenderPlans={()=>setRenderPlans(prevState => !prevState)
                    }
                    />,
                  }));
                }} >
     <i className="fa-solid fa-calendar-days"></i>
          Ajouter plannings
        </button>

      </div>

        <div>{loading && <Loading/>}
        {!loading && plans?.length ? <Table ths={plansThs} data={plans} setSortedData={setPlans} activeRow={activePlansRow}/>:<div><h2>Cet espace de travail n'a pas de planning</h2></div> }
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

export default plans