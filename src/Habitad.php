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
    private $saldoTotalWithOutSymbol;

    function __construct(String $rut, String $password)
    {
        parent::setRut($rut);
        parent::setPassword($password);
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
        $this->Conectar();
        $url = self::$urlSaldo . $this->touchId;
        $crawler = $this->request->request('GET', $url);
        $saldo =  $crawler->filter('.ht-ahorrado')->each(function ($node) {
           return $node->text();
        });
        $this->setSaldo($saldo[0]);
        $this->clearSaldo();
        return $this->saldoTotal;
    }
 
    protected function setSaldo($saldo) {
        $this->saldoTotal = $saldo;
    }

    protected function setSaldoWithOutSymbol($saldo) {
        $this->saldoTotal = $saldo;
    }

    protected function clearSaldo() {
        $this->saldoTotalWithOutSymbol = str_replace('$', '', str_replace('.', '', $this->saldoTotal));
    }

    public function SaldoTotalWithOutSymbol() {
        if(!is_null($this->saldoTotalWithOutSymbol)) return $this->saldoTotalWithOutSymbol;        
        $this->Conectar();
        $url = self::$urlSaldo . $this->touchId;
        $crawler = $this->request->request('GET', $url);
        $saldo =  $crawler->filter('.ht-ahorrado')->each(function ($node) {
           return $node->text();
        });
        $this->setSaldo($saldo[0]);
        $this->clearSaldo();
        return $this->saldoTotalWithOutSymbol;
    }
}
