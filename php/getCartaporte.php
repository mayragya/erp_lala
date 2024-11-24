<?php
//jalar la cookie de sesión 
session_start(); 
//encabezado para manejar respuestas en formato json 
header('Content-Type: application/json');
//importar archivos
include_once 'config.php'; 

//verificar si el usuario ha iniciado sesión 
if (!isset($_SESSION['user_id']) || empty($_SESSION['user_id'])) {
    echo json_encode([
        "error" => "Usuario no autenticado"
    ]);
    exit();
}

    //verificar conexión con la base de datos 
    $conn = db_user(); 
    if ($conn->connect_error) {
    die("Error en la conexión: " . $conn->connect_error); 
}else{
    try{
        //consulta sql para leer datos 
        $sql = "SELECT * FROM cartaporte ORDER BY id ASC";
        $result = $conn->query($sql);

        $cartaportes = array();

        if($result->num_rows > 0 ){
            //salida de datos en cada fila 
            while($row = $result->fetch_assoc()){
            $cartaportes[] = $row;
            }
        }else{
            $cartaportes[]=array("operador" => "","placa" => "", "modelo" => "" , "ciudad_origen" => "", "fecha_salida" => "",  "hora_salida"=> "", "destino"=> "", "num_contacto"=> "");  
        }
        $conn->close();
        //devolver datos en formato json
        echo json_encode($cartaportes); 


    }catch(Exception $e){
        
    }
}




?>