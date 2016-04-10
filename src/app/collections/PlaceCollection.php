<?php
/*
 * Maps Places actions/URLs with controller methods
 *
 * @author: Humberto Moreira <humberto.mn@gmail.com>
 */
class PlaceCollection extends \Phalcon\Mvc\Micro\Collection
{
    public function __construct()
    {
        $this->setHandler('PlaceController', true);
        $this->setPrefix('/places');

        $this->get('/search', 'search');
        $this->post('/recommendations', 'recommendations');
    }
}
