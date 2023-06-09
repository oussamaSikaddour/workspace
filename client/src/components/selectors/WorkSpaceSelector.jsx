import React, { useEffect, useState } from 'react';
import Errors from '../Errors';
import Loading from '../Loading';
import { handleRequest } from '../../util/util';
import axiosClient from '../../axios';

const WorkSpaceSelector = ({ handleChange, inputs }) => {
  const [loading, setLoading] = useState(false);
  const [workspaces, setWorkspaces] = useState([]);
  const [errors, setErrors] = useState({
    isErrorsOpen: false,
    content: null,
  });

  useEffect(() => {
    handleRequest(
      () => axiosClient.get('/workspaces'),
      setLoading,
      ({ workSpaces }) => {
        setWorkspaces(workSpaces);
      },
      setErrors
    );
  }, []);

  return (
    <>
      {loading && <div><Loading/></div>}
      {!loading && (
        <div className="select__group">
          <select name="workSpaceId" value={inputs.workSpaceId || ''} onChange={handleChange}>
            <option value="">--- Choisir un Espace de Travail ---</option>
            {workspaces?.map((workspace) => (
              <option key={workspace.id} value={workspace.id}>{workspace.name}</option>
            ))}
          </select>
        </div>
      )}
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

export default WorkSpaceSelector;
