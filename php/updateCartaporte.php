<?php
//jalar la cookie de sesión 
session_start();

//importar archivos
include_once 'config.php'; 
include_once 'regex.php'; 

    //verificar si el usuario ha iniciado 
if(!isset($_SESSION['user_id']) || empty($_SESSION['user_id'])){
    header("Location: index.php"); 
    exit();
}else{
//verificar la conexión con la base de datos 
$conn = db_user();
if($conn->connect_error){
    die("Error en la conexión: ". $conn->connect_error);
}else{
    try{
 // iniciar transacción
 $conn->begin_transaction();
        
 //Sanitización y validación de los datos del formulario 
    $id_cartaporte = mysqli_real_escape_string($conn, regex($_POST['id']));
    $operator = mysqli_real_escape_string($conn, regex($_POST['operator']));  
    $plate = mysqli_real_escape_string($conn, regex($_POST['plate']));
    $model = mysqli_real_escape_string($conn, regex($_POST['model']));
    $origin = mysqli_real_escape_string($conn, regex($_POST['origin']));
    $fecha_salida = mysqli_real_escape_string($conn, regex($_POST['departure-date']));
    $departure_time = mysqli_real_escape_string($conn, regex($_POST['departure-time']));
    $destination = mysqli_real_escape_string($conn, regex($_POST['destination']));
    $number = mysqli_real_escape_string($conn, regex($_POST['contact-number']));
    

    //actualizar información en la tabla 
    $sql = "UPDATE cartaporte 
    SET operador = ?, placa = ?, modelo = ?, ciudad_origen = ?, fecha_salida = ?, hora_salida = ?, destino = ?, num_contacto = ?
    WHERE id = ?";
$stmt = $conn->prepare($sql); 
$stmt->bind_param("ssssssssi", $operator, $plate, $model, $origin, $fecha_salida, $departure_time, $destination, $number, $id_cartaporte); 
if ($stmt->execute()) {
// echo "Filas afectadas: " . $stmt->affected_rows; // Depuración: verifica que afecte filas
$conn->commit(); 
echo "<script>
    alert('¡Cartaporte actualizado exitosamente!');
    window.location = 'principal.php';
</script>";
} else {
throw new Exception("Error al actualizar datos: " . $stmt->error);
}
}catch(Exception $e){
    
    // revertir transacción
    $conn->rollback();
    echo "Error: " . $e->getMessage();
    
    }
    $conn->close();
}
}

      ?>