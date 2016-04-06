<?php

class AuthCollection extends \Phalcon\Mvc\Micro\Collection
{
    public function __construct()
    {
        $this->setHandler('AuthController', true);
        $this->setPrefix('/users');

        $this->post('/authenticate', 'authenticate');
    }
}
