<?php

class Kayttaja extends BaseModel{
	//atribuutit
	public $kayttajaid, $kayttajannimi, $salasana;
	//konstruktori
	public function _construct($attributes){
		parent::_construct($attributes);
	}

	public static function all(){
		//Alustetaan kysely tietokantayhteydellä
		//Esimerkkikysely $query=DB::connection()->prepare('SELECT * FROM Kysely');
		//Suoritetaan kysely
		$query=DB::connection()->prepare('SELECT * FROM Kayttaja');
		$query->execute();
		$rows = $query->fetchAll();
		$kayttajat = array();

		foreach ($rows as $row) {
			$kayttajat[] = new Kayttaja(array(
				'kayttajaid' => $row['kayttajaid'],
				'kayttajannimi' => $row['kayttajannimi'],
				'salasana' => $row['salasana'],
			));
		}

		return $kayttajat;
	}

	public static function find($kayttajaid){
		//Alustetaan kysely
		$query=DB::connection()->prepare('SELECT * FROM Kayttaja
		WHERE kayttajaid = :kayttajaid LIMIT 1');

		$query->execute(array('kayttajaid' => $kayttajaid));
		$row = $query->fetch();

		if($row){
			$kayttaja = new User(array(
				'kayttajaid' => $row['kayttajaid'],
				'kayttajannimi' => $row['kayttajannimi'],
				'salasana' => $row['salasana'],
			));

			return $kayttaja;
		}

		return null;
	}
}