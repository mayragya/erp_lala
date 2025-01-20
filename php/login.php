<?php
session_start(); 

include_once 'config.php';
include_once 'regex.php'; 

$conn = db_user();
if($conn -> connect_error){
    die("Error en la conexion: " . $conn -> connect_error);
}

//codigo de login por parte del backend 
// Procesar el formulario solo si el método de la solicitud es POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userName = $_POST['userName'] ?? ''; 
    $userName = cleanEmail($userName); 
    $pswd = $_POST['password'] ?? ''; 
    $pswd = cleanPass($pswd); 

    // Verificación con la base de datos utilizando Prepared Statements
    $stmt = $conn->prepare("SELECT * FROM users WHERE userName = ? AND password = ?");
    $stmt->bind_param("ss", $userName, $pswd);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Credenciales correctas
        $user = $result->fetch_assoc();
        $_SESSION['user_id'] = $user['id']; 
        $_SESSION['status'] = 'Conectado';
        session_regenerate_id(true);
        setcookie("isUserLoggedIn", "true", time() + 3600, "/"); // La cookie expira en 1 hora
        header("Location: /php/principal.php");
        exit(); 
    } else {
        // Credenciales incorrectas
        echo "<script>
        alert('Datos incorrectos, favor de verificar correo o contraseña');
        window.location = 'index.php';
        </script>";
        $_SESSION['status'] = 'Desconectado';

    }

    $stmt->close();
}

$conn->close();
?>