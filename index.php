<!DOCTYPE html>
<?php
require_once './include/DB.php';

$db = new DB();
echo $db->listarNumeroPreguntas();
echo '<br>';
cadenaPregunta($db->listaPregunta(5));

function cadenaPregunta($valor) {
    $array = array();
    $array = explode('{', $valor);

    echo 'Pregunta: ' . $array[0];
    echo '<br>';
    echo 'Respuestas: ' . rtrim($array[1], '}');


    $pollas = array();
    $pollas = explode('.', rtrim($array[1], '}'));

    foreach ($pollas as $pene) {
        echo '<br>';

        if ($pene[0] === '=') {
            echo 'Respuesta correcta: ';
        } else {
            echo 'Respuesta incorrecta: ';
        }

        $pene = substr($pene, 1);
        echo $pene;
    }
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
