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

    function __construct($texto, $respuestas) {
        $this->texto = $texto;
        $this->respuestas = $respuestas;
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

}
