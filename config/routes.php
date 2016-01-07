<?php

  $routes->get('/', function() {
    HelloWorldController::index();
  });

  $routes->get('/hiekkalaatikko', function() {
    HelloWorldController::sandbox();
  });

  $routes->get('/inquiry_list', function() {
    HelloWorldController::inquiry_list();
  });

  $routes->get('/login', function() {
    HelloWorldController::login();
  });

  $routes->get('/inquiry_show', function() {
    HelloWorldController::inquiry_show();
  });

  $routes->get('/course_show', function() {
    HelloWorldController::course_show();
  });

  $routes->get('/inquiry_edit', function() {
    HelloWorldController::inquiry_edit();
  });
//Tästä eteenpäin varsinaisen sovelluksen polut
//Kyselyiden listaussivu
  $routes->get('/kysely_lista', function() {
    KyselyController::index();
  });

  $routes->get('/', function() {
    KyselyController::index();
  });

//Kyselyn lisäyslomakkeen näyttäminen
  $routes->get('/kysely/uusi', function(){
    KyselyController::create();
  });

//Kyselyn esittelysivu
  $routes->get('/kysely/:id', function($id){
    KyselyController::find($id);
  });
  
//Kyselyn lisääminen tietokantaan
  $routes->post('/kysely', function(){
    KyselyController::store();
  });