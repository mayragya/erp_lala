<?php
//jalar la cookie de sesión 
session_start(); 
//llamado de scripts de conexión con la base de datos y limpieza de datos
include_once 'config.php'; 
include_once 'regex.php';  
include_once 'getIpclient.php';

// Verificar conexión con la base de datos 
$conn = db_user(); 
if ($conn->connect_error) {
    $connectionStatus = "Error: " . $conn->connect_error; 
}else{

    $connectionStatus = "Conexión activa";
}
    // Obtener el nombre del servidor
    $serverName = gethostname(); 
    //tambien se puede usar gethostname(); para mostrar el nombre del equipo desde el que se está conectando 
    //echo $serverName; 

    //recuperar el username de la base de datos con el id de usuario que se guarda al iniciar sesión   
    $user_id = $_SESSION['user_id'];

    // Recuperar el nombre de usuario desde la base de datos
    $stmt = $conn->prepare("SELECT userName FROM users WHERE id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        $username = $user['userName']; // Nombre de usuario
    } else {
        // Manejar caso de usuario no encontrado
        $username = 'No autenticado';
    }
    $stmt->close();
    $conn->close();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Principal</title>
    <link rel="stylesheet" href="../css/principal.css">
</head>
<body>

    <div class="principalBg" >
        <img src="../images/principal_bg.png" class="lalaBG"  loading="lazy"> 
        <img src="../images/FESS.png" class="headerLala" loading="lazy">
        <img src="../images/Q11.png" class="footerLala"  loading="lazy"> 
        <p class="headerText">Estatus de conexión al servidor: <span><?php echo htmlspecialchars($connectionStatus);?></p>
        <p class="footerText">
        Nombre de la estación de trabajo: <span><?php echo htmlspecialchars($serverName);?></span>
        </p>
        <p class="ip-server">IP servidor Gestión: <span><?php echo htmlspecialchars(real_ip());?></span>
        </p>

        </div>
        <section class="user">
            <img class="user-info" src="../images/Q9.png">
            <img class="user-icon" src="../images/userIcon.png">
            <img class="logo-lala" src="../images/logoLala.png">
            <p class="userName"><span><?php echo htmlspecialchars($username);?></span></p>
            <p class="datetimeText" id="datetime"></p>

        </section>

        <section class="buttons">
            <a href="cartaporte.php"><img class="button-img" src="../images/Q1.png"></a>
            <a href="#"><img class="button-img" src="../images/Q2.png"></a>
            <a href="#"><img class="button-img" src="../images/Q3.png"></a>
            <a href="#"><img class="button-img" src="../images/Q4.png"></a>
            <a href="#"><img class="button-img" src="../images/Q5.png"></a>

        </section>
        <script src="../js/js.js"></script>
</body>

</html>     