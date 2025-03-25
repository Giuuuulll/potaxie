<?php
session_start();
include 'conexion.php';
header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $correo = trim($_POST['correo'] ?? '');
    $password = $_POST['password'] ?? '';

    if (empty($correo) || empty($password)) {
        echo json_encode(["respuesta" => "error", "mensaje" => "Todos los campos son obligatorios."]);
        exit();
    }

    $sql = "SELECT id, nombre, contrasena FROM usuarios WHERE correo=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $correo);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        
        
        if (password_verify($password, $row['contrasena'])) {
            $_SESSION['usuario'] = $row['nombre'];
            echo json_encode(["respuesta" => "ok"]);
        } else {
            echo json_encode(["respuesta" => "error", "mensaje" => "Contraseña incorrecta."]);
        }
    } else {
        echo json_encode(["respuesta" => "error", "mensaje" => "Usuario no encontrado."]);
    }

    $stmt->close();
    $conn->close();
}
?>
