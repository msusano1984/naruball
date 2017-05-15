<?php

class feed_imagenes
{

  

    public function __construct($imagen_id = "", $post_id = "", $url = "")
    {
        $this->imagen_id = $imagen_id;
        $this->post_id = $post_id;
        $this->url = $url;
        
    }

    // Datos de la tabla "feed_imagenes"
    const NOMBRE_TABLA = "feed_imagenes";

    const IMAGEN_ID = "imagen_id";
    const POST_ID = "post_id";
    const URL = "url";

    
    public static function post($peticion)
    {
        if ($peticion[0] == 'registro') {
            return self::registrar();
        } 
        else if ($peticion[0] == "listar")
        {
            return self::listar($_POST);

        } else {
            throw new ExcepcionApi(self::ESTADO_URL_INCORRECTA, "Url mal formada", 400);
        }
    }   

    
    private function crear($feed_imagenes)
    {
        

        try {

            $pdo = ConexionBD::obtenerInstancia()->obtenerBD();

            // Sentencia INSERT
            $comando = "INSERT INTO " . self::NOMBRE_TABLA . " ( " .
                self::IMAGEN_ID . "," .
                self::POST_ID . "," .
                self::URL . "," .
                " VALUES(?,?,?)";
       
            $sentencia = $pdo->prepare($comando);

            $sentencia->bindParam(1, $feed_imagenes[self::IMAGEN_ID]);
                       
            $sentencia->bindParam(2, $feed_imagenes[self::POST_ID]);
                       
            $sentencia->bindParam(3, $feed_imagenes[self::URL]);

            
            $resultado = $sentencia->execute();
           
            if ($resultado) {

                
                return self::ESTADO_CREACION_EXITOSA;
            } else {
                return self::ESTADO_CREACION_FALLIDA;
            }
        } catch (PDOException $e) {

            throw new ExcepcionApi(self::ESTADO_URL_INCORRECTA, $e->getMessage(), 400);
            
        }

    }
   
    private function registrar()
    {
        $cuerpo = file_get_contents('php://input');
        $usuario = json_decode($cuerpo);

        $resultado = self::crear($_POST);

        switch ($resultado) {
            case self::ESTADO_CREACION_EXITOSA:
               http_response_code(200);
               return "OK";
               
                break;
            case self::ESTADO_CREACION_FALLIDA:
                throw new ExcepcionApi(self::ESTADO_CREACION_FALLIDA, "Ha ocurrido un error");
                break;
            default:
                throw new ExcepcionApi(self::ESTADO_FALLA_DESCONOCIDA, "Falla desconocida", 400);
        }
    }


    private function listar($feed_imagenes){

        $idpost = $feed_imagenes[self::POST_ID];

        $comando = "SELECT ".self::POST_ID . ",".self::IMAGEN_ID .",".self::URL."  from ".self::NOMBRE_TABLA." where ".self::POST_ID."=? ";
        
        $sentencia = ConexionBD::obtenerInstancia()->obtenerBD()->prepare($comando);
        $sentencia->bindParam(1, $idpost);


        if ($sentencia->execute())
        {
            return  $sentencia->fetchall(PDO::FETCH_ASSOC);

            

        }else{
            return "error";
        }
    }

    

    
}