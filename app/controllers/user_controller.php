<?php

require 'app/models/user.php';

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
		//haetaan kaikki kayttajat tietokannasta
		$kayttajat = User::all();
		View::make('kayttaja/kayttajalista.html', array('kayttajat' => $kayttajat));
	}

	public static function create(){
		View::make('kayttaja/rekisteroidy.html');
	}

	public static function store(){
		$params = $_POST;
		$kayttaja = $_POST['kayttajaid'];
		$sana1 = $_POST['salasana'];
		$kayttaja_admin = FALSE;
		$attributes = new User(array(
				'kayttajaid' => $params['kayttajaid'],
				'kayttajannimi' => $params['kayttajannimi'],
				'salasana' => $params['salasana'],
				// 'salasana2' => $params['salasana2'],
				'admin' => $kayttaja_admin
		));

		$kayttaja = new User($attributes);
		$errors = $kayttaja->errors();

		if(count($errors) == 0){
			//Kayttaja on syötetty oikein!
			$kayttaja->save();
			Redirect::to('/login', array('message' => 'Käyttäjä on nyt rekisteröity. Kirjaudu sovellukseen.'));
		} else {
			Redirect::to('/kayttaja/rekisteroidy', array('errors' => $errors));
		}	
	}

		//Kayttajan poistaminen
	public static function destroy($id){
		self::check_logged_in();
		$destroyer = self::get_user_logged_in();
		$destroyerId = $destroyer->getId();

		//Kint::dump($destroyerId);
		if($id == $destroyerId){
			Redirect::to('/kayttaja/kayttajalista', array('message' => 'Et voi poistaa itseäsi!'));
		} else {	
		//alustetaan User-olio annetulla id:llä
		$kayttaja = new User(array('kayttajaid' => $id));
		//kutsutaan User-luokan metodia destroy, joka poistaa kyselyn sen id:llä
		$kayttaja->destroy();
		Redirect::to('/kayttaja/kayttajalista', array('message' => 'Käyttäjä on poistettu onnistuneesti!'));
		}
	}

}	