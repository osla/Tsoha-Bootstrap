<?php

  // $routes->get('/', function() {
  //   HelloWorldController::index();
  // });

  $routes->get('/hiekkalaatikko', function() {
    User::authenticate();
  });

  $routes->get('/inquiry_list', function() {
    HelloWorldController::inquiry_list();
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
  $routes->post('/kysely/', function(){
    KyselyController::store();
  });

//Kyselyn muokkauslomakkeen esittäminen
  $routes->get('/kysely/:id/edit', function($id){
    KyselyController::edit($id);
  });

//Kyselyn muokkaaminen
  $routes->post('/kysely/:id/edit', function($id){
    KyselyController::update($id);
  });

//Kyselyn poisto
  $routes->post('/kysely/:id/destroy', function($id){
    KyselyController::destroy($id);
  });

//Kirjautumislomakkeen esittäminen
  $routes->get('/login', function(){
    UserController::login();
  });

  //Kirjautumisen käsittely
  $routes->post('/login', function(){
    UserController::handle_login();
  });