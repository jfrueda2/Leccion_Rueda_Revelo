using System;
using System.Collections.Generic;
using System.Web.Services;
using BLL;  // Asegúrate de agregar el namespace BLL
using Entities;

namespace Leccion_SOAP
{
    /// <summary>
    /// Servicio SOAP para la gestión de categorías
    /// </summary>
    [WebService(Namespace = "http://tempuri.org/")]
    [WebServiceBinding(ConformsTo = WsiProfiles.BasicProfile1_1)]
    [System.ComponentModel.ToolboxItem(false)]
    public class CategoriesService : WebService
    {
        private CategoriesLogic _categoriesLogic = new CategoriesLogic(); // Instancia de la lógica de categorías

        #region Métodos de Categorías

        // Método para agregar una categoría utilizando la lógica de negocio
        [WebMethod]
        public string AgregarCategoria(string categoryName, string description)
        {
            try
            {
                Categories category = new Categories
                {
                    CategoryName = categoryName,
                    Description = description
                };

                // Llamar a la lógica de negocio para crear la categoría
                _categoriesLogic.Create(category);

                return "Categoría agregada correctamente.";
            }
            catch (Exception ex)
            {
                return $"Error al agregar la categoría: {ex.Message}";
            }
        }

        // Método para obtener todas las categorías utilizando la lógica de negocio
        [WebMethod]
        public List<CategoriesLogic.CategoriaDTO> ObtenerCategorias()
        {
            try
            {
                return _categoriesLogic.RetrieveAll();
            }
            catch (Exception ex)
            {
                throw new Exception($"Error al obtener las categorías: {ex.Message}");
            }
        }

        // Método para actualizar una categoría utilizando la lógica de negocio
        [WebMethod]
        public string ActualizarCategoria(int categoryId, string categoryName, string description)
        {
            try
            {
                Categories category = new Categories
                {
                    CategoryID = categoryId,
                    CategoryName = categoryName,
                    Description = description
                };

                // Llamar a la lógica de negocio para actualizar la categoría
                bool result = _categoriesLogic.Update(category);
                return result ? "Categoría actualizada correctamente." : "Categoría no encontrada.";
            }
            catch (Exception ex)
            {
                return $"Error al actualizar la categoría: {ex.Message}";
            }
        }

        // Método para eliminar una categoría utilizando la lógica de negocio
        [WebMethod]
        public string EliminarCategoria(int categoryId)
        {
            try
            {
                bool result = _categoriesLogic.Delete(categoryId);
                return result ? "Categoría eliminada correctamente." : "Categoría no encontrada o no se pudo eliminar.";
            }
            catch (Exception ex)
            {
                return $"Error al eliminar la categoría: {ex.Message}";
            }
        }

        #endregion
    }
}
