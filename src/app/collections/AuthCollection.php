<?php
/*
 * Maps Auth actions/URLs with controller methods
 *
 * @author: Humberto Moreira <humberto.mn@gmail.com>
 */
class AuthCollection extends \Phalcon\Mvc\Micro\Collection
{
    public function __construct()
    {
        $this->setHandler('AuthController', true);
        $this->setPrefix('/users');

        $this->post('/authenticate', 'authenticate');
    }
}
