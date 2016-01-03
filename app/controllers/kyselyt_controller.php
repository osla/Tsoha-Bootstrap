<?php

class KyselyController extends BaseController{

	public static function index(){
		//haetaan kaikki kurssikyselyt tietokannasta
		$kyselyt = Kysely::all();
		View::make('kyselyt/index.html', array('kyselyt' => $kyselyt));
	}

	public static function kyselynhaku($id){
		//haetaan yksi kysely tietokannasta
		$kysely = Kysely::find($id);
		View::make('kyselyt/kysely.html', array('kysely' => $kysely));
	}
}