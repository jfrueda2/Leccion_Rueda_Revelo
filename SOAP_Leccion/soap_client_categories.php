<?php
// Configuración del servicio SOAP para categorías
$wsdl = "http://localhost:53223/CategoriesService.asmx?WSDL";

// Crear un cliente SOAP
$client = new SoapClient($wsdl, ['trace' => 1]);

function agregarCategoria($categoryName, $description) {
    global $client;
    try {
        $params = [
            'categoryName' => $categoryName,
            'description' => $description
        ];
        $response = $client->AgregarCategoria($params);
        return $response->AgregarCategoriaResult;
    } catch (SoapFault $e) {
        return "Error al agregar categoría: " . $e->getMessage();
    }
}

function obtenerCategorias() {
    global $client;
    try {
        $response = $client->ObtenerCategorias();
        $result = $response->ObtenerCategoriasResult;
        // Manejar array de categorías
        if (isset($result->CategoriaDTO)) {
            $categorias = $result->CategoriaDTO;
            return is_array($categorias) ? $categorias : [$categorias];
        }
        return [];
    } catch (SoapFault $e) {
        return "Error al obtener categorías: " . $e->getMessage();
    }
}

function actualizarCategoria($categoryId, $categoryName, $description) {
    global $client;
    try {
        $params = [
            'categoryId' => $categoryId,
            'categoryName' => $categoryName,
            'description' => $description
        ];
        $response = $client->ActualizarCategoria($params);
        return $response->ActualizarCategoriaResult;
    } catch (SoapFault $e) {
        return "Error al actualizar categoría: " . $e->getMessage();
    }
}

function eliminarCategoria($categoryId) {
    global $client;
    try {
        $params = ['categoryId' => $categoryId];
        $response = $client->EliminarCategoria($params);
        return $response->EliminarCategoriaResult;
    } catch (SoapFault $e) {
        return "Error al eliminar categoría: " . $e->getMessage();
    }
}
?>
