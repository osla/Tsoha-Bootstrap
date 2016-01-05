<?php

class Kysymys extends BaseModel{
	//atribuutit
	public $kysymysid, $kuvaus, $vastausluokka, $kyselyid, $luokannimi;
	//konstruktori
	public function _construct($attributes){
		parent::_construct($attributes);
	}

	public static function all($kyselyid){
		//Alustetaan kysely tietokantayhteydellä
		$query=DB::connection()->prepare('SELECT Kysymyslista.kyselyid, Kysymys.kysymysid, 
		Kysymys.kuvaus, Kysymys.vastausluokka, Org_luokka.luokannimi
		FROM Kysymyslista
		LEFT JOIN Org_luokka ON Kysymyslista.luokkaid = Org_luokka.luokkaid
		LEFT JOIN Kysymys ON Kysymyslista.kysymysid = Kysymys.kysymysid
		WHERE kyselyid = :kyselyid');
		//Suoritetaan kysely
		$query->execute(array('kyselyid' => $kyselyid));
		$rows = $query->fetchAll();

		$kysymykset = array();
		foreach ($rows as $row) {
			$kysymykset[] = new Kysymys(array(
				'kyselyid' => $row['kyselyid'],
				'kysymysid' => $row['kysymysid'],
				'kuvaus' => $row['kuvaus'],
				'vastausluokka' => $row['vastausluokka'],
				'luokannimi' => $row['luokannimi']
			));
		}

		return $kysymykset;
	}

	public static function find($kysymysid){
		
		$query=DB::connection()->prepare('SELECT * FROM Kysymys WHERE kysymysid = :kysymysid LIMIT 1');
		$query->execute(array('kysymysid' => $kysymysid));
		$row = $query->fetch();

		if($row){
			$kysymys = new Kysymys(array(
				'kysymysid' => $row['kysymysid'],
				'kuvaus' => $row['kuvaus'],
				'vastausluokka' => $row['vastausluokka'],	
			));

			return $kysymys;
		}

		return null;
	}
}