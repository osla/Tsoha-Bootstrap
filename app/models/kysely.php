<?php

class Kysely extends BaseModel{
	//atribuutit
	public $kyselyid, $kyselynnimi, $tekijaid, $kurssiid, $alkupvm, $loppupvm, $muokattu, $tila, $kayttajannimi, $kurssinnimi;
	//konstruktori
	public function _construct($attributes){
		parent::_construct($attributes);
	}

	public static function all(){
		//Alustetaan kysely tietokantayhteydellä
		//$query=DB::connection()->prepare('SELECT * FROM Kysely');
		//Suoritetaan kysely
		$query=DB::connection()->prepare('SELECT Kysely.kyselyid, Kysely.kyselynnimi, Kysely.tekijaid, Kysely.kurssiid,
		Kysely.alkupvm, Kysely.loppupvm, Kysely.muokattu, Kysely.tila, Kayttaja.kayttajannimi, Kurssi.kurssinnimi
		FROM Kysely
		LEFT JOIN Kayttaja ON Kysely.tekijaid = Kayttaja.kayttajaid
		LEFT JOIN Kurssi ON Kysely.kurssiid = Kurssi.kurssiid');

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
				'tila' => $row['tila'],
				'kayttajannimi' => $row['kayttajannimi'],
				'kurssinnimi' => $row['kurssinnimi']
			));
		}

		return $kyselyt;
	}

	public static function find($kyselyid){
		//$query=DB::connection()->prepare('SELECT * FROM Kysely WHERE kyselyid = :kyselyid LIMIT 1');
		$query=DB::connection()->prepare('SELECT Kysely.kyselyid, Kysely.kyselynnimi, Kysely.tekijaid, Kysely.kurssiid,
		Kysely.alkupvm, Kysely.loppupvm, Kysely.muokattu, Kysely.tila, Kayttaja.kayttajannimi, Kurssi.kurssinnimi
		FROM Kysely
		LEFT JOIN Kayttaja ON Kysely.tekijaid = Kayttaja.kayttajaid
		LEFT JOIN Kurssi ON Kysely.kurssiid = Kurssi.kurssiid
		WHERE kyselyid = :kyselyid LIMIT 1');

		$query->execute(array('kyselyid' => $kyselyid));
		$row = $query->fetch();

		if($row){
			$kysely = new Kysely(array(
				'kyselyid' => $row['kyselyid'],
				'kyselynnimi' => $row['kyselynnimi'],
				'tekijaid' => $row['tekijaid'],
				'kurssiid' => $row['kurssiid'],
				'alkupvm' => $row['alkupvm'],
				'loppupvm' => $row['loppupvm'],
				'muokattu' => $row['muokattu'],
				'tila' => $row['tila'],
				'kayttajannimi' => $row['kayttajannimi'],
				'kurssinnimi' => $row['kurssinnimi']	
			));

			return $kysely;
		}

		return null;
	}
}