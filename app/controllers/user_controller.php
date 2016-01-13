<?php

class UserController extends BaseController{
	public static function login(){
		View::make('user/login.html');
	}

	public static function handle_login(){
		$params =$_POST;

		$user = User::authenticate($params['kayttajansposti'], $params['salasana']);

		if(!$user){
			View::make('user/login.html', array('message' => 'Väärä käyttäjätunnus tai salasana!', 'kayttajansposti' => $params['kayttajansposti']));
		} else {
			$_SESSION['user'] = $user->kayttajaid;

			Redirect::to('/', array('message' => 'Tervetuloa takaisin' . $user->kayttajannimi . '!'));
		}
	}
}