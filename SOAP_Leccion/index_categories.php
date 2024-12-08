<?php
include 'soap_client_categories.php';

$message = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'];

    switch ($action) {
        case 'add':
            $name = $_POST['name'];
            $description = $_POST['description'];
            $message = agregarCategoria($name, $description);
            break;

        case 'list':
            $categorias = obtenerCategorias();
            break;

        case 'update':
            $id = $_POST['id'];
            $name = $_POST['name'];
            $description = $_POST['description'];
            $message = actualizarCategoria($id, $name, $description);
            break;

        case 'delete':
            $id = $_POST['id'];
            $message = eliminarCategoria($id);
            break;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Categorías</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: Arial, sans-serif;
        }
        .container {
            margin-top: 30px;
        }
        .card {
            margin-bottom: 20px;
            border: none;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .table th, .table td {
            vertical-align: middle;
        }
        .btn-custom {
            background-color: #007bff;
            color: white;
        }
        .btn-custom:hover {
            background-color: #0056b3;
            color: white;
        }
        .message {
            margin-bottom: 20px;
            padding: 10px;
            border: 1px solid #d1ecf1;
            background-color: #d1ecf1;
            color: #0c5460;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="text-center text-primary">Gestión de Categorías</h1>
        <?php if ($message): ?>
            <div class="message">
                <?= htmlspecialchars($message) ?>
            </div>
        <?php endif; ?>
        
        <!-- Agregar Categoría -->
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Agregar Categoría</h5>
                <form method="post" class="row g-3">
                    <input type="hidden" name="action" value="add">
                    <div class="col-md-6">
                        <label for="name" class="form-label">Nombre</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="col-md-6">
                        <label for="description" class="form-label">Descripción</label>
                        <input type="text" class="form-control" id="description" name="description" required>
                    </div>
                    <div class="col-12">
                        <button type="submit" class="btn btn-custom">Agregar</button>
                    </div>
                </form>
            </div>
        </div>
        
        <!-- Listar Categorías -->
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Lista de Categorías</h5>
                <form method="post">
                    <input type="hidden" name="action" value="list">
                    <button type="submit" class="btn btn-custom">Listar Categorías</button>
                </form>
                <?php if (isset($categorias) && is_array($categorias)): ?>
                    <table class="table table-striped mt-3">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nombre</th>
                                <th>Descripción</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($categorias as $categoria): ?>
                                <tr>
                                    <td><?= htmlspecialchars($categoria->CategoryID) ?></td>
                                    <td><?= htmlspecialchars($categoria->CategoryName) ?></td>
                                    <td><?= htmlspecialchars($categoria->Description) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php endif; ?>
            </div>
        </div>
        
        <!-- Actualizar Categoría -->
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Actualizar Categoría</h5>
                <form method="post" class="row g-3">
                    <input type="hidden" name="action" value="update">
                    <div class="col-md-2">
                        <label for="id" class="form-label">ID</label>
                        <input type="number" class="form-control" id="id" name="id" required>
                    </div>
                    <div class="col-md-5">
                        <label for="name" class="form-label">Nombre</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="col-md-5">
                        <label for="description" class="form-label">Descripción</label>
                        <input type="text" class="form-control" id="description" name="description" required>
                    </div>
                    <div class="col-12">
                        <button type="submit" class="btn btn-custom">Actualizar</button>
                    </div>
                </form>
            </div>
        </div>
        
        <!-- Eliminar Categoría -->
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Eliminar Categoría</h5>
                <form method="post" class="row g-3">
                    <input type="hidden" name="action" value="delete">
                    <div class="col-md-3">
                        <label for="id" class="form-label">ID</label>
                        <input type="number" class="form-control" id="id" name="id" required>
                    </div>
                    <div class="col-12">
                        <button type="submit" class="btn btn-danger">Eliminar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
