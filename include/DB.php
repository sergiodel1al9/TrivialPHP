<?php

class DB {

    /**
     * Objeto que almacenará la base de datos PDO
     * @var type PDO Object
     */
    private $dwes;

    /**
     * Constructor de la clase DB
     * @throws Exception Si hay un error se lanza una excepción
     */
    public function __construct() {
        try {
            $serv = "localhost";
            $base = "trivial";
            $usu = "root";
            $pas = "";
            // Creamos un array de configuración para la conexion PDO a la base de 
            // datos
            $opc = array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8");
            // Creamos la cadena de conexión con la base de datos
            $dsn = "mysql:host=$serv;dbname=$base";
            // Finalmente creamos el objeto PDO para la base de datos
            $this->dwes = new PDO($dsn, $usu, $pas, $opc);
            $this->dwes->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    /**
     * Método que nos permite realizar consultas a la base de datos
     * @param string $sql Sentencia sql a ejecutar
     * @return array Resultado de la consulta
     * @throws Exception Lanzamos una excepción si se produce un error
     */
    private function ejecutaConsulta($sql) {
        try {
            // Comprobamos si el objeto se ha creado correctamente
            if (isset($this->dwes)) {
                // De ser así, realizamos la consulta
                $resultado = $this->dwes->query($sql);
                // Devolvemos el resultado
                return $resultado;
            }
        } catch (Exception $ex) {
            // Si se produce un error, lanzamos una excepción
            throw $ex;
        }
    }

    public function listarNumeroPreguntas() {
        $sql = "SELECT count(numero) as Num_Preg FROM preguntas";
        $resultado = self::ejecutaConsulta($sql);

        if ($resultado) {
            $row = $resultado->fetch();
            
            return $row['Num_Preg'];
        }

        return 0;
    }
    
    public function listaPregunta($numero) {
        $sql = "SELECT pregunta FROM preguntas WHERE numero =" . $numero . ";";
        $resultado = self::ejecutaConsulta($sql);

        if ($resultado) {
            $row = $resultado->fetch();
            
            return $row['pregunta'];
        }

        return '';
    }
    
    

}
