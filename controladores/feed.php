    <?php

class feed
{

    public function __construct($created_time, $created_usuario_id , $fecha_evento , $id_post, $mensaje, $tipo_posteo,$permalink, $estatus = 1 )

    {        
        $this->created_time = $created_time;
        $this->created_usuario_id = $created_usuario_id;
        $this->fecha_evento = $fecha_evento;
        $this->id_post = $id_post;
        $this->mensaje = $mensaje;
        $this->tipo_posteo = $tipo_posteo;
        $this->permalink = $permalink;
        $this->estatus = $estatus;
    }

    // Datos de la tabla "feed"
    const NOMBRE_TABLA = "feed";

    const CREATED_TIME = "created_time";
    const CREATED_USUARIO_ID = "created_usuario_id";
    const FECHA_EVENTO = "fecha_evento";
    const ID_POST = "id_post";
    const MENSAJE = "mensaje";
    const TIPO_POSTEO = "tipo_posteo";
    const PERMALINK = "permalink";
    const ESTATUS = "estatus";
    const ESTADO_URL_INCORRECTA = "estado_url_incorrecta";
    const ESTADO_CREACION_EXITOSA = "OK";
    const ESTADO_CREACION_FALLIDA = "ERROR";


    public static function post($peticion)
    {
        if ($peticion[0] == 'crear') {
            return self::crear($_POST);
        } 
        else if ($peticion[0] == "listar")
        {
            return self::listar($_POST);

        } else if ($peticion[0] == "guardaFeed")
            return self::guardaFeed($_POST);
        else {
            throw new ExcepcionApi(self::ESTADO_URL_INCORRECTA, "Url mal formada", 400);
        }
    }   

      



    private function guardaFeed($feed){


        $feed = json_decode($feed["data"]);
        


        try{
            foreach($feed as $row){
              print_r($row);

                self::crear($row);  
            }
            return true;

        }catch (PDOException $e) {

            return false;
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
                self::PERMALINK . ")" .
                " VALUES(?,?,?,?,?,?,?)";
       
            $sentencia = $pdo->prepare($comando);

            $sentencia->bindParam(1, $feed->created_time);
                       
            $sentencia->bindParam(2, $feed->created_usuario_id);
                       
            $sentencia->bindParam(3, $feed->fecha_evento);

            $sentencia->bindParam(4, $feed->id_post);

            $sentencia->bindParam(5, $feed->mensaje);

            $sentencia->bindParam(6, $feed->tipo_posteo);

            $sentencia->bindParam(7, $feed->permalink);
            
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
   
    


    private function listar($feed){


        $comando = "SELECT ".self::CREATED_TIME . ",".self::CREATED_USUARIO_ID .",".self::FECHA_EVENTO .",".self::ID_POST .",".self::MENSAJE .",".self::TIPO_POSTEO . "," .self::PERMALINK. "," .self::ESTATUS ." from ".self::NOMBRE_TABLA;
        
        $sentencia = ConexionBD::obtenerInstancia()->obtenerBD()->prepare($comando);
       // $sentencia->bindParam(1, $idpost);


        if ($sentencia->execute())
        {
            return  $sentencia->fetchall(PDO::FETCH_ASSOC);

            

        }else{
            return "error";
        }
    }







}

