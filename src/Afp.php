<?php

namespace Afp;

use function GuzzleHttp\Psr7\str;

class Afp
{
    private $rut;
    private $password;
    private $saldoTotal;
    private $saldoObligatorio;
    private $saldoCuenta2;

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

    public function setSaldoTotal($saldoTotal) {
        $this->saldoTotal = $this->CleanDinero($saldoTotal);
    }

    public function getSaldoTotal() {
        return $this->saldoTotal;
    }

    public function setCuentaObligatoria($saldoTotal) {
        $this->saldoObligatorio = $this->CleanDinero($saldoTotal);
    }

    public function getSaldoObligatorio() {
        return $this->saldoObligatorio;
    }

    public function setCuenta2($saldoTotal) {
        $this->saldoCuenta2 = $this->CleanDinero($saldoTotal);
    }

    public function getSaldoCuenta2() {
        return $this->saldoCuenta2;
    }

    public function CleanDinero($dinero) {
        return str_replace('$', '', str_replace(',', '', str_replace('.', '', $dinero)));
    }
}
