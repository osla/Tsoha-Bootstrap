<?php

require 'app/models/kysely.php';

class KyselyController extends BaseController{

	public static function index(){
		//haetaan kaikki kurssikyselyt tietokannasta
		self::check_logged_in();
		$kyselyt = Kysely::all();
		View::make('kysely/kysely_lista.html', array('kyselyt' => $kyselyt));
	}

	public static function find($id){
		//haetaan yksi kysely tietokannasta
		self::check_logged_in();
		$kysely = Kysely::find($id);
		$kysymyslista = Kysymys::all($id);
		View::make('kysely/kysely.html', array('kysely' => $kysely, 'kysymyslista' => $kysymyslista));
	}


	public static function store(){
		self::check_logged_in();
        $kayttajaid = $_SESSION['user'];
        $user = User::find($kayttajaid);
        //$kayttajannimi = $user->kayttajannimi;
		//Kint::dump($kayttajannimi);
		$kurssit = Kurssi::all();
		$params = $_POST;
		$attributes = new Kysely(array(
			'kyselynnimi' => $params['kyselynnimi'],
			'kurssiid' => $params['kurssiid'],
			'alkupvm' => $params['alkupvm'],
			'loppupvm' => $params['loppupvm'],
			'kayttajaid' => $kayttajaid
		));

		$kysely = new Kysely($attributes);
		$errors = $kysely->errors();

		if(count($errors) == 0){
			//Kysely on syötetty oikein!
		$kysely->save();
		
		Redirect::to('/kysely/'.$kysely->kyselyid, array('message' => 'Kysely on lähes valmis. Lisää siihen seuraavaksi kysymykset!'));
		}else{
			//Kyselyn syötteessä on jotain vikaa!
		View::make('/kysely/uusi.html', array('kurssit' => $kurssit, 'errors' => $errors, 'attributes' => $attributes));
		}
	}

	public static function create(){
		self::check_logged_in();
		//haetaan uuden kyselyn luomiseen tarvittavat tiedot
		$kurssit = Kurssi::all();
		$kayttajat = Kayttaja::all();
		View::make('kysely/uusi.html', array('kurssit' => $kurssit, 'kayttajat' => $kayttajat));
	}

	//Kyselyn muokkaaminen (lomakkeen esittäminen)
	public static function edit($id) {
		self::check_logged_in();
		$kysely = Kysely::find($id);
		$kurssit = Kurssi::all();
		View::make('kysely/edit.html', array('attributes' => $kysely, 'kurssit' => $kurssit));
	}

	//Kyselyn muokkaaminen (lomakkeen käsittely)
	public static function update($id){
		self::check_logged_in();
		$params = $_POST;
		$kyselyid = $params['kyselyid'];

		$attributes = array(
			'kyselyid' => $kyselyid,
			'kyselynnimi' => $params['kyselynnimi'],
			'kurssiid' => $params['kurssiid'],
			'alkupvm' => $params['alkupvm'],
			'loppupvm' => $params['loppupvm'],
			//'kayttajannimi' => $params['kayttajannimi'],
			'tila' => $params['tila']
		);

		$kysely = new Kysely($attributes);
		$errors = $kysely->errors();

		// Kint::trace();
		// Kint::dump($attributes);
		if(count($errors) > 0){
			$kurssit = Kurssi::all();
			View::make('kysely/edit.html', array('errors' => $errors, 'attributes' => $attributes, 'kurssit'=>$kurssit));
		} else {
			$kysely->update();
			Redirect::to('/kysely/'. $kysely->kyselyid, array('message' => 'Kyselyä on muokattu onnistuneesti'));
		}
	}

	//Kyselyn poistaminen
	public static function destroy($id){
		self::check_logged_in();
		//alustetaan Kysely-olio annetulla id:llä
		$kysely = new Kysely(array('kyselyid' => $id));
		//kutsutaan Kysely-luokan metodia destroy, joka poistaa kyselyn sen id:llä
		$kysely->destroy();

		Redirect::to('/kysely_lista', array('message' => 'Kysely on poistettu onnistuneesti!'));
	}

}