<?php

class feed_imagenes
{

    public function __construct($imagen_id, $post_id, $url)

    {        
        $this->imagen_id = $imagen_id;
        $this->post_id = $post_id;
        $this->url = $url;
    }

    // Datos de la tabla "feed"

    const ESTADO_URL_INCORRECTA = "estado_url_incorrecta";
    const ESTADO_CREACION_EXITOSA = "OK";
    const ESTADO_CREACION_FALLIDA = "ERROR";

   

    public static function post($peticion)
        {
            if ($peticion[0] == 'insertar') {
                return self::insertar($_POST);
            } 
            else if ($peticion[0] == "listar")
            {
                return self::listar($_POST);

            }
            
            else {
                throw new ExcepcionApi(self::ESTADO_URL_INCORRECTA, "Url mal formada", 400);
            }
        }


    private function insertar($feed_imagenes)
    {
        

        try {

            $pdo = ConexionBD::obtenerInstancia()->obtenerBD();

            // Sentencia INSERT
            $comando = "INSERT INTO feed_imagenes (imagen_id, post_id, url) values (?,?,?)" ;
       
            $sentencia = $pdo->prepare($comando);

            $sentencia->bindParam(1, $feed->imagen_id);
                       
            $sentencia->bindParam(2, $feed->post_id);
                       
            $sentencia->bindParam(3, $feed->url);

            
            $resultado = $sentencia->execute();
           
            if ($resultado) {

                
                return true;
            } else {
                return false;
            }
        } catch (Exception $e) {
            print_r($e);    
            
            return false;
            
        }

    }

}