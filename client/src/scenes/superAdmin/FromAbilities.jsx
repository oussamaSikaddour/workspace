import React, { useEffect, useState } from 'react'
import Toast from '../../components/Toast';
import Errors from '../../components/Errors';
import { handleRequest } from '../../util/util';
import axiosClient from '../../axios';
import Loading from '../../components/Loading';
import { useLogout, useStateContext } from '../../contexts/ContextProvider';

const FormAbilities = ({setRenderAdministrators, adminId})  => {
  const { currentUser} = useStateContext();
  const logout = useLogout();
  const[loading, setLoading]=useState(false);
  const [errors, setErrors]= useState({
    isErrorsOpen : false,
    content:null, 
  })
  const [toast ,setToast] = useState({
    isToastOpen:false,
    content:""
  })

  const [inputs, setInputs] = useState({
 userId:adminId,
 abilities:[]
  });

  const setAdmin = () => {
    return ({user}) => {
      const { abilities} = user;
      setInputs(prev => ({
        ...prev,
       abilities,
      }));
    }
  }

  const handleSubmit = (e) => {
    e.preventDefault();
      const toastMessage = adminId === currentUser.id 
      ?"vous avez mis à jour vos droits d'accès vous devez vous reconnecter, vous serez bientôt déconnecté"
      :"administrateur  ajouté avec succès"

      handleRequest(
        () => axiosClient.post(`/manageRoles`, inputs),
        setLoading,
        (data)=>{
          if (adminId === currentUser.id){
            setTimeout(() => {
            logout()
            }, 3000);
          }
        },
        setErrors,
        setToast,
        toastMessage
        )
    setRenderAdministrators();

  }

  useEffect(()=>{
    if(adminId){
      handleRequest(
        () => axiosClient
      .get(`/users/${adminId}`),
        setLoading,
        setAdmin(),
        setErrors
        )

    }
  },[])

  const handleCheckedAbilities = (e) => {
    const checkedAbility = e.currentTarget.value;
    setInputs((prev) => ({
      ...prev,
      abilities: prev.abilities.includes(checkedAbility)
        ? prev.abilities.filter((ability) => ability !== checkedAbility)
        : [...prev.abilities, checkedAbility],
    }));
  };
  return (
<>
<div className="form__container">
            <form className="form etablissement__form" onSubmit={handleSubmit} method="POST">
<div >
  <input
 type="checkbox"
    id="choice1"
    name="abilities"
    value="admin"
    onChange={handleCheckedAbilities}
    checked={inputs.abilities.includes('admin')}
  />
  <label htmlFor="choice1">administrateur</label>
  <input
  type="checkbox"
    id="choice2"
    name="abilities"
    value="superAdmin"
    onChange={handleCheckedAbilities}
    checked={inputs.abilities.includes('superAdmin')}
  />
  <label htmlFor="choice2">Super administrateur</label>
  <input
  type="checkbox"
    id="choice3"
    name="abilities"
    value="approver"
    onChange={handleCheckedAbilities}
    checked={inputs.abilities.includes('approver')}
  />
  <label htmlFor="choice3">Approbateur</label>
</div>

              <div className='form__actions'>
            { loading ? <div><Loading/></div>:
             <button className="button button--primary" type="submit">
              Valider
             </button>}
            </div>
            </form>
          </div>

          <Toast isOpened={toast.isToastOpen} 
          onClose={()=>setToast(prevState => ({
                  ...prevState,
                  isToastOpen: false
                                     }))}>
     {toast.content}

  </Toast>
<Errors  isOpened={errors.isErrorsOpen} 
  onClose={()=>setErrors(prevState => ({
                  ...prevState,
                  isErrorsOpen: false
                                     }))}>
     {errors.content}
  </Errors>
</>
  )
}


export default FormAbilities