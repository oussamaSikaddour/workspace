import React, { useEffect, useState } from 'react';
import { useLocation } from 'react-router-dom';
import Header from '../components/Header';
import Footer from '../components/Footer';
import ImageZoom from '../scenes/ImageZoom';

const ProductForUser = () => {

  const location = useLocation();
  const [activeImage,setActiveImage]= useState(null);
  const [activeImageIndex,setActiveImageIndex]= useState(null);

const [product,setProduct] =useState({})
  useEffect(()=>{
  const{product}= location.state
  setProduct(product)
  if(product.images.length > 0){
    setActiveImage(product.images[0])
    setActiveImageIndex(0)
  }
  },[location.state])


  const handleImageClick = (index ,image) => {
    setActiveImage(image);
    setActiveImageIndex(index)
  };

  return (
    <>
      <Header />
      <main className="container__fluid">
        <section className="section">

         <div className="items__container">
   
          <div className="item__images">
          { 
          activeImage &&
            <ImageZoom  img={activeImage}/>}
          <div>
            {
              product.images?.length > 0 &&   product.images.map((image,index)=>
            <div 
            className={`img${activeImageIndex === index ?" active":" "}`}
            key={index}
            onClick={() => handleImageClick(index ,image)}
            >
           <img src={image.url} alt={image.name} />
           <div className="overlay">
           <i className="fa-solid fa-check"></i>
           </div>
           </div> )}
      
         </div>
         </div>
          
         <div className="item">
          <div className="item__header">
            <h3>{product.name}</h3>
          </div>
          <div className="item__body">
            <p>{product.description}</p>
            <h3>{product.price} Da </h3>
          </div>
         </div>

         </div>

        </section>
      </main>
      <Footer />
    </>
  );
};

export default ProductForUser;
