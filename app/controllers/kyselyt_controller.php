<?php

require 'app/models/kysely.php';

class KyselyController extends BaseController{

	public static function index(){
		//haetaan kaikki kurssikyselyt tietokannasta
		$kyselyt = Kysely::all();
		View::make('kysely/kysely_lista.html', array('kyselyt' => $kyselyt));
	}

	public static function find($id){
		//haetaan yksi kysely tietokannasta
		$kysely = Kysely::find($id);
		$kysymyslista = Kysymys::all($id);
		View::make('kysely/kysely.html', array('kysely' => $kysely, 'kysymyslista' => $kysymyslista));
	}


	public static function store(){
		$kurssit = Kurssi::all();
		$params = $_POST;
		$attributes = new Kysely(array(
			'kyselynnimi' => $params['kyselynnimi'],
			'kurssiid' => $params['kurssiid'],
			'alkupvm' => $params['alkupvm'],
			'loppupvm' => $params['loppupvm']
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
		//haetaan uuden kyselyn luomiseen tarvittavat tiedot
		$kurssit = Kurssi::all();
		$kayttajat = Kayttaja::all();
		View::make('kysely/uusi.html', array('kurssit' => $kurssit, 'kayttajat' => $kayttajat));
	}

	//Kyselyn muokkaaminen (lomakkeen esittäminen)
	public static function edit($id) {
		$kysely = Kysely::find($id);
		$kurssit = Kurssi::all();
		View::make('kysely/edit.html', array('attributes' => $kysely, 'kurssit' => $kurssit));
	}

	//Kyselyn muokkaaminen (lomakkeen käsittely)
	public static function update($id){
		$params = $_POST;
		$kyselyid = $params['kyselyid'];


		$attributes = array(
			'kyselyid' => $kyselyid,
			'kyselynnimi' => $params['kyselynnimi'],
			'kurssiid' => $params['kurssiid'],
			'alkupvm' => $params['alkupvm'],
			'loppupvm' => $params['loppupvm'],
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
		//alustetaan Kysely-olio annetulla id:llä
		$kysely = new Kysely(array('kyselyid' => $id));
		//kutsutaan Kysely-luokan metodia destroy, joka poistaa kyselyn sen id:llä
		$kysely->destroy();

		Redirect::to('/kysely_lista', array('message' => 'Kysely on poistettu onnistuneesti!'));
	}

}