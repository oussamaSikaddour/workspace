import React, { useEffect, useState } from 'react';
import { Navigate, Outlet, useLocation } from 'react-router-dom';
import axiosClient from '../axios';
import Header from '../components/Header';
import { useStateContext } from '../contexts/ContextProvider';

const RootLayout = () => {

  return (
    <>

      <Outlet />
    </>
  );
};

export default RootLayout;
