<?php

  class HelloWorldController extends BaseController{

    public static function index(){
      // make-metodi renderöi app/views-kansiossa sijaitsevia tiedostoja
   	  echo 'Tämä on etusivu!';
    }

  public static function inquiry_list(){
      // Testaa koodiasi täällä
      View::make('suunnitelmat/inquiry_list.html');
    }

  public static function login(){
      // Testaa koodiasi täällä
      View::make('suunnitelmat/login.html');
    }

  public static function sandbox(){
      // Testaa koodiasi täällä
      View::make('helloworld.html');
    }

  public static function inquiry_show(){
      // Testaa koodiasi täällä
      View::make('suunnitelmat/inquiry_show.html');
    }
  
  public static function course_show(){
      // Testaa koodiasi täällä
      View::make('suunnitelmat/course_show.html');
    }
  
  public static function inquiry_edit(){
      // Testaa koodiasi täällä
      View::make('suunnitelmat/inquiry_edit.html');
    }

  }
