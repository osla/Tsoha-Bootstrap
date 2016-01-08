<?php

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
		$params = $_POST;
		$attributes = array(
			'kyselynnimi' => $params['kyselynnimi'],
			'kurssiid' => $params['kurssiid'],
			'alkupvm' => $params['alkupvm'],
			'loppupvm' => $params['loppupvm']
		);

		$kysely = new Kysely($attributes);
		$errors = $kysely->errors();

		if(count($errors) == 0){
			//Kysely on syötetty oikein!
		$kysely->save();
		
		Redirect::to('/kysely/'.$kysely->kyselyid, array('message' => 'Kysely on lähes valmis. Lisää siihen seuraavaksi kysymykset!'));
		}else{
			//Kyselyn syötteessä on jotain vikaa!
		View::make('/kysely/uusi.html', array('errors' => $errors, 'attributes' => $attributes));
		}
	}

	public static function create(){
		//haetaan uuden kyselyn luomiseen tarvittavat tiedot
		$kurssit = Kurssi::all();
		$kayttajat = Kayttaja::all();
		View::make('kysely/uusi.html', array('kurssit' => $kurssit, 'kayttajat' => $kayttajat));
	}
}