using System;
using System.Collections.Generic;
using System.Linq;
using DAL;
using Entities;

namespace BLL
{
    public class ProductsLogic
    {
        // Clase DTO para representar los productos
        public class ProductoDTO
        {
            public int ProductID { get; set; }
            public string ProductName { get; set; }
            public int CategoryID { get; set; }
            public decimal UnitPrice { get; set; }
            public int UnitsInStock { get; set; }
        }

        public Products Create(Products products)
        {
            Products _products = null;

            using (var repository = RepositoryFactory.CreateRepository())
            {
                Products _result = repository.Retrieve<Products>(p => p.ProductName == products.ProductName);

                if (_result == null)
                {
                    _products = repository.Create(products);
                }
                else
                {
                    throw new Exception("Producto ya existe");
                }
            }

            return _products; // Retorna el producto creado
        }

        public Products RetrieveById(int id)
        {
            Products _products = null;
            using (var repository = RepositoryFactory.CreateRepository())
            {
                _products = repository.Retrieve<Products>(p => p.ProductID == id);
            }
            return _products;
        }

        public bool Update(Products products)
        {
            using (var repository = RepositoryFactory.CreateRepository())
            {
                var existingProduct = repository.Retrieve<Products>(p => p.ProductID == products.ProductID);

                if (existingProduct == null)
                {
                    throw new Exception("El producto no existe.");
                }

                // Actualiza manualmente las propiedades necesarias
                existingProduct.ProductName = products.ProductName;
                existingProduct.UnitPrice = products.UnitPrice;
                existingProduct.UnitsInStock = products.UnitsInStock;
                existingProduct.CategoryID = products.CategoryID;

                return repository.Update(existingProduct);
            }
        }

        public bool Delete(int id)
        {
            bool _delete = false;
            var _product = RetrieveById(id);
            if (_product != null)
            {
                if (_product.UnitsInStock == 0)
                {
                    using (var repository = RepositoryFactory.CreateRepository())
                    {
                        _delete = repository.Delete(_product);
                    }
                }
            }
            return _delete;
        }

        public List<ProductoDTO> RetrieveAll()
        {
            using (var repository = RepositoryFactory.CreateRepository())
            {
                var products = repository.Filter<Products>(p => p.ProductID > 0)
                    .Select(p => new ProductoDTO
                    {
                        ProductID = p.ProductID,
                        ProductName = p.ProductName,
                        CategoryID = p.CategoryID,
                        UnitPrice = p.UnitPrice,
                        UnitsInStock = p.UnitsInStock
                    }).ToList();

                return products;
            }
        }
    }
}
