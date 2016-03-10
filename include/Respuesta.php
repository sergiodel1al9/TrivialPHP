<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Respuesta
 *
 * @author Sergio
 */
class Respuesta {

    private $texto;
    private $correcta;

    function __construct($texto, $correcta) {
        $this->texto = $texto;
        $this->correcta = $correcta;
    }

    public function getTexto() {
        return $this->texto;
    }

    public function getCorrecta() {
        return $this->correcta;
    }

    public function setTexto($texto) {
        $this->texto = $texto;
    }

    public function setCorrecta($correcta) {
        $this->correcta = $correcta;
    }

}
