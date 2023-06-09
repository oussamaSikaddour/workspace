import { createContext, useContext, useEffect, useState } from "react";
import axiosClient from "../axios";
const StateContext = createContext({
  currentUser:null,
  userToken:null,
  abilities:[],
  generalSetting:false,
  notifications:[],
  setCurrentUser:()=>{},
  setUserToken:()=>{},
  setAbilities:()=>{},
  setNotifications:()=>{}
})

export const ContextProvider = ({ children }) => {
  const [currentUser, setCurrentUser] = useState(
    JSON.parse(localStorage.getItem("currentUser")) || null
  );
  const [userToken, setUserToken] = useState(
    localStorage.getItem("TOKEN") || ""
  );
  const [abilities, setAbilities] = useState(
    JSON.parse(localStorage.getItem("abilities")) || []
  );
  const [generalSetting, setGeneralSetting]=useState(false)
  const [notifications ,setNotifications] = useState([])
  const [notificationUpdated, setNotificationUpdated] = useState(false);


  const setRenderNotifications = () => {
    setNotificationUpdated(prevState => !prevState);
  };


  const logout = () => {
    localStorage.removeItem("TOKEN");
    localStorage.removeItem("currentUser");
    localStorage.removeItem("abilities");
    setCurrentUser(null);
    setUserToken("");
    setAbilities([]);
  };
  useEffect(() => {
    localStorage.setItem("currentUser", JSON.stringify(currentUser));
    localStorage.setItem("abilities", JSON.stringify(abilities));
    axiosClient.get('/gSettings/1')
    .then((data) => {
      if(data.data.generalSettings.maintenance === 0){
        setGeneralSetting(false)
       }else{
        setGeneralSetting(true)
       }
    })
    .catch((error) => {
      console.log(error)
    });
  }, [currentUser, abilities ,generalSetting]);

  useEffect(() => {
    if(currentUser){
    axiosClient.get('/notifications')
    .then((data) => {
      setNotifications(data.data.notifications)
    })
    .catch((error) => {
      console.log(error)
    });
  }
  }, [currentUser,notificationUpdated]);


  const _setUserToken = (token) => {
    if (token) {
      localStorage.setItem("TOKEN", token);
    } else {
      localStorage.removeItem("TOKEN");
    }
    setUserToken(token);
  };


  const updateAbilities = (newAbilities) => {
    setAbilities(newAbilities);
  };
  return (
    <StateContext.Provider
      value={{
        currentUser,
        setCurrentUser,
        userToken,
        setUserToken: _setUserToken,
        setAbilities,
        abilities,
        updateAbilities,
        logout,
        generalSetting, 
        notifications,
        setRenderNotifications,
      }}
    >
      {children}
    </StateContext.Provider>
  );
};


export const useStateContext = ()=>useContext(StateContext)
export const useLogout = () => useStateContext().logout;