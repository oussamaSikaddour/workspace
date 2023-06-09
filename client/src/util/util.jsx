import { cloneElement } from "react";
import { NavLink } from "react-router-dom";

export const months = [
  "Janvier",
  "Février",
  "Mars",
  "Avril",
  "Mai",
  "Juin",
  "Juillet",
  "Août",
  "Septembre",
  "Octobre",
  "Novembre",
  "Décembre"
];

export const daysOfWeek = ['Samedi','Dimanche', 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi'];

export const types = ["admin","superAdmin", "guest"];

export const navigation = (abilities, navigate) => {
  for (let i = 0; i < abilities.length; i++) {
    const ability = abilities[i];
    if (types.includes(ability)) {
      navigate(`/${ability}`);
      return;
    }
  }
  navigate('/NoAccess');
};





export const setNavLink = (abilities) => {
  const links = {
    admin: (
      <>
      <li className="nav__link">
        <NavLink to="/admin" end>
          Accueil
        </NavLink>
      </li>
      <li className="nav__link">
        <NavLink to="/admin/products">
          Produits
        </NavLink>
      </li>
      <li className="nav__link">
        <NavLink to="/admin/guestMessages">
        Messages des visiteurs
        </NavLink>
      </li>
      </>
    ),
    superAdmin: (
      <>
        <li className="nav__link">
          <NavLink to="/superAdmin" end>
            Gestion des utilisateurs
          </NavLink>
        </li>
        <li className="nav__link">
          <NavLink to="/superAdmin/generalSettings" end>
          paramètres globaux
          </NavLink>
        </li>
      </>
    ),
    guest: (
      <>
        <li className="nav__link">
          <NavLink to="/guest" end>
            Accueil
          </NavLink>
        </li>
      </>
    ),
  };

  const navLinks = abilities?.map((ability, index) => {
    if (links.hasOwnProperty(ability)) {
      return cloneElement(links[ability], { key: `${ability}-${index}` });
    }
  });

  if (navLinks.every((link) => link === undefined)) {
    return (
      <li className="nav__link">
        <NavLink to="/NoAccess" end>
          No Access
        </NavLink>
      </li>
    );
  }

  return navLinks;
};




export const  handleRequest = async(apiFunction, setLoading, handelData, setErrors,setToast=null,setToastMessage=null, changeOnError=null ) =>{
  setLoading(true);
  setErrors(prevState => ({
    ...prevState,
    isErrorsOpen: false,
    content:  null
                       }))
if(setToast){
 setToast(prevState => ({
                        ...prevState,
                        isToastOpen: false,
                        content:null
                        }))
    }
  try {
    const response = await apiFunction();
    handelData(response.data);
    setLoading(false);
    if(setToast){
      setToast(prevState => ({
        ...prevState,
        isToastOpen: true,
        content:setToastMessage
        }))
  }
  } catch (error) {
    if(changeOnError){
   changeOnError();
    }
    setLoading(false);
    if (error.response?.data?.errors) {
      const finalErrors = Object.values(error.response.data.errors).map((error, index)=>{
       return <li key={index} className="error">
   {error}
  </li>
      })
      setErrors(prevState => ({
        ...prevState,
        isErrorsOpen: true,
        content:  finalErrors
                           }))
    }else if(error.response?.data?.error) {
       setErrors(prevState => ({
        ...prevState,
        isErrorsOpen: true,
        content: <li className='error'> {error.response.data.error}</li> 
                           }))
    }

  }
}


export const handleChange = (e, setInputs) => {
  const { name, value } = e.target;
  if (name.includes(".")) {
    const [category, subCategory] = name.split('.');
    setInputs(prevState => ({
      ...prevState,
      [category]:{
        ...prevState[category],
        [subCategory]: value
      }
    }));
  } else {
    setInputs(prevState => ({ ...prevState, [name]: value }));
  }
}



export const minDateRequired = (date) => {
  const minDate = new Date(date);
  return minDate.toISOString().substring(0, 10); // return the ISO-formatted date string
}

export const getdateFormat =(date)=>{
  return new Date(date).toLocaleDateString('fr-FR', {
    year: 'numeric',
    month: 'short',
    day: 'numeric',
    hour: 'numeric',
    minute: 'numeric',
  })
}

// how to use it const minDate = useState(minDateRequired(new Date('2023-05-01')))[0];

// [0] is useState return  minDate and setMindATE   [0] retrun th first elment 

