<?php
// Obtener la dirección IP del cliente

    function real_ip(){
        //Obtener la dirección IP por defecto: Esto establece inicialmente la dirección IP que PHP obtiene por defecto del cliente conectado.
         $ip = $_SERVER['REMOTE_ADDR'];
        //Revisar el encabezado HTTP_X_FORWARDED_FOR: Este encabezado es común cuando se utiliza un proxy o CDN, ya que puede contener una lista de direcciones IP que representan la ruta completa del cliente hasta el servidor.
        //Se filtran las direcciones IP privadas (que comienzan con 10, 172.16, o 192.168) para asegurarse de que no se utiliza una IP interna del servidor.
        //Si encuentra una IP pública válida, la utiliza como la dirección IP real.

            if (isset($_SERVER['HTTP_X_FORWARDED_FOR']) && preg_match_all('#\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}#s', $_SERVER['HTTP_X_FORWARDED_FOR'], $matches)) {
                foreach ($matches[0] as $xip) {
                    if (!preg_match('#^(10|172\.16|192\.168)\.#', $xip)) {
                        $ip = $xip;
                        break;
                    }
                }
                //Revisar el encabezado HTTP_CLIENT_IP: Este encabezado se utiliza menos frecuentemente, pero también puede contener la IP del cliente en algunos casos.
            } elseif (isset($_SERVER['HTTP_CLIENT_IP']) && preg_match('/^([0-9]{1,3}\.){3}[0-9]{1,3}$/', $_SERVER['HTTP_CLIENT_IP'])) {
                $ip = $_SERVER['HTTP_CLIENT_IP'];
            //Revisar el encabezado HTTP_CF_CONNECTING_IP: Este encabezado es específico para los servicios de Cloudflare y contiene la IP del cliente real.
            } elseif (isset($_SERVER['HTTP_CF_CONNECTING_IP']) && preg_match('/^([0-9]{1,3}\.){3}[0-9]{1,3}$/', $_SERVER['HTTP_CF_CONNECTING_IP'])) {
                $ip = $_SERVER['HTTP_CF_CONNECTING_IP'];
                //Revisar el encabezado HTTP_X_REAL_IP: Este encabezado también es utilizado por algunos proxies para enviar la IP real del cliente.
            } elseif (isset($_SERVER['HTTP_X_REAL_IP']) && preg_match('/^([0-9]{1,3}\.){3}[0-9]{1,3}$/', $_SERVER['HTTP_X_REAL_IP'])) {
                $ip = $_SERVER['HTTP_X_REAL_IP'];
            }

            // Filtrar si la dirección es IPv4, de lo contrario devolver un valor predeterminado
            if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) {
                return $ip;
            }

            // Si no hay IPv4 válida, devolver un mensaje o manejar el caso
            return 'No se encontró una dirección IPv4 válida';
        }
        //Devolver la dirección IP: Una vez que se encuentra una IP válida, se devuelve como la IP real.
        //echo real_ip();

    // function real_ip()
    // {
    //    $ip = $_SERVER['REMOTE_ADDR'];
    //     if (isset($_SERVER['HTTP_X_FORWARDED_FOR']) && preg_match_all('#\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}#s', $_SERVER['HTTP_X_FORWARDED_FOR'], $matches)) {
    //         foreach ($matches[0] AS $xip) {
    //             if (!preg_match('#^(10|172\.16|192\.168)\.#', $xip)) {
    //                 $ip = $xip;
    //                 break;
    //             }
    //         }
    //     } elseif (isset($_SERVER['HTTP_CLIENT_IP']) && preg_match('/^([0-9]{1,3}\.){3}[0-9]{1,3}$/', $_SERVER['HTTP_CLIENT_IP'])) {
    //         $ip = $_SERVER['HTTP_CLIENT_IP'];
    //     } elseif (isset($_SERVER['HTTP_CF_CONNECTING_IP']) && preg_match('/^([0-9]{1,3}\.){3}[0-9]{1,3}$/', $_SERVER['HTTP_CF_CONNECTING_IP'])) {
    //         $ip = $_SERVER['HTTP_CF_CONNECTING_IP'];
    //     } elseif (isset($_SERVER['HTTP_X_REAL_IP']) && preg_match('/^([0-9]{1,3}\.){3}[0-9]{1,3}$/', $_SERVER['HTTP_X_REAL_IP'])) {
    //         $ip = $_SERVER['HTTP_X_REAL_IP'];
    //     }
    //     return $ip;
    
    // }
    // echo real_ip();
    ?>