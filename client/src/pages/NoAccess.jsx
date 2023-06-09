import React from 'react'
import Footer from '../components/Footer'
import { useLogout, useStateContext } from '../contexts/ContextProvider';
import { Navigate } from 'react-router-dom';
import Header from '../components/Header';

const NoAccess = () => {
  const { userToken } = useStateContext();
  const logout = useLogout();
if(!userToken){
  return <Navigate to="/"/>
}
  const handleLogout = () => {
    logout();
  };
  return (<>
<Header/>
      <main className="container__fluid">
      <section className="section pageNotFound">
        <div>
          <h1>vérifier vos identifiants d'accessibilité</h1>

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

export default NoAccess