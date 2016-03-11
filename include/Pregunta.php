<?php

require_once 'Respuesta.php';
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Pregunta
 *
 * @author Sergio
 */
class Pregunta {

    private $texto;
    private $respuestas = array();
    private $multiRespuesta = false;

    function __construct($texto, $respuestas) {
        $this->texto = $texto;
        $this->respuestas = $respuestas;


        // Creamos un contador
        $contador = 0;

        // Iteramos por todas las respuestas
        foreach ($respuestas as $respuesta) {

            // Comprobamos si las respuesta es correcta
            if ($respuesta->getCorrecta() === TRUE) {
                // Si lo es, aumentamos el contador
                $contador++;
            }
        }

        // Comprobamos si el contador es mayor de uno, lo que 
        // implica que habrá más de una respuesta correcta
        if ($contador > 1) {
            // Si es el caso, cambiamos la variable multiRespuesta a TRUE
            $this->multiRespuesta = TRUE;
        }
    }

    public function getTexto() {
        return $this->texto;
    }

    public function getRespuestas() {
        return $this->respuestas;
    }

    public function setTexto($texto) {
        $this->texto = $texto;
    }

    public function setRespuestas($respuestas) {
        $this->respuestas = $respuestas;
    }

    public function getMultiRespuesta() {
        return $this->multiRespuesta;
    }

}