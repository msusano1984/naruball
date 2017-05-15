<?php

class usuarios
{

	public function __construct($admin = "", $nombre = "", $id_usuario = 0)

	{
		$this->admin = $admin;
        $this->nombre = $nombre;
        $this->id_usuario = $id_usuario;
	}

	// Datos de la tabla "usuarios"
    const NOMBRE_TABLA = "usuarios";

    const ADMIN = "admin";
    const NOMBRE = "nombre";
    const ID_USUARIO = "id_usuario";
    const ESTADO_URL_INCORRECTA = "url_incorrecta";
    const ESTADO_CREACION_EXITOSA = "OK";
    const ESTADO_CREACION_FALLIDA = "ERROR";

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

    
    private function crear($usuarios)
    {
        

        try {

            $pdo = ConexionBD::obtenerInstancia()->obtenerBD();

            // Sentencia INSERT
            $comando = "INSERT INTO " . self::NOMBRE_TABLA . " ( " .
                self::ADMIN . "," .
                self::NOMBRE . "," .
                self::ID_USUARIO . ")" .
                " VALUES(?,?,?)";
       
            $sentencia = $pdo->prepare($comando);

            $sentencia->bindParam(1, $usuarios[self::ADMIN]);

            $sentencia->bindParam(2, $usuarios[self::NOMBRE]);

            $sentencia->bindParam(3, $usuarios[self::ID_USUARIO]);
             
                        
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


    private function listar($usuarios){

      //  $idpost = $feed[self::POST_ID];

        if($_GET['id_usuario']==    '0'){
            $comando = "SELECT ".self::ADMIN . ",".self::NOMBRE .",".self::ID_USUARIO ." from ".self::NOMBRE_TABLA;
        }else {
           $comando = "SELECT ".self::ADMIN . ",".self::NOMBRE .",".self::ID_USUARIO ." from ".self::NOMBRE_TABLA ." where ".self::ID_USUARIO . " = ? "; 
        }
        
        $sentencia = ConexionBD::obtenerInstancia()->obtenerBD()->prepare($comando);
        
        $sentencia->bindParam(1, $_GET['id_usuario']);
        
        if ($sentencia->execute())
        {
            return  $sentencia->fetchall(PDO::FETCH_ASSOC);

            

        }else{
            return "error";
        }
    }
}