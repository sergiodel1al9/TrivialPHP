<!DOCTYPE html>
<?php
require_once './include/Pregunta.php';
require_once './include/Respuesta.php';

// Iniciaamos la sesión
session_start();

// Creamos un cliente para conectarnos
$url = 'http://localhost/TrivialPHP/servicio.php';
$uri = 'http://localhost/TrivialPHP/';
$cliente = new SoapClient(null, array('location' => $url, 'uri' => $uri));
//$cliente = new DB();


// Inicializamos las variables para mostrar los datos
$textoPregunta = "Pulse el botón de Nueva Pregunta";
$textoRespuesta1 = "";
$textoRespuesta2 = "";
$textoRespuesta3 = "";
$textoRespuesta4 = "";
$multiRespuesta = FALSE;

$resultado1 = "";
$resultado2 = "";
$resultado3 = "";
$resultado4 = "";


// Comprobamos que tenemos el array de preguntas realizadas en sesión
if (isset($_SESSION['preguntasRealizadas'])) {

    // Si es así, almacenamos su valor en la variable correspondiente
    $preguntasRealizadas = $_SESSION['preguntasRealizadas'];
} else {

    // Si no, inicializamos el array
    $preguntasRealizadas = array();
}


// Comprobamos si tenemos en sesión información de la puntuación
if (isset($_SESSION['puntuacion'])) {

    // Si es asi, almacenamos su valor en la variable correspondiente
    $puntuacion = $_SESSION['puntuacion'];
} else {

    // Si no es así, inicializamos la variable y almacenamos su valor inicial en sesión
    $puntuacion = 0;
    $_SESSION['puntuacion'] = $puntuacion;
}


// Comprobamos si tenemos información de una pregunta en sesión
if (isset($_SESSION['pregunta'])) {

    // Si es así, almacenamos su valor en la variable correspondiente
    $pregunta = $_SESSION['pregunta'];
} else {

    // Si no es así, inicializamos la variable a null
    $pregunta = NULL;
}

// Comprobamos si se ha pulsado el botón de nueva pregunta
if (isset($_POST['nuevaPregunta'])) {

    // Si es así, recuperamos el numero de preguntas que tenemos
    $cantidadPreguntas = $cliente->listarNumeroPreguntas();

    // Comprobamos cuantas preguntas tenemos realizadas y si su número es 
    // menor que la cantidad de preguntas que tenemos
    if (count($preguntasRealizadas) < intval($cantidadPreguntas)) {

        // Si es así, generamos un número aleatorio entre 1 y el número de preguntas disponibles
        // Si la pregunta que corresponde con el número ya ha sido contestada se generará uno nuevo
        do {
            $numeroPregunta = mt_rand(1, $cantidadPreguntas);
        } while (in_array($numeroPregunta, $preguntasRealizadas));

        // Almacenamos en número de la pregunta en el array de preguntas realizadas
        $preguntasRealizadas[] = $numeroPregunta;

        // Almacenamos el array de preguntas realizadas en sesión
        $_SESSION['preguntasRealizadas'] = $preguntasRealizadas;

        // Recuperamos la información de la pregunta correspondiente al número 
        // y transformamos la información en un objeto Pregunta
        $pregunta = cadenaAPregunta($cliente->listaPregunta($numeroPregunta));

        // Almacenamos el objeto Pregunta en sesión
        $_SESSION['pregunta'] = $pregunta;

        // Volvamos la información del objeto Pregunta a las variables necesarias 
        // para mostrar la información
        $textoPregunta = $pregunta->getTexto();
        $textoRespuesta1 = $pregunta->getRespuestas()[0]->getTexto();
        $textoRespuesta2 = $pregunta->getRespuestas()[1]->getTexto();
        $textoRespuesta3 = $pregunta->getRespuestas()[2]->getTexto();
        $textoRespuesta4 = $pregunta->getRespuestas()[3]->getTexto();

        // Asignamos la variable para comprobar si la pregunta requiere de más de una respuesta
        $multiRespuesta = $pregunta->getMultiRespuesta();
    } else {

        // En caso de que no queden preguntas, se ha terminado el juego y se muestra un mensaje con la puntuación
        $textoPregunta = "No quedan preguntas. Su puntuación es: " . $puntuacion;
        $textoRespuesta1 = "";
        $textoRespuesta2 = "";
        $textoRespuesta3 = "";
        $textoRespuesta4 = "";
        $multiRespuesta = FALSE;
    }

    // Limpiamos los valores de los resultados
    $resultado1 = "";
    $resultado2 = "";
    $resultado3 = "";
    $resultado4 = "";
}



// Comprobamos si se ha enviado una respuesta
if (isset($_POST['respuesta']) ||
        isset($_POST['respuesta1']) ||
        isset($_POST['respuesta2']) ||
        isset($_POST['respuesta3']) ||
        isset($_POST['respuesta4'])) {

    // Inicializamos el valor de los puntos de la pregunta
    $puntos = 0;

    // Comprobamos si es una pregunta que requiere más de una respusta
    if ($pregunta->getMultiRespuesta()) {

        // Si es así, inicializamos el contador de respuestas correctas
        $correctas = 0;

        // Itermaos todas las respuesas de la pregunta
        foreach ($pregunta->getRespuestas() as $respuesta) {

            // Comprobamos si la respuesta es correcta
            if ($respuesta->getCorrecta()) {

                // SI lo es, aumentamos el contador de respustas correctas
                $correctas++;
            }
        }

        // Comprobamos si se ha marcado el checkbox correspondiente a la respuesta 1
        if (isset($_POST['respuesta1'])) {

            // Comprobamos si la respuesta 1 es una respuesta correcta
            if ($pregunta->getRespuestas()[0]->getCorrecta()) {

                // Si lo es, incrementamos la variable de puntos
                $puntos++;

                // Cambiamos la variable de resultado de la pregunta a Correcto
                $resultado1 = "Correcto";
            } else {
                // En caso contrario cambiamos la variable de resultado de la pregunta a Error
                $resultado1 = "Error";
            }
        }

        // Comprobamos si se ha marcado el checkbox correspondiente a la respuesta 2
        if (isset($_POST['respuesta2'])) {

            // Comprobamos si la respuesta 2 es una respuesta correcta
            if ($pregunta->getRespuestas()[1]->getCorrecta()) {

                // Si lo es, incrementamos la variable de puntos
                $puntos++;

                // Cambiamos la variable de resultado de la pregunta a Correcto
                $resultado2 = "Correcto";
            } else {
                // En caso contrario cambiamos la variable de resultado de la pregunta a Error
                $resultado2 = "Error";
            }
        }

        // Comprobamos si se ha marcado el checkbox correspondiente a la respuesta 3
        if (isset($_POST['respuesta3'])) {

            // Comprobamos si la respuesta 3 es una respuesta correcta
            if ($pregunta->getRespuestas()[2]->getCorrecta()) {

                // Si lo es, incrementamos la variable de puntos
                $puntos++;

                // Cambiamos la variable de resultado de la pregunta a Correcto
                $resultado3 = "Correcto";
            } else {
                // En caso contrario cambiamos la variable de resultado de la pregunta a Error
                $resultado3 = "Error";
            }
        }

        // Comprobamos si se ha marcado el checkbox correspondiente a la respuesta 4
        if (isset($_POST['respuesta4'])) {

            // Comprobamos si la respuesta 4 es una respuesta correcta
            if ($pregunta->getRespuestas()[3]->getCorrecta()) {

                // Si lo es, incrementamos la variable de puntos
                $puntos++;

                // Cambiamos la variable de resultado de la pregunta a Correcto
                $resultado4 = "Correcto";
            } else {
                // En caso contrario cambiamos la variable de resultado de la pregunta a Error
                $resultado4 = "Error";
            }
        }

        // Calculamos la puntuación dividiendo los puntos de la 
        // respuesta entre la cantidad de respuestas correctas
        $puntos = $puntos / $correctas;
    } else {

        // Comprobamos si se ha marcado el radio de respuesta 1
        if (isset($_POST['respuesta']) && $_POST['respuesta'] === 'respuesta1') {

            // Comprobamos si la respuesta 1 es la correcta
            if ($pregunta->getRespuestas()[0]->getCorrecta()) {

                // Si lo es, incrementamos la variable de puntos
                $puntos += 1;

                // Cambiamos la variable de resultado de la pregunta a Correcto
                $resultado1 = "Correcto";
            } else {

                // En caso contrario cambiamos la variable de resultado de la pregunta a Error
                $resultado1 = "Error";
            }
        }

        // Comprobamos si se ha marcado el radio de respuesta 2
        if (isset($_POST['respuesta']) && $_POST['respuesta'] === 'respuesta2') {

            // Comprobamos si la respuesta 2 es la correcta
            if ($pregunta->getRespuestas()[1]->getCorrecta()) {

                // Si lo es, incrementamos la variable de puntos
                $puntos += 1;

                // Cambiamos la variable de resultado de la pregunta a Correcto
                $resultado2 = "Correcto";
            } else {

                // En caso contrario cambiamos la variable de resultado de la pregunta a Error
                $resultado2 = "Error";
            }
        }

        // Comprobamos si se ha marcado el radio de respuesta 3
        if (isset($_POST['respuesta']) && $_POST['respuesta'] === 'respuesta3') {

            // Comprobamos si la respuesta 3 es la correcta
            if ($pregunta->getRespuestas()[2]->getCorrecta()) {

                // Si lo es, incrementamos la variable de puntos
                $puntos += 1;

                // Cambiamos la variable de resultado de la pregunta a Correcto
                $resultado3 = "Correcto";
            } else {

                // En caso contrario cambiamos la variable de resultado de la pregunta a Error
                $resultado3 = "Error";
            }
        }

        // Comprobamos si se ha marcado el radio de respuesta 4
        if (isset($_POST['respuesta']) && $_POST['respuesta'] === 'respuesta4') {

            // Comprobamos si la respuesta 4 es la correcta
            if ($pregunta->getRespuestas()[3]->getCorrecta()) {

                // Si lo es, incrementamos la variable de puntos
                $puntos += 1;

                // Cambiamos la variable de resultado de la pregunta a Correcto
                $resultado4 = "Correcto";
            } else {

                // En caso contrario cambiamos la variable de resultado de la pregunta a Error
                $resultado4 = "Error";
            }
        }
    }

    // Volvamos la información del objeto Pregunta a las variables necesarias 
    // para mostrar la información
    $textoPregunta = $pregunta->getTexto();
    $textoRespuesta1 = $pregunta->getRespuestas()[0]->getTexto();
    $textoRespuesta2 = $pregunta->getRespuestas()[1]->getTexto();
    $textoRespuesta3 = $pregunta->getRespuestas()[2]->getTexto();
    $textoRespuesta4 = $pregunta->getRespuestas()[3]->getTexto();

    // Asignamos la variable para comprobar si la pregunta requiere de más de una respuesta
    $multiRespuesta = $pregunta->getMultiRespuesta();

    // Incrementamos la puntuación almacenada en sesión con los puntos generados por la pregunta
    $_SESSION['puntuacion'] += $puntos;
    
    // Actualizamos el valor de la puntuación con el valor almacenado en sesión
    $puntuacion = $_SESSION['puntuacion'];
}

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
        <link type="text/css" rel="stylesheet" href="estilos.css" />
        <title>Trivial Pursuit</title>
    </head>
    <div>
        <form id="formPreguntas" action="index.php" method="POST">
            <input form="formPreguntas" type="submit" name="nuevaPregunta" id="nuevaPregunta" value="Nueva Pregunta" /><label>Puntuacion: <?php echo $puntuacion ?></label>
        </form>
    </div>
    <div>
        <p></p>
    </div>
    <div>
        <div>
            <p><?php echo $textoPregunta ?></p>
        </div>
        <div>
            <form id="formRespuestas" action="index.php" method="POST">
                <div class="respuestas">
                    <?php
                    
                    // Estructura para generar radio buttons o checkboxes dependiendo del tipo de pregunta
                    if ($multiRespuesta !== TRUE) {
                        echo '<label><input type="radio" name="respuesta" value="respuesta1" />&nbsp;' . $textoRespuesta1 . ' <a class="';
                        if ($resultado1 === 'Error') {
                            echo 'error">';
                        } else {
                            echo 'correcto">';
                        }
                        echo $resultado1 . '</a></label>';

                        echo '<label><input type="radio" name="respuesta" value="respuesta2" />&nbsp;' . $textoRespuesta2 . ' <a class="';
                        if ($resultado2 === 'Error') {
                            echo 'error">';
                        } else {
                            echo 'correcto">';
                        }
                        echo $resultado2 . '</a></label>';

                        echo '<label><input type="radio" name="respuesta" value="respuesta3" />&nbsp;' . $textoRespuesta3 . ' <a class="';
                        if ($resultado3 === 'Error') {
                            echo 'error">';
                        } else {
                            echo 'correcto">';
                        }
                        echo $resultado3 . '</a></label>';

                        echo '<label><input type="radio" name="respuesta" value="respuesta4" />&nbsp;' . $textoRespuesta4 . ' <a class="';
                        if ($resultado4 === 'Error') {
                            echo 'error">';
                        } else {
                            echo 'correcto">';
                        }
                        echo $resultado4 . '</a></label>';
                    } else {
                        echo '<label><input type="checkbox" name="respuesta1" value="respuesta1" />&nbsp;' . $textoRespuesta1 . ' <a class="';
                        if ($resultado1 === 'Error') {
                            echo 'error">';
                        } else {
                            echo 'correcto">';
                        }
                        echo $resultado1 . '</a></label>';

                        echo '<label><input type="checkbox" name="respuesta2" value="respuesta2" />&nbsp;' . $textoRespuesta2 . ' <a class="';
                        if ($resultado2 === 'Error') {
                            echo 'error">';
                        } else {
                            echo 'correcto">';
                        }
                        echo $resultado2 . '</a></label>';


                        echo '<label><input type="checkbox" name="respuesta3" value="respuesta3" />&nbsp;' . $textoRespuesta3 . ' <a class="';
                        if ($resultado3 === 'Error') {
                            echo 'error">';
                        } else {
                            echo 'correcto">';
                        }
                        echo $resultado3 . '</a></label>';


                        echo '<label><input type="checkbox" name="respuesta4" value="respuesta1" />&nbsp;' . $textoRespuesta4 . ' <a class="';
                        if ($resultado4 === 'Error') {
                            echo 'error">';
                        } else {
                            echo 'correcto">';
                        }
                        echo $resultado4 . '</a></label>';
                    }
                    ?>                    
                </div>
                <div>
                    <input type="submit" value="Enviar Respuesta" />
                </div>
            </form>

        </div>
    </div>
    <body>
    </body>
</html>