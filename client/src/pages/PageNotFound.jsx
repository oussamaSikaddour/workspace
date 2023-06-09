import React from 'react'
import Footer from '../components/Footer'
import Header from '../components/Header'

const PageNotFound = () => {
  return (
    <>
  <Header/>
    <main className="container__fluid">
    <section className="section pageNotFound">
      <h1>cette page n'est pas disponible | 404</h1>
    </section>
  </main>
  <Footer/>
  </>
  )
}

export default PageNotFound