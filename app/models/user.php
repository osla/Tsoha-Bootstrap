<?php

class User extends BaseModel {

//Atribuutit
	public $kayttajaid, $kayttajannimi, $salasana, $admin;

	public function __construct($attributes) {
		parent::__construct($attributes);
		$this->validators = array('validate_id', 'validate_username', 'validate_userid', 'validate_password');
	}



	public static function all() {
		$query = DB::connection()->prepare('SELECT * FROM Kayttaja');
		$query->execute();
		$rows = $query->fetchAll();
		$users = array();

		foreach ($rows as $row){
			$users[]=new User(array(
				'kayttajaid' => $row['kayttajaid'],
				'kayttajannimi' => $row['kayttajannimi'],
				'salasana' => $row['salasana'],
				'admin' => $row['admin']
			));
		}
		return $users;
	}

	public static function find($kayttajaid){
		$query= DB::connection()->prepare('SELECT * FROM Kayttaja WHERE kayttajaid=:kayttajaid LIMIT 1');
		$query->execute(array('kayttajaid' => $kayttajaid));
		$row =$query->fetch();

		if ($row) {
			$user = new User(array(
				'kayttajaid' => $row['kayttajaid'],
				'kayttajannimi' => $row['kayttajannimi'],
				'salasana' => $row['salasana'],
				'admin' => $row['admin']
			));

			return $user;
		}
	}

	public function authenticate($kayttajaid, $salasana){
		$query = DB::connection()->prepare('SELECT * FROM Kayttaja WHERE kayttajaid=:kayttajaid AND salasana =:salasana LIMIT 1');
		$query->execute(array('kayttajaid' => $kayttajaid, 'salasana' => $salasana));
		$row = $query->fetch();
		//Kint::dump($row);
		if($row){
			$user = new User(array(
				'kayttajaid' => $row['kayttajaid'],
				'kayttajannimi' => $row['kayttajannimi'],
				'salasana' => $row['salasana'],
				'admin' => $row['admin']
			));
			return $user;
		} else {
			return null;
		}
	}

	public function save() {
		$query =DB::connection()->prepare('INSERT INTO Kayttaja (kayttajaid, kayttajannimi, 
		 salasana) VALUES (:kayttajaid, :kayttajannimi, :salasana) RETURNING kayttajaid');
		$query->execute(array('kayttajaid' => $this->kayttajaid, 'kayttajannimi' => $this->kayttajannimi,
		 'salasana' => $this->salasana));
		$row = $query->fetch();
		$this->kayttajaid = $row['kayttajaid'];
	}

	public function admin($kayttajaid) {
		$query = DB::connection()->prepare('SELECT * FROM Kayttaja WHERE kayttajaid=:kayttajaid LIMIT 1');
		$query->execute(array('kayttajaid' => $kayttajaid));
		$row = $query->fetch();
		if($row){
			$user = new User(array(
				'kayttajaid' => $row['kayttajaid'],
				'kayttajannimi' => $row['kayttajannimi'],
				'salasana' => $row['salasana'],
				'admin' => $row['admin']
			));
			return $user;
		} else {
			return null;
		}
	}

	public function destroy(){
		$query = DB::connection()->prepare('DELETE FROM Kayttaja WHERE kayttajaid = :kayttajaid');
		$query->execute(array('kayttajaid' => $this->kayttajaid));

	}

	public function getId(){
		return $this->kayttajaid;
	}

	public function setAdmin(){
	}
}