import React, { useEffect, useRef, useState } from 'react';
import Modal from '../components/Modal';

const ImageZoom = ({ img }) => {


  const [modal, setModal]= useState({
    isModalOpen : false,
    content:null,
    title:"", 
  })


  return (
    <>

    <div className="active__img"
    
    onClick={() => {
      setModal((prevState) => ({
        ...prevState,
        isModalOpen: true,
        content: <img className="modal__img" src={img.url} alt={img.name} />,
      }));
    }}
    >
      <img src={img.url} alt={img.name} 
      />
    </div>

    <Modal variant={"l"} title={modal.title} isOpened={modal.isModalOpen} 
  onClose={()=>setModal(prevState => ({
                  ...prevState,
                  isModalOpen: false
                                     }))}>
{modal.content}
  </Modal>

    </>
  );
};

export default ImageZoom;
