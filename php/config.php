<?php
#credenciales de la base de datos

function getIv(){
    $content = parseEnvFile('../.env');
    return $content['IV'];
}
function parseEnvFile($path){
    $content = file_get_contents($path);
    $lines = explode ("\n", $content);
    $envData = [];  
        foreach ($lines as $line) {
            $line = trim($line);
    
              if(empty($line) || strpos($line, '#') === 0){
                    continue;
                }
                list ($key, $value)= explode ('=', $line, 2);
                $envData[$key]= trim($value);
        }
        return $envData;
    }
        function db_user(){
            $credenciales = parseEnvFile('../.env'); 
            //credenciales guarda toda la información de las credenciales de usuarios creados   
            //{}
            $servername = $credenciales['SERVER_NAME'];
            $username = $credenciales['USER_NAME'];
             $password =$credenciales['PASSWORD'];
             $dbname= $credenciales['DB_NAME'];
            $conn = new mysqli ($servername,
                                 $username,
                                $password, 
                                $dbname);
            #verificar si hay errores en la conexión
            if($conn -> connect_error){
                die("Error en la conexión:" . $conn -> connect_error);
                    }
            return $conn;
    }

?>