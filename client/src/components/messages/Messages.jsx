import React, { useEffect, useRef, useState } from 'react'
import axiosClient from '../../axios';
import { useStateContext } from '../../contexts/ContextProvider';
import { getdateFormat, handleRequest } from '../../util/util';
import Loading from '../Loading';
import Errors from '../Errors';



const Messages = () => {
  const {currentUser} = useStateContext();
  const [messages,setMessages] = useState([]);
  const [showMessages, setShowMessages]= useState(false)
  const [renderMessages, setRenderMessages]= useState(false)
  const [unreadMessagesCount, setUnreadMessagesCount]= useState(0);
  const messagesRef = useRef(null);
  const[loading, setLoading]=useState(false);
  
  const [errors, setErrors]= useState({
    isErrorsOpen : false,
    content:null, 
  })

  
  useEffect(()=>{
      const messageContainer = messagesRef.current
    if(showMessages){
      messageContainer.classList.add("show")
    }else{
      messageContainer.classList.remove("show")
    }
  },[showMessages])
  useEffect(() => {

    handleRequest(
      () => axiosClient
    .get(`/messages?userId=${currentUser.id}`,),
      setLoading,
    ({messages})=>{
      setMessages(messages)
      const unreadMessages = messages.filter(message => message.state === 'unread');
      setUnreadMessagesCount(unreadMessages.length);
    },
      setErrors
      )
  }, [renderMessages]);
  


  const handleNewMessages  = ()=>{
    setShowMessages(true)
    handleRequest(
      () => axiosClient
    .get(`/messages?userId=${currentUser.id}&updateMessages=true`,),
      setLoading,
    ({messages})=>{
      setMessages(messages)
      setRenderMessages(prev =>!prev)
    },
      setErrors
      )
  }
  return (
    <>
 
      <div ref={messagesRef} className="message__container">
  <div className="message__header">
    <span className="message__close" onClick={()=>{
      setShowMessages(false)
    }}>&times;</span>
    Administration
  </div>{ loading ? <div className='message'> <Loading/></div> :
  <div className="messages">
    { messages?.length > 0 ? messages.slice().map((message) => (
      <div className="message" key={message.id}>
        {message.content}
        <span className="message__date">{getdateFormat(message.createdAt)}</span>
      </div>
    )): <div className='message'><p>vous n'avez pas de message pour le moment</p></div>}
  </div>}
</div>


<button className="button button--primary rounded message__button" onClick={handleNewMessages}>
  <i className="fa-regular fa-message"></i>
  {unreadMessagesCount> 0 && <span>{unreadMessagesCount}</span>}
</button>

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

export default Messages