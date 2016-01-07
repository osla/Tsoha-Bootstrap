<?php

class Kurssi extends BaseModel{
	//atribuutit
	public $kurssiid, $kurssinnimi, $laitoksennimi;
	//konstruktori
	public function _construct($attributes){
		parent::_construct($attributes);
	}

	public static function all(){
		//Alustetaan kysely tietokantayhteydellä		
		$query=DB::connection()->prepare('SELECT Kurssi.kurssiid, Kurssi.kurssinnimi, 
		Laitos.laitoksennimi
		FROM Kurssi
		LEFT JOIN Laitos ON Kurssi.laitosid = Laitos.laitosid');
		//Suoritetaan kysely
		$query->execute();
		$rows = $query->fetchAll();
		$kurssit = array();

		foreach ($rows as $row) {
			$kurssit[] = new Kurssi(array(
				'kurssiid' => $row['kurssiid'],
				'kurssinnimi' => $row['kurssinnimi'],
				'laitoksennimi' => $row['laitoksennimi']
			));
		}

		return $kurssit;
	}

	public static function find($kurssiid){
		
		$query=DB::connection()->prepare('SELECT Kurssi.kurssiid, Kurssi.kurssinnimi, 
		Laitos.laitoksennimi
		FROM Kurssi
		LEFT JOIN Laitos ON Kurssi.laitosid = Laitos.laitosid
		WHERE kurssiid = :kurssiid LIMIT 1');
		$query->execute(array('kurssiid' => $kurssiid));
		$row = $query->fetch();

		if($row){
			$kurssi = new Kurssi(array(
				'kurssiid' => $row['kurssiid'],
				'kurssinnimi' => $row['kurssinnimi'],
				'laitoksennimi' => $row['laitoksennimi']	
			));

			return $kurssi;
		}

		return null;
	}
}