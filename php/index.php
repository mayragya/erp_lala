<?php
//jalar la cookie de sesión 
session_start(); 
//llamado de scripts de conexión con la base de datos y limpieza de datos
include_once 'config.php'; 
include_once 'regex.php';  

// Verificar conexión con la base de datos 
$conn = db_user(); 
if ($conn->connect_error) {
    die("Error en la conexión: " . $conn->connect_error); 
}
// Obtener el nombre del servidor
$serverName = gethostname(); 
//tambien se puede usar gethostname(); para mostrar el nombre del equipo desde el que se está conectando 
//echo $serverName; 


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acceso</title>
    <link rel="stylesheet" href="../css/index.css">
</head>
<body>

    <div class="loginBg" >
    <img src="../images/fondo_login.jpg" class="lalaBG"  loading="lazy"> 
    <img src="../images/Q11.png" class="footerLala"  loading="lazy"> 
    <p class="footerText">
    Nombre de la estación de trabajo: <span><?php echo htmlspecialchars($serverName);?></span>
    </p>

    </div>

    <section class="formulario-cont">
         <img src="../images/VC3.jpg" class="form-img"  loading="lazy"> 

         
    <form action="index.php" method="POST" class="login-form">
    <label for="userName" class="label-login">Usuario</label>
    <br>
        <input type="text" class="input-login" name="userName" required>
        <br>
        <label for="password" class="label-login">Contraseña</label>
        <br>
        <input type="password" class="input-login" name="password" required>
        <br>
        <button type="submit" class="login-button"><img src="../images/Login.png" class="login-button-img"></button>
    </form>

    <p class="datetimeText" id="datetime"> 
    </p>
    </section>
    <div class="boxText"><h1 class="scp">ERP. SCTL <span class="version">&nbsp V1.0</span></h1>
    <h3 class="subtitulo">Sistema de Gestión para el Control de Transporte y Logística</h3>
    </div>
    <script src="../js/js.js"></script>
</body>
</html>
<?php

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
        header("Location: principal.php");
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