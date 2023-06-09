import React, { useEffect, useState } from 'react'
import axiosClient from '../../axios';
import { handleRequest } from '../../util/util';
import FormProduct from '../../scenes/admin/FormProduct';
import Loading from '../../components/Loading';
import Modal from '../../components/Modal';
import Toast from '../../components/Toast';
import Errors from '../../components/Errors';
import Table from '../../components/table/Table';
import UpdateProductStatus from '../../scenes/admin/UpdateProductStatus';

const Products = () => {

      
        const[loading, setLoading]=useState(false);
        const [errors, setErrors]= useState({
          isErrorsOpen : false,
          content:null, 
        })
        const [toast ,setToast] = useState({
          isToastOpen:false,
          content:""
        })
      
        const [activeProductsCounter, setActiveProductsCounter]= useState(null)
        const [modal, setModal]= useState({
          isModalOpen : false,
          content:null,
          title:"", 
        })
      
        const [products ,setProducts]=useState([]);
      const productsThs=[ "nom", "prix Unitaire ","etat", "actions"]

      const [renderProducts ,setRenderProducts]=useState(false);
      const [activeProductsRow, setActiveProductsRow]= useState(null)
      
      
      useEffect(() => {
        handleRequest(
          () => axiosClient.get(`/products`),
          setLoading,
          ({ products }) => {
            setActiveProductsRow(products[0]?.id);
            const activeProductsCount = products.reduce((count, product) => {
              if (product.status === 'active') {
                return count + 1;
              }
              return count;
            }, 0);
            setActiveProductsCounter(activeProductsCount);
            const htmlData = products.map(product => ({
              ...product,
              status: <UpdateProductStatus productId={product.id} statusToUpdate={product.status} setActiveProductsCounter={setActiveProductsCounter}  activeProductsCounter={activeProductsCounter}/>,
              buttonElement: <>
                <button
                  className="button rounded"
                  onClick={() => {
                    setActiveProductsRow(product.id);
                    setModal((prevState) => ({
                      ...prevState,
                      isModalOpen: true,
                      title: "Modifier Produit",
                      content: (
                        <FormProduct
                          productId={product.id}
                          setRenderProducts={() => setRenderProducts(prevState => !prevState)}
                        />
                      ),
                    }));
                  }}
                >
                  <i className="fa-solid fa-pen-to-square"></i>
                </button>
      
                <button className="button rounded" onDoubleClick={() => { deleteProduct(product.id) }}>
                  <i className="fa-solid fa-trash"></i>
                </button>
              </>,
            }));
            setProducts(htmlData);
          },
          setErrors,
        );
      }, [renderProducts]);
      
      

        useEffect(()=>{
           if(activeProductsCounter > 4 ){
            setErrors(prevState => ({
              ...prevState,
              isErrorsOpen: true,
              content: <li className='error'>le nombre maximum de produits actifs est de 4 </li> 
                                 }))
           }
          
        },[activeProductsCounter])


      
        const  deleteProduct=(id)=>{
      
          handleRequest(
            () => axiosClient.delete(`/products/${id}`),
            setLoading,
            ( data ) => {
                  setProducts(prevState => prevState.filter(item => item.id !== id));   
                  },
            setErrors,
            setToast,
            "produit supprimer avec succès"
            )
        
        }
        return (
      <>
      
            <section className="section">
        
      
      <div> 
              <button className="button"
                       onClick={() => {
                        setModal((prevState) => ({
                          ...prevState,
                          isModalOpen: true,
                          title:"ajouter Produit",
                          content:<FormProduct
                          setRenderProducts={()=>setRenderProducts(prevState => !prevState)
                          }
                          />,
                        }));
                      }} >
          <i className="fa-solid fa-arrow-up"></i>
                Ajouter Produit
              </button>

              <div className='button button--primary'>
              nombre de produits actifs : {activeProductsCounter}
              </div>
      
            </div>
      
              <div>{loading && <Loading/>}
              {!loading && products?.length ? <Table ths={productsThs} data={products} setSortedData={setProducts} activeRow={activeProductsRow}/>:<div><h2>vous n'avez pas de produits pour le moment</h2></div> }
              </div>
            </section>
      
          <Modal 
          variant={"l"} 
          title={modal.title} isOpened={modal.isModalOpen} 
        onClose={()=>setModal(prevState => ({
                        ...prevState,
                        isModalOpen: false
                                           }))}>
      {modal.content}
        </Modal>
      
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

export default Products