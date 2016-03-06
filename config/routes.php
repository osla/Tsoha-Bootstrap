<?php

function check_logged_in() {
  BaseController::check_logged_in();
}  

  $routes->get('/hiekkalaatikko', function() {
    KyselyController::update(22);
  });

//Tästä eteenpäin varsinaisen sovelluksen polut
//Kyselyiden listaussivu
  $routes->get('/kysely_lista','check_logged_in', function() {
    KyselyController::index();
  });

  $routes->get('/','check_logged_in', function() {
    KyselyController::index();
  });

//Kyselyn lisäyslomakkeen näyttäminen
  $routes->get('/kysely/uusi','check_logged_in', function(){
    KyselyController::create();
  });

//Kyselyn esittelysivu
  $routes->get('/kysely/:id', 'check_logged_in', function($id){
    KyselyController::find($id);
  });
  
//Kyselyn lisääminen tietokantaan
  $routes->post('/kysely/', 'check_logged_in', function(){
    KyselyController::store();
  });

//Kyselyn muokkauslomakkeen esittäminen
  $routes->get('/kysely/:id/edit', 'check_logged_in', function($id){
    KyselyController::edit($id);
  });

//Kyselyn muokkaaminen
  $routes->post('/kysely/:id/edit', 'check_logged_in', function($id){
    KyselyController::update($id);
  });

//Kyselyn poisto
  $routes->post('/kysely/:id/destroy', 'check_logged_in', function($id){
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

  //Uloskirjautuminen
  $routes->post('/logout', function(){
    UserController::logout();
  });

  $routes->get('/kayttaja/kayttajalista','check_logged_in', function() {
    UserController::index();
  });

  //Rekisteröitymislomakkeen näytäminen
  $routes->get('/kayttaja/rekisteroidy',function() {
    UserController::create();
  });

  //Käyttäjän lisääminen tietokantaan
  $routes->post('/kayttaja/',function() {
    UserController::store();
  });

  //Käyttäjän poisto
  $routes->post('/kayttaja/:id/destroy', 'check_logged_in', function($id){
    UserController::destroy($id);
  });
