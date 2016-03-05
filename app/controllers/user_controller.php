<?php

class UserController extends BaseController{
	
	public static function login(){
		View::make('/login.html');
	}

	public static function handle_login(){
		$params =$_POST;

		$user = User::authenticate($params['kayttajaid'], $params['salasana']);
		//Kint::dump($user);
		if(!$user){
			View::make('/login.html', array('message' => 'Väärä käyttäjätunnus tai salasana!', 'kayttajaid' => $params['kayttajaid']));
		} else {
			$_SESSION['user'] = $user->kayttajaid;
			//Kint::dump($user);
			Redirect::to('/', array('message' => 'Tervetuloa takaisin ' . $user->kayttajannimi . '!'));
		}
	}

	public static function index(){
		//haetaan kaikki kurssikyselyt tietokannasta
		$kayttajat = User::all();
		View::make('kayttaja/kayttaja_lista.html', array('kayttajat' => $kayttajat));
	}

	public static function create(){
		View::make('kayttaja/rekisteroidy.html');
	}

	public static function find(){

	}

}	