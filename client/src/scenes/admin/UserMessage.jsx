import React, { useEffect, useState } from 'react'
import Toast from '../../components/Toast';
import Errors from '../../components/Errors';
import { handleChange, handleRequest, minDateRequired } from '../../util/util';
import axiosClient from '../../axios';
import Loading from '../../components/Loading';

const UserMessage = ({ userMessageId=null})  => {
  const[loading, setLoading]=useState(false);
  const [errors, setErrors]= useState({
    isErrorsOpen : false,
    content:null, 
  })


  const [userMessage, setUserMessage] = useState({

  });

  const today= new Date();
  const tomorrow = today.setDate(today.getDate() + 1)

  const minDate = useState(minDateRequired(tomorrow))[0];



  useEffect(()=>{
    if(userMessageId){
      handleRequest(
        () => axiosClient
      .get(`/userMessages/${userMessageId}`),
        setLoading,
       ({userMessage})=>{
        setUserMessage(userMessage)
       },
        setErrors
        )

    }
  },[])
  return (
<>
<div className="form__container">
                <form className="form" >
                  <div className="input__group">
                    <input
                      type="text"
                      className="input"
                      placeholder="Nom"
                      name="name"
                      id="name"
                      defaultValue={userMessage.name ||""}
    
                    />
                    <label htmlFor="name" className="input__label">Nom</label>
                  </div>
                  <div className="input__group">
                    <input
                      type="email"
                      className="input"
                      placeholder="Votre email valide"
                      name="email"
                    defaultValue={userMessage.email ||""}
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
                    defaultValue={userMessage.tel||""}
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
                    defaultValue={userMessage.message ||""}
                    >
                    </textarea>
                    <label htmlFor="message" className="textarea__label">Message</label>
                  </div>

                </form>
              </div>

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


export default UserMessage