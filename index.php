<?php

require('Router.php');
use RestPHP\Router\Router;

$Router = new Router();

$Router->get('/', function () {
    echo 'This is page of index';
});

$Router->get('/contact', function () {
    echo 'This is page of a contact';
});

$Router->get('/users', function () {
    echo 'This is page of all users';
});


$Router->get('/user/:id|int', function ($data) {
    echo 'This is page of user: ' . $data['id'];
});


$_SERVER['REQUEST_METHOD'] = 'POST';
$Router->post('/user/:name|string', function($data){
    echo 'This is page of user:  '.$data['name'];
});


$_SERVER['REQUEST_METHOD'] = 'PUT';
$Router->put('/user/:id|int/:height|float', function($data){
    echo 'This is page of user: '.$data['id'];
    echo '<br>He has '.$data['height'].'m';
});


$_SERVER['REQUEST_METHOD'] = 'DELETE';
$Router->delete('/user/:id|int/:type|bool', function($data){
    echo 'This is page of user: ' . $data['id'];
    echo '<br>He has type: ';
    echo ($data['type']) ? 'Actived' : 'Disabled';
});
