import React, { useState } from 'react'
import { handleChange, handleRequest } from '../../util/util';
import axiosClient from '../../axios';
import Loading from '../../components/Loading';
import Toast from '../../components/Toast';
import Errors from '../../components/Errors';

const ContactUs = () => {

  const[loading, setLoading]=useState(false);
  const [errors, setErrors]= useState({
    isErrorsOpen : false,
    content:null, 
  })
  const [toast ,setToast] = useState({
    isToastOpen:false,
    content:""
  })

  const [inputs, setInputs] = useState({
name:"",
email:"",
tel:"",
message:"",    
  });

  const handelSubmit= (e)=>{
    e.preventDefault()
   
       handleRequest(
         () => axiosClient.post("/userMessages",inputs),
         setLoading,
         (data) => {
           },
         setErrors,
         setToast,
         "votre message a été envoyer"
         )
     }
   

  return (
  <>
 
        <div className="section maxWidth">
          <div className="section__header">
            <h1>Contactez-Nous</h1>
          </div>
          <div className="section__body">
            <div>
              <div className="form__container">
                <form className="form" method="POST" onSubmit={handelSubmit}>
                  <div className="input__group">
                    <input
                      type="text"
                      className="input"
                      placeholder="Nom"
                      name="name"
                      id="name"
                      onChange={(e)=>{handleChange(e,setInputs)}}
                    />
                    <label htmlFor="name" className="input__label">Nom</label>
                  </div>
                  <div className="input__group">
                    <input
                      type="email"
                      className="input"
                      placeholder="Votre email valide"
                      name="email"
                      onChange={(e)=>{handleChange(e,setInputs)}}
                    />
                    <label htmlFor="email" className="input__label">Votre email valide</label>
                  </div>
                  <div className="input__group">
                    <input
                      type="text"
                      className="input"
                      placeholder="Téléphone"
                      name="tel"
                      id="tel"
                      onChange={(e)=>{handleChange(e,setInputs)}}
                    />
                    <label htmlFor="tel" className="input__label">Téléphone</label>
                  </div>
                  <div className="textarea__group">
                    <textarea
                      className="textarea"
                      id="message"
                      name="message"
                      rows="2"
                      cols="100"
                      maxLength="200"
                      placeholder="Enter your message here"
                      onChange={(e)=>{handleChange(e,setInputs)}}
                    >
                    </textarea>
                    <label htmlFor="message" className="textarea__label">Message</label>
                  </div>
                  <div className="form__actions">
                  { loading ? <div><Loading/></div>:<>
    <button type='submit'
      className="button button--primary">
      Envoyer
    </button>
    </> }
                  </div>
                </form>
              </div>
              <div>
                  <ul>
                    <li><span><i className="fa-solid fa-location-dot"></i></span> 	
                      Boulevard Khaldi Mohamed, Tlemcen 13000</li>
                    <li><span><i className="fa-solid fa-phone"></i></span> 043 50 25 25/05 51 65 84 49</li>
                    <li><span><i className="fa-solid fa-envelope"></i></span>info@itpartner.com</li>
                    <li><span><i className="fa-solid fa-clock"></i></span>	
                      Dim. - Jeu. 09:00 - 17:00</li>
                  </ul>
              </div>
              
            </div>
       
          </div>
      </div>

      <Toast
      isOpened={toast.isToastOpen} 
  onClose={()=>setToast(prevState => ({
                  ...prevState,
                  isToastOpen: false
                                     }))}>
     {toast.content}

  </Toast>
<Errors isOpened={errors.isErrorsOpen} 
  onClose={()=>setErrors(prevState => ({
                  ...prevState,
                  isErrorsOpen: false
                                     }))}>
     {errors.content}
  </Errors>

  </>
  )
}

export default ContactUs