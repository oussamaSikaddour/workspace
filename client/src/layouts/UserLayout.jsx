

import React, { useEffect } from 'react'
import {Outlet, useNavigate } from 'react-router-dom'
import Footer from '../components/Footer'
import { useStateContext } from '../contexts/ContextProvider';
import Messages from '../components/messages/Messages';
import Header from '../components/Header';

const UserLayout = () => {
  const { currentUser, abilities ,generalSetting} = useStateContext();
  const navigate = useNavigate();
  useEffect(() => {
    if (currentUser) {
          if (abilities.includes("guest") === false) {
            navigate("/NoAccess");}
    }
      else{
        navigate("/");
      }
      }, [currentUser, generalSetting]);

  return (
    <>
        <Header />
         <Messages />
         <main className="container__fluid">
        <Outlet />
      </main>
      <Footer />
    </>
  );
};

export default UserLayout;

