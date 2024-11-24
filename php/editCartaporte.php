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

    // Obtener la IP del cliente
    $clientIp = $_SERVER['REMOTE_ADDR']; 
    // convertir IPv6 (por ejemplo, ::1 para localhost) a IPv4
    if ($clientIp === '::1') {
        $clientIp = '127.0.0.1'; // IPv4 para localhost
    } elseif (strpos($clientIp, ':') !== false) {
        // Convertir una dirección IPv6 a IPv4 si es posible, si no existe una IPv4 para el host, la mostrará en v6
        $clientIp = gethostbyname(gethostbyaddr($clientIp));
    }

    //recuperar el username de la base de datos con el id de usuario que se guarda al iniciar sesión  
    // Obtener el user_id de la sesión y status del usuario 
    $user_id = $_SESSION['user_id'];
    $status = isset($_SESSION['status']) ? $_SESSION['status'] : 'Desconectado';

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

    
    // Recuperar el registro de la tabla "cartaporte"
    $cartaporte_id = $_GET['id']; // ID del cartaporte para editar
    $stmt = $conn->prepare("SELECT * FROM cartaporte WHERE id = ?");
    $stmt->bind_param("i", $cartaporte_id);
    $stmt->execute();
    $cartaporte = $stmt->get_result()->fetch_assoc();

    $conn->close();
    ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cartaporte</title>
    <link rel="stylesheet" href="../css/editCartaporte.css">
</head>
<body>
    <div class="cartaporteBg">
            <img src="../images/principal_bg.png" class="lalaBG"  loading="lazy"> 
            <img src="../images/FESS.png" class="headerLala" loading="lazy">
                    <p class="headerText">Estatus de conexión al servidor: <span><?php echo htmlspecialchars($status);?></p>
            <p class="footerText">
            Nombre de la estación de trabajo: <span><?php echo htmlspecialchars($serverName);?></span>
            </p>
            <p class="ip-server">IP servidor Gestión: <span><?php echo htmlspecialchars($clientIp);?></span>
            </p>
            </div>

            <div class="section-1">
        <img class="button-img" src="../images/Q1.png">
        <img class="user-info" src="../images/Q9.png">
        <img class="user-icon" src="../images/userIcon.png">
            <img class="logo-lala" src="../images/logoLala.png">
            <p class="userName"><span><?php echo htmlspecialchars($username);?></span></p> 
        </div>

        <div class="footer">
        <img src="../images/Q11.png" class="footerLala"  loading="lazy"> 
        <p class="datetimeText" id="datetime"></p> 
        </div>
        
        <div class="container">
  <form action="updateCartaporte.php" method="post" enctype="multipart/form-data">
    <input type="hidden" name="id" id="id" value="<?php echo htmlspecialchars($cartaporte['id']); ?>">

    <!-- Primera columna -->
    <div class="form-group">
      <label for="operator">Operador</label>
      <input type="text" id="operator" name="operator" value="<?php echo htmlspecialchars($cartaporte['operador']); ?>">
    </div>

    <div class="form-group">
      <label for="plate">Placa de Transporte</label>
      <input type="text" id="plate" name="plate" value="<?php echo htmlspecialchars($cartaporte['placa']); ?>">
    </div>

    <div class="form-group">
      <label for="model">Modelo</label>
      <input type="text" id="model" name="model" value="<?php echo htmlspecialchars($cartaporte['modelo']); ?>">
    </div>

    <div class="form-group">
      <label for="origin">Ciudad Origen</label>
      <input type="text" id="origin" name="origin" value="<?php echo htmlspecialchars($cartaporte['ciudad_origen']); ?>">
    </div>

    <!-- Segunda columna -->
    <div class="form-group">
      <label for="departure-date">Fecha de salida del transporte</label>
      <?php $fecha_salida = date('Y-m-d', strtotime($cartaporte['fecha_salida'])); ?>
      <input type="date" id="departure-date" name="departure-date" value="<?php echo htmlspecialchars($fecha_salida); ?>">
    </div>

    <div class="form-group">
      <label for="departure-time">Hora de salida del transporte</label>
      <input type="time" id="departure-time" name="departure-time" value="<?php echo htmlspecialchars($cartaporte['hora_salida']); ?>">
    </div>

    <div class="form-group">
      <label for="destination">Dirección de destino</label>
      <input type="text" id="destination" name="destination" value="<?php echo htmlspecialchars($cartaporte['destino']); ?>">
    </div>

    <div class="form-group">
      <label for="contact-number">Número de contacto</label>
      <input type="text" id="contact-number" name="contact-number" value="<?php echo htmlspecialchars($cartaporte['num_contacto']); ?>">
    </div>

    <!-- Botón para enviar -->
    <input type="submit" value="Actualizar">
  </form>
</div>

</body>

</html>