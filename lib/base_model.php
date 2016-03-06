<?php

  class BaseModel{
    // "protected"-attribuutti on käytössä vain luokan ja sen perivien luokkien sisällä
    protected $validators;

    public function __construct($attributes = null){
      // Käydään assosiaatiolistan avaimet läpi
      foreach($attributes as $attribute => $value){
        // Jos avaimen niminen attribuutti on olemassa...
        if(property_exists($this, $attribute)){
          // ... lisätään avaimen nimiseen attribuuttin siihen liittyvä arvo
          $this->{$attribute} = $value;
        }
      }
    }

    public function errors(){
      // Lisätään $errors muuttujaan kaikki virheilmoitukset taulukkona
      $errors = array();

      foreach ($this->validators as $validator){
        // Kutsu validointimetodia tässä ja lisää sen palauttamat virheet errors-taulukkoon
        $error = $this->{$validator}();
        if ($error != null) {
          $errors = array_merge($errors, $error);
        }
      }
      return $errors;
    }

    public function validate_string_lenght($string, $length){
      if (strlen($string) < $lenght) {
          return 'Nimen tulee olla vähintään' + $lenght + 'merkkiä pitkä!';
        # code...
      }
    }

    public function validate_name(){
      $errors = array();
      if($this->kyselynnimi == '' || $this->kyselynnimi == null){
        $errors[]='Kyselyn nimi ei saa olla tyhjä!';
      }

      if(strlen($this->kyselynnimi) < 3){
        $errors[]='Nimen pituuden tulee olla vähintään 3 ja enintään 50 merkkiä!';
      }

      if(strlen($this->kyselynnimi) > 50){
        $errors[]='Nimen pituuden tulee olla vähintään 3 ja enintään 50 merkkiä!';
      }

      return $errors;
    } 


    public function validate_date(){
      //$malli = '/^(0[1-9]|[12][0-9]|3[01])[\-\/.](0[1-9]|1[012])[\-\/.](19|20)\d\d$/';
      $malli = '/^(19|20)\d\d[\-\/.](0[1-9]|1[012])[\-\/.](0[1-9]|[12][0-9]|3[01])$/';
      $errors = array();
      if (!preg_match($malli, $this->alkupvm)) {
        $errors[]='Alkupäivämäärän tulee olla muodossa vvvv-kk-pp';
      }
      if (!preg_match($malli, $this->loppupvm)) {
        $errors[]='Loppupäivämäärän tulee olla muodossa vvvv-kk-pp';
      }

      return $errors;

    }

    public function validate_id(){
      $errors = array();
      $id = User::find($this->kayttajaid);
      if($id) {
        $errors[]='Käyttäjätunnus on jo olemassa!';
      }
      return $errors;
    }

    public function validate_username(){
      $errors = array();
      if($this->kayttajannimi == '' || $this->kayttajannimi == null){
        $errors[]='Kayttajan nimi ei saa olla tyhjä!';
      }

      if(strlen($this->kayttajannimi) < 3){
        $errors[]='Nimen pituuden tulee olla vähintään 3 ja enintään 50 merkkiä!';
      }

      if(strlen($this->kayttajannimi) > 50){
        $errors[]='Nimen pituuden tulee olla vähintään 3 ja enintään 50 merkkiä!';
      }

      return $errors;
    } 

    public function validate_userid(){
      $errors = array();
      if($this->kayttajaid == '' || $this->kayttajaid == null){
        $errors[]='Kayttajatunnus ei saa olla tyhjä!';
      }

      if(strlen($this->kayttajaid) < 3){
        $errors[]='Kayttajatunnuksen pituuden tulee olla vähintään 3 ja enintään 50 merkkiä!';
      }

      if(strlen($this->kayttajaid) > 50){
        $errors[]='Kayttajatunnuksen pituuden tulee olla vähintään 3 ja enintään 50 merkkiä!';
      }

      return $errors;
    }

    public function validate_password(){
      $errors = array();
      if(!preg_match('/^(?=.*\d)(?=.*[A-Za-z])[0-9A-Za-z!@#$%]{5,15}$/', $this->salasana)){
        $errors[]='Salasana ei kelpaa. Anna uusi salasana joka on 5-15 merkkiä, jossa on ainakin yksi numero ja kirjain';
      }

      return $errors;
    }  

  }

