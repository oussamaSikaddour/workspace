import React, { useEffect, useState } from 'react';
import jsPDF from 'jspdf';
import Errors from '../Errors';
import { handleRequest } from '../../util/util';
import axiosClient from '../../axios';
import Loading from '../Loading';

const RendezVousPdf = ({rendezVous:{location, rendezVousId, doctor}}) => {
  const[loading, setLoading]=useState(false);
  const [errors, setErrors]= useState({
    isErrorsOpen : false,
    content:null, 
  })

  const returnTemplate = (rendezVous) =>{
return`
cod Patient: ${rendezVous?.patient?.code}                                           Tlemcen, le ${new Date().toLocaleDateString()}
Non :${rendezVous?.patient?.lastName}  ${rendezVous?.patient?.firstName}









Objet : confirmation du rendez-vous 

Madame, Monsieur,

Par la présente, je vous confirme que ce rendez-vous va avoir lieu 
le ${rendezVous?.dayAt} 
au niveau du centre : ${location} avec le médecin
 specialisite ${doctor}

Dans cette attente, je vous prie de recevoir, Madame, Monsieur,
 nos respectueuses salutations.

`;
  }

  const generate = () => {
    const doc = new jsPDF();
    handleRequest(
      () => axiosClient
    .get(`/rendezVous/${rendezVousId}`),
      setLoading,
     ({rendezVous})=>{
      const template = returnTemplate(rendezVous);
      const imgData = `/algeria.png`; // Replace with your image path
      doc.addImage(imgData, 'PNG', 10, 10, 20, 20); // Add the image to the PDF
      doc.text(template,10, 40); // Move the text a bit to the right to make space for the image
      doc.save('rendezvous.pdf');
     },
      setErrors,
    )

  };



  return (
    <>
     { loading ?<div><Loading/></div> : <button className="button rounded" onClick={generate}>
      <i className="fa-solid fa-file-pdf"></i>
    </button>}
    <Errors isOpened={errors.isErrorsOpen} 
  onClose={()=>setErrors(prevState => ({
                  ...prevState,
                  isErrorsOpen: false
                                     }))}>
     {errors.content}
  </Errors>
    </>
  );
};

export default RendezVousPdf;
