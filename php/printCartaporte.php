<?php
//jalar la cookie de sesión 
session_start(); 

//importar archivos
include_once 'config.php'; 
include_once 'regex.php'; 

    //verificar si el usuario ha iniciado sesión 
if (!isset($_SESSION['user_id']) || empty($_SESSION['user_id'])) {
    echo json_encode([
        "error" => "Usuario no autenticado"
    ]);
    exit();
}
    //verificar con exión con la base de datos 
    $conn = db_user(); 
    if ($conn->connect_error) {
    die("Error en la conexión: " . $conn->connect_error); 
}


    // Recuperar el registro de la tabla "cartaporte"
    $id_cartaporte = $_GET['id']; // ID del cartaporte para editar
    $stmt = $conn->prepare("SELECT * FROM cartaporte WHERE id = ?");
    $stmt->bind_param("i", $id_cartaporte);
    $stmt->execute();
    $cartaporte = $stmt->get_result()->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Formato Cartaporte</title>
  <link rel="stylesheet" href="../css/printCartaporte.css">
</head>
<body>
  <div class="cartaporte">
    <div class="header">
      <img src="../images/logoLala.png" alt="Logo Lala" class="logo">
      <h1>CARTAPORTE</h1>
      <p>Av. Irapuato 1790, Ciudad. Industrial Irapuato,<br>36541 Irapuato, Gto.</p>
    </div>

    <form action="updateCartaporte.php" method="post" enctype="multipart/form-data">
      <!-- Campo oculto para enviar el ID -->
      <input type="hidden" name="id" id="id" value="<?php echo htmlspecialchars($cartaporte['id']); ?>">

      <div class="form-group">
        <label for="operator">Operador:</label>
        <input type="text" id="operator" name="operator" value="<?php echo htmlspecialchars($cartaporte['operador']); ?>">
      </div>

      <div class="form-group">
        <label for="plate">Placa de Transporte:</label>
        <input type="text" id="plate" name="plate" value="<?php echo htmlspecialchars($cartaporte['placa']); ?>">
      </div>

      <div class="form-group">
        <label for="model">Modelo:</label>
        <input type="text" id="model" name="model" value="<?php echo htmlspecialchars($cartaporte['modelo']); ?>">
      </div>

      <div class="form-group">
        <label for="origin">Ciudad Origen:</label>
        <input type="text" id="origin" name="origin" value="<?php echo htmlspecialchars($cartaporte['ciudad_origen']); ?>">
      </div>

      <div class="form-group">
        <label for="departure-date">Fecha de salida del transporte:</label>
        <input type="date" id="departure-date" name="departure-date" 
               value="<?php echo htmlspecialchars(date('Y-m-d', strtotime($cartaporte['fecha_salida']))); ?>">
      </div>

      <div class="form-group">
        <label for="departure-time">Hora de salida del transporte:</label>
        <input type="time" id="departure-time" name="departure-time" 
               value="<?php echo htmlspecialchars($cartaporte['hora_salida']); ?>">
      </div>

      <div class="form-group">
        <label for="destination">Dirección de destino:</label>
        <input type="text" id="destination" name="destination" value="<?php echo htmlspecialchars($cartaporte['destino']); ?>">
      </div>

      <div class="form-group">
        <label for="contact-number">Número de contacto:</label>
        <input type="text" id="contact-number" name="contact-number" value="<?php echo htmlspecialchars($cartaporte['num_contacto']); ?>">
      </div>

    </form>
  </div>

  <button onclick=" imprimirPagina()">imprimir</button>
</body>
<script src="../js/js.js"></script>
</html>
