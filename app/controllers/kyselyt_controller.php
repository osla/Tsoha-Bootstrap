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
		$kysely = new Kysely(array(
			'kyselynnimi' => $params['kyselynnimi'],
			'kayttajannimi' => $params['kayttajannimi'],
			'kurssinnimi' => $params['kurssinnimi'],
			'alkupvm' => $params['alkupvm'],
			'loppupvm' => $params['loppupvm']
		));

		Kint::dump($params);

		$kysely->save();

		Redirect::to('/kysely/'.$kysely->kyselyid, array('message' => 'Kysely on tallennettu!'));
	}

	public static function create(){
		//haetaan uuden kyselyn luomiseen tarvittavat tiedot
		$kurssit = Kurssi::all();
		$kayttajat = Kayttaja::all();
		View::make('kysely/uusi.html', array('kurssit' => $kurssit, 'kayttajat' => $kayttajat));
	}
}