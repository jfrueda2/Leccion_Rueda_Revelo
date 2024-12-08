<?php
// Configuración del servicio SOAP
$wsdl = "http://localhost:53223/ProductsService.asmx?WSDL";

// Crear un cliente SOAP
$client = new SoapClient($wsdl, ['trace' => 1]);

function agregarProducto($productName, $categoryId, $unitPrice, $unitsInStock) {
    global $client;
    try {
        $params = [
            'productName' => $productName,
            'categoryId' => $categoryId,
            'unitPrice' => $unitPrice,
            'unitsInStock' => $unitsInStock
        ];
        $response = $client->AgregarProducto($params);
        return $response->AgregarProductoResult;
    } catch (SoapFault $e) {
        return "Error al agregar producto: " . $e->getMessage();
    }
}

function obtenerProductos() {
    global $client;
    try {
        $response = $client->ObtenerProductos();
        $result = $response->ObtenerProductosResult;
        // Manejar array de productos
        if (isset($result->ProductoDTO)) {
            $productos = $result->ProductoDTO;
            return is_array($productos) ? $productos : [$productos];
        }
        return [];
    } catch (SoapFault $e) {
        return "Error al obtener productos: " . $e->getMessage();
    }
}

function actualizarProducto($productId, $productName, $categoryId, $unitPrice, $unitsInStock) {
    global $client;
    try {
        $params = [
            'productId' => $productId,
            'productName' => $productName,
            'categoryId' => $categoryId,
            'unitPrice' => $unitPrice,
            'unitsInStock' => $unitsInStock
        ];
        $response = $client->ActualizarProducto($params);
        return $response->ActualizarProductoResult;
    } catch (SoapFault $e) {
        return "Error al actualizar producto: " . $e->getMessage();
    }
}

function eliminarProducto($productId) {
    global $client;
    try {
        $params = ['productId' => $productId];
        $response = $client->EliminarProducto($params);
        return $response->EliminarProductoResult;
    } catch (SoapFault $e) {
        return "Error al eliminar producto: " . $e->getMessage();
    }
}
?>
