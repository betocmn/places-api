<?php
/*
 * Defines which collections are available for the API
 *
 * @author: Humberto Moreira <humberto.mn@gmail.com>
 */

$app->mount(new \PhalconRest\Collection\ResourceCollection);
$app->mount(new AuthCollection);
