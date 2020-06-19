<?php

namespace Afp;

use Symfony\Component\BrowserKit\HttpBrowser;

class Habitad extends Afp
{
    static $urlConect = 'http://www.afphabitat.cl/';
    static $urlSaldo = 'https://www.afphabitat.cl/homePrivadoWeb/afiliado/homeafiliado.htm?touchId=';
    private $touchId;
    private $request;
    private $saldoTotal;
    private $saldoObligatorio;
    private $saldoCuenta2;

    function __construct($params)
    {
        parent::setRut($params['rut']);
        parent::setPassword($params['password']);
        $this->setRequest();
    }

    protected function setRequest() {
        $this->request = new HttpBrowser();
    }

    public function setTouchId($touchId) {
        $this->touchId = $touchId;
    }

    public function getTouchId() {
        return $this->touchId;
    }

    public function Conectar() {
        $params = [
            'j_username' => parent::getRut(),
            'j_password' => parent::getPassword(),
        ];
        $crawler = $this->request->request('GET', self::$urlConect);
        $form = $crawler->selectButton('Ingresar')->form();
        $crawler2 = $this->request->submit($form, $params);
        $touchId = strstr($crawler2->text(), 'touchId=');
        $touchId = strstr($touchId, '}', true);
        $touchId = strstr($touchId, '=');
        $touchId = str_replace('=', '', str_replace('"', '', $touchId));
        $this->setTouchId($touchId);
    }

    public function SaldoTotal() {
        if(!is_null($this->saldoTotal)) return $this->saldoTotal;
        if(is_null($this->touchId)) $this->Conectar();
        $url = self::$urlSaldo . $this->touchId;
        $crawler = $this->request->request('GET', $url);
        $saldo =  $crawler->filter('.ht-ahorrado')->each(function ($node) {
           return $node->text();
        });
        $this->setSaldo($saldo[0]);
        return $this->saldoTotal;
    }
 
    protected function setSaldo($saldo) {
        $this->saldoTotal = $saldo;
    }

    public function SaldoObligatorio() {
        if (!is_null($this->saldoObligatorio)) return $this->saldoObligatorio;
        if(is_null($this->touchId)) $this->Conectar();
        $url = self::$urlSaldo . $this->touchId;
        $crawler = $this->request->request('GET', $url);
        $arrayKey = $crawler->filter('.h5.font-medium')->each(function ($node, $i) {
            $pos = strpos($node->text(), 'Obligatorias');
            if ($pos !== false) {
                return $i;
            }
         });
         foreach ($arrayKey as $value) {
            if(!is_null($value)){
                $this->saldoObligatorio = $crawler->filter('div.ht-col-lg-2.ht-col-sm-3.hidden-xs.column > .h5')->eq($value)->text();
                return $this->saldoObligatorio;
            }
         }
    }

    public function SaldoCuenta2() {
        if (!is_null($this->saldoCuenta2)) return $this->saldoCuenta2;
        if(is_null($this->touchId)) $this->Conectar();
        $url = self::$urlSaldo . $this->touchId;
        $crawler = $this->request->request('GET', $url);
        $arrayKey = $crawler->filter('.h5.font-medium')->each(function ($node, $i) {
            $pos = strpos($node->text(), 'Cuenta 2');
            if ($pos !== false) {
                return $i;
            }
         });
         foreach ($arrayKey as $value) {
            if(!is_null($value)){
                $this->saldoCuenta2 = $crawler->filter('div.ht-col-lg-2.ht-col-sm-3.hidden-xs.column > .h5')->eq($value)->text();
                return $this->saldoCuenta2;
            }
         }
    }
}
