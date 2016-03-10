<!DOCTYPE html>
<?php
require_once './include/DB.php';
require_once './include/Pregunta.php';
require_once './include/Respuesta.php';

$url = 'http://localhost/TrivialPHP/servicio.php';
$uri = 'http://localhost/TrivialPHP/';
$cliente = new SoapClient(null, array('location' => $url, 'uri' => $uri));

//$db = new DB();
echo $cliente->listarNumeroPreguntas();
echo '<br>';
$pregunta = cadenaAPregunta($cliente->listaPregunta(9));

echo $pregunta->getTexto();


/**
 * Función que nos permite transformar el texto devuelto por la base de datos en un objeto Pregunta
 * @param String $valor La cadena devuelta por la base de datos que contiene la información de la pregunta y sus respuestas
 * @return \Pregunta El objeto Pregunta completamente formado
 */
function cadenaAPregunta($valor) {

    // Definimos un arrray
    $array = array();
    
    // Separamos la cadena por el caracter '{'
    $array = explode('{', $valor);

    // Definimos otro array
    $respuestas = array();
    
    // Separamos las respuestas por el caracter '.'
    $respuestas = explode('.', rtrim($array[1], '}'));
    
    // Creamos un array para almacenar los objetos Respuesta
    $arrayRespuestas = array();

    // Iteramos por las cadenas de las respuestas
    for ($index = 0; $index < count($respuestas) - 1; $index++) {
        
        // Creamos el objeto Respuesta dependiendo de si son verdaderas o falsas fijandonos en que tengan el carácter "="
        if ($respuestas[$index][1] === '=') {
            $resp = new Respuesta(substr($respuestas[$index], 2), TRUE);
        } else {
            $resp = new Respuesta(substr($respuestas[$index], 2), FALSE);
        }

        // Añadimos el objeto Respuesta al array de respuestas
        $arrayRespuestas[] = $resp;
    }
        

    // Creamos el objeto Pregunta
    $pregunta = new Pregunta($array[0], $arrayRespuestas);
    
    // Devolvemos el objeto Pregunta
    return $pregunta;
    
    
    
}
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
    </body>
</html>