<?php

class Kysely extends BaseModel{
	//atribuutit
	public $kyselyid, $kyselynnimi, $kurssiid, $alkupvm, $loppupvm, $muokattu, $tila, $kayttajannimi, $kurssinnimi;
	//konstruktori
	public function __construct($attributes){
		parent::__construct($attributes);
		$this->validators = array('validate_name');
	}

	public static function all(){
		//Alustetaan kysely tietokantayhteydellä
		//Esimerkkikysely $query=DB::connection()->prepare('SELECT * FROM Kysely');
		//Suoritetaan kysely
		$query=DB::connection()->prepare('SELECT Kysely.kyselyid, Kysely.kyselynnimi, Kysely.kurssiid,
		Kysely.alkupvm, Kysely.loppupvm, Kysely.muokattu, Kysely.tila, Kayttaja.kayttajannimi, Kurssi.kurssinnimi
		FROM Kysely
		LEFT JOIN Kyselylista ON Kysely.kyselyid = Kyselylista.kyselyid
		LEFT JOIN Kayttaja ON Kyselylista.kayttajaid = Kayttaja.kayttajaid
		LEFT JOIN Kurssi ON Kysely.kurssiid = Kurssi.kurssiid');

		$query->execute();
		$rows = $query->fetchAll();
		$kyselyt = array();

		foreach ($rows as $row) {
			$kyselyt[] = new Kysely(array(
				'kyselyid' => $row['kyselyid'],
				'kyselynnimi' => $row['kyselynnimi'],
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
		$query=DB::connection()->prepare('SELECT Kysely.kyselyid, Kysely.kyselynnimi, Kysely.kurssiid,
		Kysely.alkupvm, Kysely.loppupvm, Kysely.muokattu, Kysely.tila, Kayttaja.kayttajannimi, 
		Kurssi.kurssinnimi
		FROM Kysely
		LEFT JOIN Kyselylista ON Kysely.kyselyid = Kyselylista.kyselyid
		LEFT JOIN Kayttaja ON Kyselylista.kayttajaid = Kayttaja.kayttajaid
		LEFT JOIN Kurssi ON Kysely.kurssiid = Kurssi.kurssiid
		WHERE Kysely.kyselyid = :kyselyid LIMIT 1');

		$query->execute(array('kyselyid' => $kyselyid));
		$row = $query->fetch();

		if($row){
			$kysely = new Kysely(array(
				'kyselyid' => $row['kyselyid'],
				'kyselynnimi' => $row['kyselynnimi'],
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

	public function save(){

		$query = DB::connection()->prepare('INSERT INTO Kysely (kyselynnimi, kurssiid, alkupvm, loppupvm) 
			VALUES (:kyselynnimi, :kurssiid, :alkupvm, :loppupvm) RETURNING kyselyid');
		$query->execute(array('kyselynnimi' => $this->kyselynnimi, 'kurssiid' => $this->kurssiid,
			'alkupvm' => $this->alkupvm, 'loppupvm' => $this->loppupvm));
		$row = $query->fetch();
		//Kint::trace();
		//Kint::dump($row);

		$this->kyselyid = $row['kyselyid'];

		$query = DB::connection()->prepare('INSERT INTO Kyselylista (kyselyid, kurssi');
	}


}