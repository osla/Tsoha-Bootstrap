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