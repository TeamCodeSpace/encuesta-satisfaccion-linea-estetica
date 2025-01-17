<?php
// Mostrar errores
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Configuración de la base de datos
define('DB_NAME', 'cmxdistribuidora_com_co_1');
define('DB_USER', 'kb7rp8qk');
define('DB_PASSWORD', '5TeQu3S!');
define('DB_HOST', 'mysql.cmxdistribuidora.com.co');

// Conexión a la base de datos
$conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Buscar y sanitizar
$search = isset($_GET['search']) ? htmlspecialchars(trim($_GET['search']), ENT_QUOTES, 'UTF-8') : '';

// Consulta para obtener los datos
$sql = "SELECT * FROM encuestas WHERE nombre LIKE ? OR documento_identidad LIKE ? OR punto_venta LIKE ? OR email LIKE ? OR telefono LIKE ? OR nuevocampo LIKE ? OR sugerencias LIKE ?";
$search_param = "%$search%";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sssssss", $search_param, $search_param, $search_param, $search_param, $search_param, $search_param, $search_param);
$stmt->execute();
$result = $stmt->get_result();

// Función para exportar a CSV
if (isset($_POST['export'])) {
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment;filename="encuestas.csv"');
    
    $output = fopen('php://output', 'w');
    fputcsv($output, ['Nombre', 'Documento de Identidad', 'Punto de Venta', 'Correo', 'Teléfono', 'Rating', '¿Qué nos hace diferentes?', 'Sugerencias', 'Aceptó Términos', 'Fecha']);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $row['acepto'] = $row['acepto'] ? 'Sí' : 'No';
            fputcsv($output, [$row['nombre'], $row['documento_identidad'], $row['punto_venta'], $row['email'], $row['telefono'], $row['rating'], $row['nuevocampo'], $row['sugerencias'], $row['acepto'], $row['fecha']]);
        }
    }
    fclose($output);
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listado de Encuestas</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        .search-bar {
            margin-bottom: 20px;
        }
        .form-content{
            display: flex;
            gap: 5px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2 class="text-center mt-4">Listado de Encuestas</h2>
        <div class="form-content">
            <form class="search-bar form-inline mb-4" method="GET" action="">
                <input type="text" name="search" class="form-control mr-2" placeholder="Buscar..." value="<?php echo htmlspecialchars($search, ENT_QUOTES, 'UTF-8'); ?>">
                <input type="submit" value="Buscar" class="btn btn-primary">
            </form>
            <form action="" method="post">
                <input type="submit" name="export" value="Exportar a Excel" class="btn btn-success">
            </form>
        </div>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Documento de Identidad</th>
                    <th>Punto de Venta</th>
                    <th>Correo</th>
                    <th>Teléfono</th>
                    <th>Rating</th>
                    <th>¿Qué nos hace diferentes?</th>
                    <th>Sugerencias</th>
                    <th>Aceptó Términos</th>
                    <th>Fecha</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        $acepto = $row['acepto'] ? 'Sí' : 'No';
                        echo "<tr>
                                <td>{$row['nombre']}</td>
                                <td>{$row['documento_identidad']}</td>
                                <td>{$row['punto_venta']}</td>
                                <td>{$row['email']}</td>
                                <td>{$row['telefono']}</td>
                                <td>{$row['rating']}</td>
                                <td>{$row['nuevocampo']}</td>
                                <td>{$row['sugerencias']}</td>
                                <td>{$acepto}</td>
                                <td>{$row['fecha']}</td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='10'>No hay resultados</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
<?php
$stmt->close();
$conn->close();
?>
