import React, { useEffect, useState } from 'react'
import Modal from '../../components/Modal';
import Table from '../../components/table/Table';
import Toast from '../../components/Toast';
import Errors from '../../components/Errors';
import Loading from '../../components/Loading';
import FormBooking from '../../scenes/user/FormBooking';
import { handleRequest } from '../../util/util';
import axiosClient from '../../axios';
import { useStateContext } from '../../contexts/ContextProvider';








const User = () => {
  const { currentUser} = useStateContext();
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

  const [bookings ,setBookings]=useState([]);
const bookingsThs=[
  'espace de travail',
  'Nombre de personnes',
  'statut de paiement',
  'prix total' ,
  'date de début' ,
  'date de fin',
  'Heure de début',
  'heure de fin',
  'Actions'
 ]
const [bookingId, setBookingId]= useState(null);
const [renderBookings ,setRenderBookings]=useState(false);
const [activeBookingsRow, setActiveBookingsRow]= useState(null)


useEffect(() => {
  handleRequest(
    () => axiosClient.get(`/bookings?userId=${currentUser.id}`),
    setLoading,
    ({ bookings }) => {
      setActiveBookingsRow(bookings[0]?.id);
      const htmlData = bookings.map((booking) => ({
        ...booking,
        buttonElement: (
            <button
              className="button rounded"
              onDoubleClick={() => {
                deleteBooking(booking.id);
              }}
            >
              <i className="fa-solid fa-trash"></i>
            </button>
        ),
      }));
      setBookings(htmlData);
    },
    setErrors
  );
}, [renderBookings]); // Added `currentUser` as a dependency




  const  deleteBooking=(id)=>{

    handleRequest(
      () => axiosClient.delete(`/bookings/${id}`),
      setLoading,
      ( data ) => {
            setBookings(prevState => prevState.filter(item => item.id !== id));   
            },
      setErrors,
      setToast,
      "réservation supprimer avec succès"
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
                    title:"prendre une réservation",
                    content:<FormBooking
                    setRenderBookings={()=>setRenderBookings(prevState => !prevState)
                    }
                    />,
                  }));
                }} >
        <i className="fa-solid fa-check"></i>
        prendre une réservation
        </button>

      </div>

        <div>{loading && <Loading/>}
        {!loading && bookings?.length ? <Table ths={bookingsThs} data={bookings} setSortedData={setBookings} activeRow={activeBookingsRow}/>:<div><h2>Vous n'avez aucune réservation</h2></div> }
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

export default User