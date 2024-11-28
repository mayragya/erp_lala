<?php
//jalar la cookie de sesión 
session_start(); 
//llamado de scripts de conexión con la base de datos y limpieza de datos
include ("./php/config.php"); 
include ("./php/regex.php");

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

         
    <form action="php/login.php" method="POST" class="login-form">
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
