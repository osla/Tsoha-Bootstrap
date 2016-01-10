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
      //$ohtu= Kysely::find(1);
      //$kaikki= Kysely::all();
      //Debugausta Kintillä
      //Kint::dump($kaikki);
      //Kint::dump($ohtu);
      /*$doom = new Kysely(array(
        'kyselynnimi' => '',
        'kurssiid' => '67',
        'alkupvm' => '2015-09-01',
        'loppupvm' => '2017-09-01'
        ));
      $errors = $doom->errors();
      */
      //Kint::dump($params);
      //Kint::dump($errors);
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
