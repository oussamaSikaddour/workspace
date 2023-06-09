import { useEffect, useState, useRef } from "react";
import axiosClient from "../../axios";
import { daysOfWeek, handleRequest } from "../../util/util";
import Errors from "../Errors";
import Loading from "../Loading";

const WorkSpaces = ({ handleChange, inputs ,setWorkSpaceId, workSpaceId}) => {
  const [loading, setLoading] = useState(false);
  const [loadingPlans, setLoadingPlans] = useState(false);
  const [workspaces, setWorkspaces] = useState([]);
  const [errors, setErrors] = useState({
    isErrorsOpen: false,
    content: null,
  });

  const workspaceRef = useRef([]);

  useEffect(() => {
    handleRequest(
      () => axiosClient.get('/workspaces?includeAll=true'),
      setLoading,
      ({ workSpaces }) => {
        setWorkspaces(workSpaces);
      },
      setErrors
    );
  }, []);

  const handelCarousel = (index) => {
    workspaceRef.current.forEach((ref, i) => {
      if (i !== index) {
        ref.classList.remove("open");
      }
    });
    const currentRef = workspaceRef.current[index];
    currentRef.classList.toggle("open");
  };
  
  return (
    <>
      <div>
        <p>Vous devez sélectionner les espaces de travail :</p>
        {loading && <Loading />}
        {!loading && (
          <div className="workspaces">
            {workspaces?.map((workspace, index) => (
              <div
                ref={(ref) => (workspaceRef.current[index] = ref)}
                key={index}
              >
                <div
                  className={`workspace__header ${parseInt(workSpaceId) === workspace.id ? "active" : ""}`}
                  onClick={(e) => {
                    e.preventDefault();
                    handelCarousel(index, workspace.id);
                  }}
                >
                  <p>{workspace.name}</p>
                  <p>prix par heure pour une personne: {workspace.pricePerHour} DA</p>
                  <i className="fa-solid fa-plus"></i>
                </div>
                <div className="workspace__body">
                  {workspace.openingHours?.length > 0 && 
                    workspace.openingHours.map((openingHour, index) => (
                      <div class="openingHour" key={index}>
                        <p>{daysOfWeek[openingHour.dayOfWeek]}</p>
                        <p>heure d'ouverture : {openingHour.openTime}</p>
                        <p>heure de fermeture: {openingHour.closeTime}</p>
                      </div>
                    ))
                    }
                  {workspace.openingHours?.length > 0 && workspace.plans?.length > 0 ? (
                    workspace.plans.map((plan, index) => (
                      <div key={index}>
                        <div>
                          <p>planning numéro : {index + 1}</p>
                          <p>nombre des places restantes : {plan.capacity}</p>
                        </div>
                        <div>
                          <p>début de la période : {plan.startDate}</p>
                          <p>fin de la période : {plan.endDate}</p>
                          <input
                            type="radio"
                            id={`choice${plan.id}`}
                            name="planId"
                            value={plan.id}
                            checked={parseInt(inputs.planId) === plan.id}
                            onChange={(e) => {
                              setWorkSpaceId(workspace.id);
                              handleChange(e);
                            }}
                          />
                          <label htmlFor={`choice${plan.id}`}></label>
                        </div>
                      </div>
                    ))
                  ) : (
                    <div class="workspace__error">
                    {workspace.openingHours?.length === 0 && workspace.plans?.length > 0 ? (
                      <p>Ce lieu de travail n'a pas encore d'horaires d'ouverture.</p>
                    ) : (
                      <p>Ce lieu de travail n'a pas encore de plannings.</p>
                    )}
                  </div>
                  
             
                  )}
                </div>
              </div>
            ))}
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
      </div>
    </>
  );
  
};

export default WorkSpaces;

