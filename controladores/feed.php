<?php

class feed
{

    public function __construct($created_time = "", $created_usuario_id = 0, $fecha_evento = "", $id_post = 0, $mensaje = "", $tipo_posteo = "")

    {        
        $this->created_time = $created_time;
        $this->created_usuario_id = $created_usuario_id;
        $this->fecha_evento = $fecha_evento;
        $this->id_post = $id_post;
        $this->mensaje = $mensaje;
        $this->tipo_posteo = $tipo_posteo;
       
    }

    // Datos de la tabla "feed"
    const NOMBRE_TABLA = "feed";

    const CREATED_TIME = "created_time";
    const CREATED_USUARIO_ID = "created_usuario_id";
    const FECHA_EVENTO = "fecha_evento";
    const ID_POST = "id_post";
    const MENSAJE = "mensaje";
    const TIPO_POSTEO = "tipo_posteo";


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

    
    private function crear($feed)
    {
        

        try {

            $pdo = ConexionBD::obtenerInstancia()->obtenerBD();

            // Sentencia INSERT
            $comando = "INSERT INTO " . self::NOMBRE_TABLA . " ( " .
                self::CREATED_TIME . "," .
                self::CREATED_USUARIO_ID . "," .
                self::FECHA_EVENTO . "," .
                self::ID_POST . "," .
                self::MENSAJE . "," .
                self::TIPO_POSTEO . "," .
                " VALUES(?,?,?,?,?,?)";
       
            $sentencia = $pdo->prepare($comando);

            $sentencia->bindParam(1, $feed[self::CREATED_TIME]);
                       
            $sentencia->bindParam(2, $feed[self::CREATED_USUARIO_ID]);
                       
            $sentencia->bindParam(3, $feed[self::FECHA_EVENTO]);

            $sentencia->bindParam(3, $feed[self::ID_POST]);

            $sentencia->bindParam(3, $feed[self::MENSAJE]);

            $sentencia->bindParam(3, $feed[self::TIPO_POSTEO]);



            
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


    private function listar($feed){

        $idpost = $feed[self::POST_ID];

        $comando = "SELECT ".self::CREATED_TIME . ",".self::CREATED_USUARIO_ID .",".self::FECHA_EVENTO .",".self::ID_POST .",".self::MENSAJE .",".self::TIPO_POSTEO ." from ".self::NOMBRE_TABLA." =? ";
        
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

