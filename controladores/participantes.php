<?php

class participantes
{

	public function __construct($posti_d = 0, $usuario_id = 0)
	{
		$this->post_id= $post_id;
        $this->usuario_id = $usuario_id;
	}

	// Datos de la tabla "participantes"
    const NOMBRE_TABLA = "participantes";

    const POST_ID = "post_id";
    const USUARIO_ID = "usuario_id";
    
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

    
    private function crear($participantes)
    {
        

        try {

            $pdo = ConexionBD::obtenerInstancia()->obtenerBD();

            // Sentencia INSERT
            $comando = "INSERT INTO " . self::NOMBRE_TABLA . " ( " .
                self::POST_ID . "," .
                self::USUARIO_ID . "," .
                " VALUES(?,?)";
       
            $sentencia = $pdo->prepare($comando);

            $sentencia->bindParam(1, $participantes[self::POST_ID]);
                       
            $sentencia->bindParam(2, $participantes[self::USUARIO_ID]);
                     
                        
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


    private function listar($participantes){

        $idpost = $feed[self::POST_ID];

        $comando = "SELECT ".self::POST_ID . ",".self::USUARIO_ID ." from ".self::NOMBRE_TABLA." =? ";
        
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