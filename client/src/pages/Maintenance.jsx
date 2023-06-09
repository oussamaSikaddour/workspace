import React, { useEffect } from 'react'
import Footer from '../components/Footer'
import { useLogout, useStateContext } from '../contexts/ContextProvider';
import {  Navigate, useNavigate } from 'react-router-dom';
import Header from '../components/Header';


const Maintenance = () => {
  const { userToken,abilities } = useStateContext();
  const logout = useLogout();
  const navigate = useNavigate();
if(!userToken){
  return <Navigate to="/"/>
}

useEffect(()=>{
if(abilities.includes("superAdmin")){
  navigate("/superAdmin/generalSettings")
}
},[abilities])
  const handleLogout = () => {
    logout();
  };
  return (<>
<Header/>
      <main className="container__fluid">
      <section className="section pageNotFound">
        <div>
          <h1>les site est en maintenance</h1>

          <button className="button button--primary rounded" onClick={handleLogout}>
           <i className="fa-solid fa-house"></i>
          </button>
        </div>
      </section>
    </main>

  <Footer/>
  </>
  )
}

export default Maintenance