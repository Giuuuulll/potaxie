<?php
session_start();
header("Content-Type: application/json");
error_reporting(E_ALL);
ini_set('display_errors', 1);


$conexion = new mysqli("localhost", "root", "", "mi_sistema");

if ($conexion->connect_error) {
    echo json_encode(["respuesta" => "error", "mensaje" => "Error de conexión a la base de datos."]);
    exit;
}


$nombre = trim($_POST["nombre"] ?? '');
$correo = trim($_POST["correo"] ?? '');
$contrasena = $_POST["password"] ?? '';


if (empty($nombre) || empty($correo) || empty($contrasena)) {
    echo json_encode(["respuesta" => "error", "mensaje" => "Todos los campos son obligatorios."]);
    exit;
}


$stmt = $conexion->prepare("SELECT id FROM usuarios WHERE correo = ?");
$stmt->bind_param("s", $correo);
$stmt->execute();
$resultado = $stmt->get_result();

if ($resultado->num_rows > 0) {
    echo json_encode(["respuesta" => "error", "mensaje" => "El correo ya está registrado."]);
    exit;
}


$contrasenaHash = password_hash($contrasena, PASSWORD_DEFAULT);


$stmt = $conexion->prepare("INSERT INTO usuarios (nombre, correo, contrasena) VALUES (?, ?, ?)");
$stmt->bind_param("sss", $nombre, $correo, $contrasenaHash);

if ($stmt->execute()) {
    $_SESSION["usuario"] = $nombre;
    $_SESSION["correo"] = $correo;
    
    echo json_encode(["respuesta" => "ok"]);
} else {
    echo json_encode(["respuesta" => "error", "mensaje" => "No se pudo registrar el usuario."]);
}


$stmt->close();
$conexion->close();
?>
