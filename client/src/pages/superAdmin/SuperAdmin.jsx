import React, { useState } from 'react'
import Modal from '../../components/Modal';
import Toast from '../../components/Toast';
import Errors from '../../components/Errors';
import Loading from '../../components/Loading';
import { handleChange, handleRequest } from '../../util/util';
import axiosClient from '../../axios';
import FormAdmin from '../../scenes/superAdmin/FormAdmin';
import Table from '../../components/table/Table';
import FormAbilities from '../../scenes/superAdmin/FromAbilities';

const SuperAdmin = () => {


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
  const [inputs, setInputs] = useState({
name:"",
email:"",
ability:""
  })
  const [administrators, setAdministrators] = useState([]);
  const [ activeAdministratorsRow,  setActiveAdministratorsRow]= useState(null);
const [renderAdministrators,setRenderAdministrators]= useState(false);

  const administratorsThs = [ 'nom complet', 'email', 'téléphone',"les droits d'accès","actions"]


const handleSubmit = (e)=>{
  e.preventDefault()
  const {name,email,ability}= inputs
    handleRequest(
      () => axiosClient.get("/users",{  
        params: {
              
        ...(name !== '' && { name }),
        ...(email !== '' && { email }),
        ...(ability !== '' && { ability}),


      },
    }),
      setLoading,
      ({ users }) => {
        setActiveAdministratorsRow(users[0]?.id)
        const htmlData = users.map((admin, index) => {

          return {
            ...admin,
            buttonElement: (<>
                <button
                  className="button rounded"
                  onClick={()=>{
                    setModal((prevState) => ({
                      ...prevState,
                      isModalOpen: true,
                      title:"Adjouter un adminstrateur" ,
                      content: <FormAdmin   setRenderAdministrators={()=>setRenderAdministrators(prevState => !prevState)} adminId={admin.id} />
                    }));
                  }}
                  
                  >
                  <i className="fa-solid fa-pen-to-square"></i>
                </button>
                <button
                  className="button rounded"
                  onClick={()=>{
                    setModal((prevState) => ({
                      ...prevState,
                      isModalOpen: true,
                      title:"gérer les droits d'accès" ,
                      content: <FormAbilities   setRenderAdministrators={()=>setRenderAdministrators(prevState => !prevState)} adminId={admin.id} />
                    }));
                  }}
                  
                  >
         <i className="fa-solid fa-link"></i>
                </button>
                </>
            ),
          };
        });
        setAdministrators(htmlData);
      },
      setErrors
    );
  }
  



  






  return (
    <>

      <section className="section admin">
        
      <div>
          <button className="button button--primary" onClick={() => {
        setModal((prevState) => ({
          ...prevState,
          isModalOpen: true,
          title:"Ajouter un adminstrateur" ,
          content: <FormAdmin setRenderAdministrators={()=>setRenderAdministrators(prevState => !prevState)} />
        }));
      }}>
            ajouter Un Adminstrateur <i className="fa-solid fa-user"></i>
          </button>
         </div>
      <div className="form__container">

          <form className="form"  method='GET' onSubmit={handleSubmit}>
            <h3>Filtrer la liste des administrateurs</h3>
         <div>
         <div className="input__group">
          <input
            type="text"
            className="input"
            placeholder="Nom"
            name="name"
            id="name"
          value={inputs.name|| ""}
            onChange={(e)=>{handleChange(e,setInputs)}}
          />
          <label htmlFor="name" className="input__label">Nom</label>
        </div>
        <div className="input__group">
          <input
            type="email"
            className="input"
            placeholder="email"
            name="email"
            id="email"
          value={inputs.email|| ""}
            onChange={(e)=>{handleChange(e,setInputs)}}
          />
          <label htmlFor="email" className="input__label">email</label>
        </div>
         </div>


        <div className='form__actions'>
        { loading 
        ? <div><Loading/></div>
        : <button className="button button--primary rounded" type="submit">
          <i className="fa-solid fa-magnifying-glass"></i>
          </button>
        }
        </div>
        </form>
        </div>
        <div>{loading && <Loading/>}
        {!loading && administrators?.length ? <Table ths={administratorsThs} data={administrators} setSortedData={setAdministrators} activeRow={activeAdministratorsRow} title={"liste des administrateurs"}/>:<div><h3>vous n'avez pas ajouté  des administrateurs pour le moment</h3></div> }
        </div>
      </section>

    <Modal  title={modal.title} isOpened={modal.isModalOpen} 
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

export default SuperAdmin