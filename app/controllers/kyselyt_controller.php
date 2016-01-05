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
		View::make('kysely/kysely.html', array('kysely' => $kysely));
	}
}