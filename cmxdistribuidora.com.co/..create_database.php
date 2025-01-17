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

// Crear conexión
$conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Crear base de datos
$sql = "CREATE DATABASE IF NOT EXISTS " . DB_NAME;
if ($conn->query($sql) === TRUE) {
    echo "Base de datos creada exitosamente o ya existe.";
} else {
    echo "Error al crear la base de datos: " . $conn->error;
}

// Seleccionar base de datos
$conn->select_db(DB_NAME);

// Crear tabla
$sql = "CREATE TABLE IF NOT EXISTS encuestas1 (
    id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(255) NOT NULL,
    punto_venta VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    telefono VARCHAR(20),
    rating INT(1) NOT NULL,
    diferentes TEXT,
    sugerencias TEXT,
    acepto TINYINT(1) NOT NULL,
    fecha TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";
if ($conn->query($sql) === TRUE) {
    echo "Tabla encuestas creada exitosamente o ya existe.";
} else {
    echo "Error al crear la tabla: " . $conn->error;
}

// Cerrar conexión
$conn->close();
?>
