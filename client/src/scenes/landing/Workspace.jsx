import React, { useRef } from 'react'
import { useStateContext } from '../../contexts/ContextProvider';
import { useNavigate } from 'react-router-dom';
import Register from '../Register/Register';
import Login from '../Login';


const Workspace = () => {
  const { currentUser, userToken } = useStateContext();
  
  const navigate = useNavigate();

  const registerRef = useRef(null);
  const loginRef = useRef(null);

  const extendForm = (ref) => {
    const form = ref.current?.classList;
    form?.toggle("open");
  };
  return (
<>
          <div className="section maxWidth">
            <div className="section__header">
              <h1>WorkSpace</h1>
            </div>
            <div className="section__body">
              <div>
                <p>
                  si vous êtes un nouveau client cliquez sur le nouveau nouveau
                  client sinon utilisez click ancien client
                </p>
              </div>
              <div>
                <div className="booking" ref={registerRef}>
                  <button className="button button--primary booking__button" onClick={() => extendForm(registerRef)}>
                    Nouveau Client
                  </button>
                  <div className="form__container">
                  <Register extendForm={extendForm} registerRef={registerRef} />
                  </div>
                </div>
                <div className="booking ancien" ref={loginRef}>
                  <button
                    className="button booking__button--ancien booking__button"
                    onClick={() => extendForm(loginRef)}
                  >
                  client
                  </button>
                  <div className="form__container">
                  <Login extendForm={extendForm} loginRef={loginRef} />
                  </div>
                </div>
              </div>
            </div>
        </div>

</>
  )
}

export default Workspace