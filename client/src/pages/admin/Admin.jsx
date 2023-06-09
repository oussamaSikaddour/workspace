import React, { useEffect, useState } from 'react'
import Modal from '../../components/Modal';
import Table from '../../components/table/Table';
import Toast from '../../components/Toast';
import Errors from '../../components/Errors';
import Loading from '../../components/Loading';
import { handleRequest } from '../../util/util';
import axiosClient from '../../axios';
import { useStateContext } from '../../contexts/ContextProvider';

import { Link } from 'react-router-dom';
import FormWorkSpace from '../../scenes/admin/FormWorkSpace';
import UpdateProductStatus from '../../scenes/admin/UpdateProductStatus';






const Admin = () => {
  const [loading, setLoading] = useState(false);
  const [errors, setErrors] = useState({
    isErrorsOpen: false,
    content: null,
  });
  const [toast, setToast] = useState({
    isToastOpen: false,
    content: "",
  });
  
  const [modal, setModal] = useState({
    isModalOpen: false,
    content: null,
    title: "",
  });
  
  const [workSpaces, setWorkSpaces] = useState([]);
  const workSpacesThs = ['nom', 'emplacement', 'capacité', 'prix par heure'];
  
  const [renderWorkSpaces, setRenderWorkSpaces] = useState(false);
  
  const [activeWorkSpacesRow, setActiveWorkSpacesRow] = useState(() => {
    const storedActiveWorkSpace = localStorage.getItem("activeWorkSpace");
    return JSON.parse(storedActiveWorkSpace) || null;
  });
  
  const [workSpaceId, setWorkSpaceId] = useState(() => activeWorkSpacesRow);
  
  useEffect(() => {
    handleRequest(
      () => axiosClient.get(`/workspaces`),
      setLoading,
      ({ workSpaces }) => {
        const defaultActiveWorkSpaceId = workSpaces[0]?.id;
        const activeWorkSpaceId = workSpaceId || defaultActiveWorkSpaceId;
        localStorage.setItem("activeWorkSpace", JSON.stringify(activeWorkSpaceId));
        setActiveWorkSpacesRow(activeWorkSpaceId);
        const htmlData = workSpaces.map(workspace => ({
          ...workspace,
          buttonElement: (
            <>
              <button
                className="button rounded"
                onClick={() => {
                  setActiveWorkSpacesRow(workspace.id);
                  setWorkSpaceId(workspace.id);
                  localStorage.setItem("activeWorkSpace", JSON.stringify(workspace.id));
                  setModal((prevState) => ({
                    ...prevState,
                    isModalOpen: true,
                    title: "Modifier espace de travail",
                    content: (
                      <FormWorkSpace
                        workSpaceId={workspace.id}
                        setRenderWorkSpaces={setRenderWorkSpaces}
                      />
                    ),
                  }));
                }}
              >
                <i className="fa-solid fa-pen-to-square"></i>
              </button>
  
              <button
                className="button rounded"
                onDoubleClick={() => {
                  deleteWorkSpace(workspace.id, defaultActiveWorkSpaceId);
                }}
              >
                <i className="fa-solid fa-trash"></i>
              </button>
  
              <button
                className="button rounded"
                onClick={() => {
                  setActiveWorkSpacesRow(workspace.id);
                  setWorkSpaceId(workspace.id);
                  localStorage.setItem("activeWorkSpace", JSON.stringify(workspace.id));
                }}
              >
                <i className="fa-solid fa-check"></i>
              </button>
            </>
          ),
        }));
        setWorkSpaces(htmlData);
      },
      setErrors
    );
  }, [renderWorkSpaces]);
  
  const deleteWorkSpace = (id, defaultActiveWorkSpaceId) => {
    handleRequest(
      () => axiosClient.delete(`/workspaces/${id}`),
      setLoading,
      () => {
        setWorkSpaces(prevState => prevState.filter(item => item.id !== id));
          setActiveWorkSpacesRow(defaultActiveWorkSpaceId);
          setWorkSpaceId(defaultActiveWorkSpaceId);
          localStorage.setItem("activeWorkSpace", JSON.stringify(defaultActiveWorkSpaceId));  
      },
      setErrors,
      setToast,
      "Espace de travail supprimé avec succès"
    );
  };
  
  return (
<>

      <section className="section admin">
  

<div> 
        <div className="admin__action"
                 onClick={() => {
                  setModal((prevState) => ({
                    ...prevState,
                    isModalOpen: true,
                    title:"ajouter un Espace de travail",
                    content:<FormWorkSpace
          
                    setRenderWorkSpaces={()=>setRenderWorkSpaces(prevState => !prevState)
                    }
                    />,
                  }));
                }} >
          <i className="fa-solid fa-building"></i>
          <h2>Ajouter un espace de travail</h2>
        </div>
          { workSpaces?.length > 0 && <> <Link to={`${workSpaceId}/workingHours`} className="admin__action">
          <i className="fa-solid fa-clock"></i>
          <h2>Heures d'ouverture</h2>
        </Link>
        <Link to={`${workSpaceId}/daysOff`} className="admin__action">
          <i className="fa-solid fa-umbrella-beach"></i>
          <h2>Jours de congés</h2>
        </Link>
        <Link to={`${workSpaceId}/planning`} className="admin__action">
          <i className="fa-solid fa-calendar-days"></i>
          <h2>Planification</h2>
        </Link></>}
      </div>

        <div>{loading && <Loading/>}
        {!loading && workSpaces?.length ? <Table ths={workSpacesThs} data={workSpaces} setSortedData={setWorkSpaces} activeRow={activeWorkSpacesRow}/>:<div><h2>Il n'y a pas d'éspace de travail pour le moment</h2></div> }
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

export default Admin