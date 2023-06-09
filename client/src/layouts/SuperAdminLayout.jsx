

import React, { useEffect } from 'react'
import {Outlet, useNavigate } from 'react-router-dom'
import Footer from '../components/Footer'
import { useStateContext } from '../contexts/ContextProvider';
import Header from '../components/Header';

const SuperAdminLayout = () => {
  const { currentUser, abilities ,generalSetting} = useStateContext();
  const navigate = useNavigate();

  useEffect(() => {
    if(generalSetting){
      navigate("/superAdmin/generalSettings")
     }
    if (currentUser) {
          if (abilities.includes("superAdmin") === false) {
            navigate("/NoAccess");}
    }
      else{
        navigate("/");
      }
      }, [currentUser]);

  return (
    <>
        <Header />
     <main className="container__fluid">
        <Outlet />
      </main>
      <Footer />
    </>
  );
};

export default SuperAdminLayout;

