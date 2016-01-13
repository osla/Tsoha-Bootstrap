<?php

class User extends BaseModel {

//Atribuutit
	public $id, $nimi, $sposti, $salasana;

	public function __construct($attributes) {
		parent::__construct($attributes);
		$this->validators = array('validate_name');
	}

	public static function all() {
		$query = DB::connection()->prepare('SELECT * FROM Kayttaja');
		$query->execute();
		$rows = $query->fetchAll();
		$users = array();

		foreach ($rows as $row){
			$users[]=new User(array(
				'id' => $row['kayttajaid'],
				'nimi' => $row['kayttajannimi'],
				'sposti' => $row['kayttajansposti'],
				'salasana' => $row['salasana'],
			));
		}
		return $users;
	}

	public static find($id){
		$query= DB::connection()->prepare('SELECT * FROM Kayttaja WHERE kayttajaid=:$id LIMIT 1');
		$query->execute(array('kayttajaid') => $id));
		$row =$query->fetch();

		if ($row) {
			$user = new User(array(
				'id' => $row['kayttajaid'],
				'nimi' => $row['kayttajannimi'],
				'sposti' => $row['kayttajansposti'],
				'salasana' => $row['salasana'],
			));

			return $user;
		}
	}

	public function authenticate($kayttajansposti, $salasana){
		$query = DB::connection()->prepare('SELECT * FROM Kayttaja WHERE kayttajansposti =:kayttajansposti AND salasana =:salasana');
		$query->execute(array('kayttajansposti'=>$kayttajansposti, 'salasana' => $salasana));
		$row = $query->fetch();
		Kint::dump($row);
		if($row){
			$user = new User(array(
				'id' => $row['kayttajaid'],
				'kayttajansposti' => $row['kayttajannimi'],
				'sposti' => $row['kayttajansposti'],
				'salasana' => $row['salasana'],
			));
			return $user
		} else {
			return null;
		}
	}

	public function save() {
		$query =DB::connection()->prepare('INSERT INTO Kayttaja (kayttajannimi, kayttajansposti,
		 salasana) VALUES (:kayttajannimi, :kayttajansposti, :salasana) RETURNING kayttajaid');
		$query->execute(array('kayttajannimi' => $this->kayttajannimi, 'kayttajansposti' => $this->kayttajansposti,
		 'salasana' => $this->salasana));
		$row = $query->fetch();
		$this->kayttajaid = $row['kayttajaid'];
	}
}