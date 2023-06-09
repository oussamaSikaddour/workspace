import { useCallback, useEffect, useRef, useState } from "react";
import { handleChange, handleRequest } from "../../util/util";
import axiosClient from "../../axios";
import Errors from "../../components/Errors";
import Loading from "../../components/Loading";
import StatusSelector from "../../components/selectors/StatusSelector";
import Toast from "../../components/Toast";

const FormProduct = ({setRenderProducts , productId=null}) => {
    const[loading, setLoading]=useState(false);
    const[productLoading, setProductLoading]=useState(false);
    const [errors, setErrors]= useState({
      isErrorsOpen : false,
      content:null, 
    })
    const [toast ,setToast] = useState({
      isToastOpen:false,
      content:""
    })
  
    const [inputs, setInputs] = useState({
 name:"",
 description:"",
 status:"inactive",
 price:"",
     });
     const [files, setFiles] = useState([]);
     const [images,setImages]=useState(null);
     const imageRefs = useRef([]);
    const handleImageLoad = useCallback((event, index) => {
      imageRefs.current[index].src = event.target.result;
    }, []);
    
  
    const setProduct = () => {
      return ({product}) => {
       const{name,description,price,status,images} = product
        setInputs(prev => ({
          ...prev,
          name,
          description,
          price,
          status
        }));
        const oldImages = images.map((image, index)=>{
          return <img
            key={index}
            className="img"
            src={image.url || "/carte_jaune.jpg"}
            alt="default"
          />
        });
        setImages(oldImages);
      }
    }
  
    const handleFileChange = (event) => {
      const files = event.target.files;
      setFiles(files);
      const images = Object.values(files);
      const imageElements = images.map((file, index) => {
        const reader = new FileReader();
        reader.onload = (event) => handleImageLoad(event, index);
        reader.readAsDataURL(file);
        const imgRef = imageRefs.current[index] || new Image();
        imageRefs.current[index] = imgRef;
        return (
          <img
            key={index}
            className="img"
            src={imgRef.src || "/carte_jaune.jpg"}
            alt="default"
            ref={(element) => (imageRefs.current[index] = element)}
          />
        );
      });
      setImages(imageElements);
    };
  
  
    const handleSubmit = (e) => {
      e.preventDefault();
        const formData = new FormData();
        for (let i = 0; i < files.length; i++) {
          formData.append('images[]', files[i]);
        }
      Object.keys(inputs).forEach((category) => {
        formData.append(`${category}`, inputs[category]);
    });

    if (productId) {
      formData.append("_method", "PATCH");
      handleRequest(
        () => axiosClient.post(`/products/${productId}`, formData),
        setLoading,
        setProduct(),
        setErrors,
        setToast, // Pass setToast function as an argument
        "produit modifié avec succès"
      );
    } else {
      handleRequest(
        () => axiosClient.post("/products", formData),
        setLoading,
        setProduct(),
        setErrors,
        setToast, // Pass setToast function as an argument
        "Produit ajouté avec succès"
      );
    }
    setRenderProducts();
  }
  

    useEffect(()=>{
      if(productId){
      handleRequest(
        () => axiosClient
      .get(`/products/${productId}`),
        setProductLoading,
        setProduct(),
        setErrors
      )
      }

    },[])
  
    return (
  <>
  <div className="form__container">
              <form className="form " method="POST" onSubmit={handleSubmit}>
      
              <div>
                <div className="input__group">
                  <input
                    type="text"
                    className="input"
                    placeholder="Nom"
                    name="name"
                    id="name"
                    value={inputs.name||""}
                   onChange={(e)=>{handleChange(e,setInputs)}}
                  />
                  <label htmlFor="name" className="input__label">Nom</label>
                </div>
                <div className="input__group">
                  <input
                    type="number"
                    className="input"
                    placeholder="Prix unitaire"
                    name="price"
                    id="price"
                    value={inputs.price||""}
                   onChange={(e)=>{handleChange(e,setInputs)}}
                  />
                  <label htmlFor="price" className="input__label">Prix unitaire</label>
                </div>
              </div>
            {productId && <div>
                  <StatusSelector inputs={inputs} handleChange={(e)=>{handleChange(e,setInputs)}} />
              </div>}

              <div className="textarea__group">
                <textarea
                  className="textarea"
                  id="description"
                  name="description"
                  rows="4"
                  cols="100"
                  maxLength="200"
                  placeholder="Description"
                  value={inputs.description||""}
                  onChange={(e) => {
                    handleChange(e, setInputs);
                  }}
                >
                </textarea>
                <label htmlFor="description" className="textarea__label">Description</label>
              </div>
                
                <div className="imgs__container">
                <div className="imgs">
                {productLoading && <div><Loading/></div>}
                {images && images}
                </div>
              </div>
  
       <div>
          <div className="upload__group">
              <button className="button">ajouter des images</button>
              <input type="file" accept="image/*"  name="image" capture="environment" onChange={handleFileChange} multiple/>
            </div>
       </div>
       <div className="form__actions">
          { loading ? <div><Loading/></div>:
            <button className="button button--primary" type='submit'>
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
  
  
  export default FormProduct