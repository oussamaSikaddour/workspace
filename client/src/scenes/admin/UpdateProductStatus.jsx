import React, { useState, useEffect } from 'react';
import Toast from '../../components/Toast';
import Errors from '../../components/Errors';
import { handleChange, handleRequest } from '../../util/util';
import axiosClient from '../../axios';
import StatusSelector from '../../components/selectors/StatusSelector';

const UpdateProductStatus = ({ productId, statusToUpdate, setActiveProductsCounter,activeProductsCounter }) => {
  const [loading, setLoading] = useState(false);
  const [fetch, setFetch] = useState(false);
  const [errors, setErrors] = useState({
    isErrorsOpen: false,
    content: null,
  });
  const [toast, setToast] = useState({
    isToastOpen: false,
    content: '',
  });

  const [inputs, setInputs] = useState({ status: statusToUpdate });
  const [previousStatus, setPreviousStatus] = useState(statusToUpdate); // Store the previous status

  const setProduct = ({ product }) => {
    const { status } = product;
    setInputs(prev => ({
      ...prev,
      status,
    }));
    setFetch(prev => !prev);
  };

  useEffect(() => {
    if (fetch) {
      if (previousStatus === 'inactive' && inputs.status === 'active') {
        setActiveProductsCounter(prev => prev + 1);
      } else if (previousStatus === 'active' && inputs.status === 'inactive') {
        setActiveProductsCounter(prev => prev - 1);
      }
      handleRequest(
        () => axiosClient.patch(`/products/${productId}`, { status: inputs.status }),
        setLoading,
        setProduct,
        setErrors,
        setToast,
        'produit modifié avec succès'
      );
     
    }
  }, [fetch]);

  return (
    <>
      <StatusSelector
        inputs={inputs}
        handleChange={(e) => {
          handleChange(e, setInputs);
          setPreviousStatus(inputs.status); // Update the previous status before making the change
          setFetch(true);
        }}
      />

      <Toast
        isOpened={toast.isToastOpen}
        onClose={() =>
          setToast((prevState) => ({
            ...prevState,
            isToastOpen: false,
          }))
        }
      >
        {toast.content}
      </Toast>

      <Errors
        isOpened={errors.isErrorsOpen}
        onClose={() =>
          setErrors((prevState) => ({
            ...prevState,
            isErrorsOpen: false,
          }))
        }
      >
        {errors.content}
      </Errors>
    </>
  );
};

export default UpdateProductStatus;
