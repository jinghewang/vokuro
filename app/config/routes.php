<?php
/*
 * Define custom routes. File gets included in the router service definition.
 */
$router = new Phalcon\Mvc\Router();

$router->add('/confirm/{code}/{email}', array(
    'controller' => 'user_control',
    'action' => 'confirmEmail'
));

$router->add('/reset-password/{code}/{email}', array(
    'controller' => 'user_control',
    'action' => 'resetPassword'
));


$router->add('/robot-param/{param1}/{param2}', array(
    'controller' => 'robots',
    'action' => 'param'
));

$router->add('/robot-param2/{param1}/{param2}', array(
    'controller' => 'robots',
    'action' => 'param2'
));

return $router;
