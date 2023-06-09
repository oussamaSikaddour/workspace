import React, { useEffect, useState } from 'react'
import Modal from '../../components/Modal';
import Table from '../../components/table/Table';
import Toast from '../../components/Toast';
import Errors from '../../components/Errors';
import Loading from '../../components/Loading';
import { handleRequest } from '../../util/util';
import axiosClient from '../../axios';
import UserMessage from '../../scenes/admin/UserMessage';




const UserMessages = () => {

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

  const [UserMessages ,setUserMessages]=useState([]);
const UserMessagesThs=[ "nom", "email", "tel","Date d'envoi","actions"]
const [activeUserMessagesRow, setActiveUserMessagesRow]= useState(null)


  useEffect(()=>{
    handleRequest(
      () => axiosClient.get("/userMessages"),
      setLoading,
      ({messages }) => {
        setActiveUserMessagesRow(messages[0]?.id)
        const htmlData = messages.map(userMessage => ({
          ...userMessage,
          buttonElement:<>
          <button
          className="button rounded"
          onClick={() => {
            setActiveUserMessagesRow(userMessage.id)
            setModal((prevState) => ({
              ...prevState,
              isModalOpen: true,
              title: "Message détaillé",
              content: (
                <UserMessage
                userMessageId={userMessage.id}
                />
              ),
            }));
          }}
        >
   <i className="fa-solid fa-eye"></i>
        </button>


        <button className="button rounded" onDoubleClick={() => {

            deleteUserMessage(userMessage.id) 
        }
            }>
                  <i className="fa-solid fa-trash"></i>
        </button>
        </>
        
        }));
     setUserMessages(htmlData);
      },
      setErrors,
      )

  },[])


  const  deleteUserMessage=(id)=>{

    handleRequest(
      () => axiosClient.delete(`/userMessages/${id}`),
      setLoading,
      ( data ) => {
            setUserMessages(prevState => prevState.filter(item => item.id !== id));   
            },
      setErrors,
      setToast,
      "message supprimer avec succès"
      )
  
  }
  return (
<>

      <section className="section">
  

<div> 

      </div>

        <div>{loading && <Loading/>}
        {!loading && UserMessages?.length ? <Table ths={UserMessagesThs} data={UserMessages} setSortedData={setUserMessages} activeRow={activeUserMessagesRow}/>:<div><h2>Cet jours de congé n'a pas de jours fériés</h2></div> }
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

export default UserMessages