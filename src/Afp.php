<?php

namespace Afp;

class Afp
{
    private $rut;

    function __construct()
    {
        $this->rut = '';
    }

    public function getRut()
    {
        return $this->rut;
    }

    public function setRut(String $rut)
    {
        $this->rut = $rut;
    }
}
