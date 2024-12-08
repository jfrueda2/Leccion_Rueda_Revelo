using System;
using System.Collections.Generic;
using System.Web.Services;
using BLL;  // Asegúrate de agregar el namespace BLL
using Entities;

namespace Leccion_SOAP
{
    /// <summary>
    /// Servicio SOAP para la gestión de productos
    /// </summary>
    [WebService(Namespace = "http://tempuri.org/")]
    [WebServiceBinding(ConformsTo = WsiProfiles.BasicProfile1_1)]
    [System.ComponentModel.ToolboxItem(false)]
    public class ProductsService : WebService
    {
        private ProductsLogic _productsLogic = new ProductsLogic(); // Instancia de la lógica de productos

        #region Métodos de Productos

        // Método para agregar un producto utilizando la lógica de negocio
        [WebMethod]
        public string AgregarProducto(string productName, int categoryId, decimal unitPrice, int unitsInStock)
        {
            try
            {
                Products product = new Products
                {
                    ProductName = productName,
                    CategoryID = categoryId,
                    UnitPrice = unitPrice,
                    UnitsInStock = unitsInStock
                };

                _productsLogic.Create(product);

                return "Producto agregado correctamente.";
            }
            catch (Exception ex)
            {
                return $"Error al agregar el producto: {ex.Message}";
            }
        }

        // Método para obtener todos los productos utilizando la lógica de negocio
        [WebMethod]
        public List<ProductsLogic.ProductoDTO> ObtenerProductos()
        {
            try
            {
                return _productsLogic.RetrieveAll();
            }
            catch (Exception ex)
            {
                throw new Exception($"Error al obtener los productos: {ex.Message}");
            }
        }

        // Método para actualizar un producto utilizando la lógica de negocio
        [WebMethod]
        public string ActualizarProducto(int productId, string productName, int categoryId, decimal unitPrice, int unitsInStock)
        {
            try
            {
                Products product = new Products
                {
                    ProductID = productId,
                    ProductName = productName,
                    CategoryID = categoryId,
                    UnitPrice = unitPrice,
                    UnitsInStock = unitsInStock
                };

                bool result = _productsLogic.Update(product);
                return result ? "Producto actualizado correctamente." : "Producto no encontrado.";
            }
            catch (Exception ex)
            {
                return $"Error al actualizar el producto: {ex.Message}";
            }
        }

        // Método para eliminar un producto utilizando la lógica de negocio
        [WebMethod]
        public string EliminarProducto(int productId)
        {
            try
            {
                bool result = _productsLogic.Delete(productId);
                return result ? "Producto eliminado correctamente." : "Producto no encontrado o no se pudo eliminar.";
            }
            catch (Exception ex)
            {
                return $"Error al eliminar el producto: {ex.Message}";
            }
        }

        #endregion
    }
}
