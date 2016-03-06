<?php

class Kysely extends BaseModel{
	//atribuutit
	public $kyselyid, $kyselynnimi, $kurssiid, $alkupvm, $loppupvm, $tila, $kayttajannimi, $kurssinnimi, $kayttajaid;
	//konstruktori
	public function __construct($attributes){
		parent::__construct($attributes);
		$this->validators = array('validate_name', 'validate_date');
	}

	public static function all(){
		//Alustetaan kysely tietokantayhteydellä
		$query=DB::connection()->prepare('SELECT Kysely.kyselyid, Kysely.kyselynnimi, Kysely.kurssiid,
		Kysely.alkupvm, Kysely.loppupvm, Kysely.tila, Kayttaja.kayttajannimi, Kayttaja.kayttajaid, Kurssi.kurssinnimi
		FROM Kysely
		LEFT JOIN Kyselylista ON Kysely.kyselyid = Kyselylista.kyselyid
		LEFT JOIN Kayttaja ON Kyselylista.kayttajaid = Kayttaja.kayttajaid
		LEFT JOIN Kurssi ON Kysely.kurssiid = Kurssi.kurssiid');

		//Suoritetaan kysely
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
				'tila' => $row['tila'],
				'kayttajaid' => $row['kayttajaid'],
				'kayttajannimi' => $row['kayttajannimi'],
				'kurssinnimi' => $row['kurssinnimi']
			));
		}

		return $kyselyt;
	}

	public static function allForKayttaja($id){
		//Alustetaan kysely tietokantayhteydellä
		$query=DB::connection()->prepare('SELECT Kysely.kyselyid, Kysely.kyselynnimi, Kysely.kurssiid,
		Kysely.alkupvm, Kysely.loppupvm, Kysely.tila, Kayttaja.kayttajannimi, Kayttaja.kayttajaid, Kurssi.kurssinnimi
		FROM Kysely 
		LEFT JOIN Kyselylista ON Kysely.kyselyid = Kyselylista.kyselyid
		LEFT JOIN Kayttaja ON Kyselylista.kayttajaid = Kayttaja.kayttajaid
		LEFT JOIN Kurssi ON Kysely.kurssiid = Kurssi.kurssiid
		WHERE Kyselylista.kayttajaid = :kayttajaid');

		//Suoritetaan kysely
		$query->execute(array('kayttajaid' => $id));
		$rows = $query->fetchAll();
		$kyselyt = array();

		foreach ($rows as $row) {
			$kyselyt[] = new Kysely(array(
				'kyselyid' => $row['kyselyid'],
				'kyselynnimi' => $row['kyselynnimi'],
				'kurssiid' => $row['kurssiid'],
				'alkupvm' => $row['alkupvm'],
				'loppupvm' => $row['loppupvm'],
				'tila' => $row['tila'],
				'kayttajaid' => $row['kayttajaid'],
				'kayttajannimi' => $row['kayttajannimi'],
				'kurssinnimi' => $row['kurssinnimi']
			));
		}

		return $kyselyt;
	}


	public static function find($kyselyid){
		//$query=DB::connection()->prepare('SELECT * FROM Kysely WHERE kyselyid = :kyselyid LIMIT 1');
		$query=DB::connection()->prepare('SELECT Kysely.kyselyid, Kysely.kyselynnimi, Kysely.kurssiid,
		Kysely.alkupvm, Kysely.loppupvm, Kysely.tila, Kayttaja.kayttajannimi, Kayttaja.kayttajaid, 
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
				'tila' => $row['tila'],
				'kayttajaid' => $row['kayttajaid'],
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
		
		$this->kyselyid = $row['kyselyid'];

		$query = DB::connection()->prepare('INSERT INTO Kyselylista (kayttajaid, kyselyid)
			VALUES (:kayttajaid, :kyselyid)');
		$query->execute(array('kayttajaid' => $this->kayttajaid, 'kyselyid' => $this->kyselyid));

	}

	public function update(){

		$query = DB::connection()->prepare('UPDATE Kysely SET kyselynnimi=:kyselynnimi, kurssiid=:kurssiid, alkupvm=:alkupvm, loppupvm=:loppupvm, tila=:tila
			WHERE kyselyid=:kyselyid'); 
		
		$query->execute(array('kyselyid' => $this->kyselyid, 'kyselynnimi' => $this->kyselynnimi, 'kurssiid' => $this->kurssiid, 'alkupvm' => $this->alkupvm, 'loppupvm' => $this->loppupvm, 'tila' => $this->tila));
		$row = $query->fetch();

		//Kint::dump($row);

	}

	public function destroy(){

		$query = DB::connection()->prepare('DELETE FROM Kysely WHERE kyselyid = :kyselyid');
		$query->execute(array('kyselyid' => $this->kyselyid));

	}

}