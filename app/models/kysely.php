<?php

class Kysely extends BaseModel{
	//atribuutit
	public $kyselyid, $kyselynnimi, $tekijaid, $kurssiid, $alkupvm, $loppupvm, $muokattu, $tila;
	//konstruktori
	public function _construct($attributes){
		parent::_construct($attributes);
	}

	public static function all(){
		//Alustetaan kysely tietokantayhteydellä
		$query=DB::connection()->prepare('SELECT * FROM Kysely');
		//Suoritetaan kysely
		$query->execute();
		$rows = $query->fetchAll();
		$kyselyt = array();

		foreach ($rows as $row) {
			$kyselyt[] = new Kysely(array(
				'kyselyid' => $row['kyselyid'],
				'kyselynnimi' => $row['kyselynnimi'],
				'tekijaid' => $row['tekijaid'],
				'kurssiid' => $row['kurssiid'],
				'alkupvm' => $row['alkupvm'],
				'loppupvm' => $row['loppupvm'],
				'muokattu' => $row['muokattu'],
				'tila' => $row['tila']
			));
		}

		return $kyselyt;
	}

	public static function find($kyselyid){
		$query=DB::connection()->prepare('SELECT * FROM Kysely WHERE kyselyid = :kyselyid LIMIT 1');
		$query->execute(array('kyselyid' => $kyselyid ));
		$row = $query->fetch();

		if($row){
			$kysely[] = new Kysely(array(
				'kyselyid' => $row['kyselyid'],
				'kyselynnimi' => $row['kyselynnimi'],
				'tekijaid' => $row['tekijaid'],
				'kurssiid' => $row['kurssiid'],
				'alkupvm' => $row['alkupvm'],
				'loppupvm' => $row['loppupvm'],
				'muokattu' => $row['muokattu'],
				'tila' => $row['tila']	
			));
			return $kysely;
		}

		return null;
	}
}