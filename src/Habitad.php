<?php

namespace Afp;

use Afp\Afp;
use Symfony\Component\BrowserKit\HttpBrowser;

class Habitad extends Afp
{
    static $urlConect = 'http://www.afphabitat.cl/';
    static $urlSaldo = 'https://www.afphabitat.cl/homePrivadoWeb/afiliado/homeafiliado.htm?touchId=';
    private $password;
    private $touchId;
    private $request;

    function __construct(String $rut, String $password)
    {
        parent::setRut($rut);
        $this->password = $password;
        $this->setRequest();
    }

    protected function setRequest() {
        $this->request = new HttpBrowser();
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }
    
    public function getPassword() {
        return $this->password;
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
            'j_password' => $this->password,
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
        
        $url = self::$urlSaldo . $this->touchId;
        $crawler = $this->request->request('GET', $url);
        $crawler->filter('.ht-ahorrado')->each(function ($node) {
            echo $node->text(). "\n";
        });
    }
}
