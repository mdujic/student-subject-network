<?php


class Teacher{
    protected $ime, $prezime; 
    protected $spol, $OIB;
    protected $email;
    
    public function __construct($ime, $prezime, $OIB, $spol, $email){
        $this -> ime = $ime;
        $this -> prezime = $prezime;   
        $this -> OIB = $OIB;
        $this -> spol = $spol;
        $this -> email = $email;
    }

    function __get($prop){
        return $this->$prop; 
    }

    function __set($prop, $val){
        $this -> $prop = $val;
        return $this;
    }
}


?>
