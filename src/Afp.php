<?php

namespace Afp;

class Afp
{
    private $rut;
    private $password;

    function __construct()
    {
        $this->rut = '';
    }

    public function getRut()
    {
        return $this->rut;
    }

    public function setRut(String $rut, $flag = false)
    {
        $rut = $this->Clean($rut);
        $this->rut = $flag ? $this->Format($rut): $rut;
    }

    public function Format($rut) {
        $result = substr($rut, -4, 1) . '-' .substr($rut, strlen($rut) - 1);
        for ($i=4; $i < strlen($rut) ; $i+=3) { 
            $result = substr($rut, -3 -$i, -$i) . '.' . $result;
        }
        return $result;
    }

    public function Clean($rut) {
        return gettype($rut) === 'string' ? strtoupper(str_replace('.', '', (str_replace('-', '', $rut)))) : '';
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }
    
    public function getPassword() {
        return $this->password;
    }
}
