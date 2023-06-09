import React, { useEffect, useState } from 'react';
import axiosClient from '../../axios';
import { handleRequest } from '../../util/util';
import Errors from '../../components/Errors';
import Loading from '../../components/Loading';
import { Link, useNavigate } from 'react-router-dom';

const Products = () => {
  const [products, setProducts] = useState([]);
  const [loading, setLoading] = useState(false);
  const [errors, setErrors] = useState({
    isErrorsOpen: false,
    content: null,
  });

  useEffect(() => {
    handleRequest(
      () => axiosClient.get("/productsForUser"),
      setLoading,
      ({ products }) => {
        setProducts(products);
      },
      setErrors
    );
  }, []);

  const navigate = useNavigate();

  console.log(products);

  return (
    <>
      <div className="section maxWidth">
        <div className="section__header">
          <h1>Nos Produits</h1>
        </div>
        <div className="section__body">
          <div>
            {loading && <div><Loading/></div>}
            {products?.length > 0 && products.map((product, index) => (
              <div className="product" key={index}>
                <img src={product.images[0]?.url} alt={product.images[0].name} />
                <div>
                  <h2>{product.name}</h2>
                  <p>{product.description}</p>
                  <div>
                    <button
                      className="button rounded"
                      onClick={() => navigate(`/products/${product.id}`, { state: { product } })}
                    >
                      <i className="fa-solid fa-eye"></i>
                    </button>
                    <h3>{product.price} Da</h3>
                  </div>
                </div>
              </div>
            ))}
          </div>
        </div>
      </div>
      <Errors
        isOpened={errors.isErrorsOpen}
        onClose={() => setErrors(prevState => ({
          ...prevState,
          isErrorsOpen: false
        }))}
      >
        {errors.content}
      </Errors>
    </>
  );
}

export default Products;
