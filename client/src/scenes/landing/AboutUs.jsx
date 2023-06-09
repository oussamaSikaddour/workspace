import React from 'react'

const AboutUs = () => {
  return (
 <>
    
          <div className="section maxWidth">
            <div className="section__header">
              <h1>Qui somme nous</h1>
            </div>
            <div className="section__body">
              <div>
                <div>
                  <h2>Plus qu'un intégrateur</h2>
                  <p>
                    Fondée par des ingénieurs expérimentés et certifiés dans le
                    domaine, HDConsulting est aujourd’hui l’une des sociétés
                    leader dans le domaine d’intégration des solutions
                    informatiques, spécialement ceux basées sur les technologies
                    Open Source.
                  </p>
                </div>

                <img src="img/aboutUs.jpg" alt="" />
              </div>
              <div>
                <ul>
                  <li>
                    <span><i className="fa-solid fa-bolt-lightning"></i></span>
                    Service de qualité
                  </li>
                  <li>
                    <span><i className="fa-solid fa-expand"></i></span>Solution
                    innovantes
                  </li>
                  <li>
                    <span><i className="fa-solid fa-expand"></i></span>Consultations
                  </li>
                  <li>
                    <span><i className="fa-solid fa-code-branch"></i></span>Stratégies Multiples
                  </li>
                  <li>
                    <span><i className="fa-solid fa-expand"></i></span>Equipe
                    expérimentés
                  </li>
                </ul>
              </div>
            </div>
          </div>
     
 </>
  )
}

export default AboutUs