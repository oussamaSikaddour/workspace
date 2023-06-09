import React, { useState } from 'react'
import ReactDOM from 'react-dom/client'
import { RouterProvider } from 'react-router-dom';
import { ContextProvider } from './contexts/ContextProvider';
import './index.css';
import Router from './router';

function Root() {
  return (
    <ContextProvider>
      <RouterProvider router= {Router} />
    </ContextProvider>
  );
}

ReactDOM.createRoot(document.getElementById('root')).render(
  <Root />,
);
