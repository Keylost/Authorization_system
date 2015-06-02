<?php
require_once 'core/model.php'; 
require_once 'core/view.php';
require_once 'core/controller.php';
require_once 'core/route.php';
require_once 'core/route_auth.php';

//start router
route_auth::start();
Route::start(); // запускаем маршрутизатор
?>