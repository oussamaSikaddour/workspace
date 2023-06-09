import React, { useEffect, useRef, useState } from 'react'
import FirstForm from './FirstForm';
import SecondForm from './SecondForm';


const Register = ({extendForm,registerRef}) => {

  const [userEmail, setUserEmail] = useState(
    JSON.parse(localStorage.getItem("userEmail")) || null
  );


  const formsRef = useRef(null);

  const slideForms = ()=>{
    formsRef.current.classList.add("slide");
  }


  useEffect(() => {
    if(userEmail){
      slideForms();
   }}, [])


  return (


<div className="forms" ref={formsRef}>
<FirstForm extendForm={extendForm} registerRef={registerRef} slideForms={slideForms}/>
 <SecondForm extendForm={extendForm} registerRef={registerRef}/>
</div>
  )
}

export default Register