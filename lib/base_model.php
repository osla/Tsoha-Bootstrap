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
          $errors[] = $error;
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
        $errors[]='Nimen pituuden tulee olla vähintään kolme merkkiä!';
      }

      return $errors;
    }  
  }

