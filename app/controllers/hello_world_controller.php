<?php
  //require 'app/models/kysely.php';
  class HelloWorldController extends BaseController{

    public static function index(){
      // make-metodi renderöi app/views-kansiossa sijaitsevia tiedostoja
   	  echo 'Tämä on etusivu!';
    }

  public static function inquiry_list(){
      View::make('suunnitelmat/inquiry_list.html');
    }

  public static function login(){
      View::make('suunnitelmat/login.html');
    }

  public static function sandbox(){
      // Testaa koodiasi täällä
      //View::make('helloworld.html');
      $ohtu= Kysymys::find(1);
      $kaikki= Kysymys::all(1);
      //Debugausta Kintillä
      Kint::dump($kaikki);
      Kint::dump($ohtu);
    }

  public static function inquiry_show(){
      View::make('suunnitelmat/inquiry_show.html');
    }
  
  public static function course_show(){
      View::make('suunnitelmat/course_show.html');
    }
  
  public static function inquiry_edit(){
      View::make('suunnitelmat/inquiry_edit.html');
    }

  }
