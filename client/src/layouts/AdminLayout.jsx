import React, { useEffect } from 'react'
import {Outlet, useNavigate } from 'react-router-dom'
import Footer from '../components/Footer'
import { useStateContext } from '../contexts/ContextProvider';
import Header from '../components/Header';

const AdminLayout = () => {
  const { currentUser, abilities , generalSetting} = useStateContext();
  const navigate = useNavigate();
  useEffect(() => {
 if(generalSetting){
  navigate("/maintenance")
 }
if (currentUser) {
      if (abilities.includes("admin") === false) {
        navigate("/NoAccess");}
}
  else{
    navigate("/");
  }
  }, [currentUser, generalSetting]);

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

export default AdminLayout;