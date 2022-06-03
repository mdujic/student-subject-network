<?php

//namespace Ispitomat;

use GraphAware\Neo4j\OGM\Annotations as OGM;
use GraphAware\Neo4j\OGM\Common\Collection;

/**
 *
 * @OGM\Node(label="Subject")
 */
class Student{
    protected $JMBAG;
    protected $ime, $prezime; 
    protected $spol, $OIB;
    protected $datum_rodenja;
    protected $email;
    
    public function __construct($JMBAG, $ime, $prezime, $OIB, $spol, $datum_rodenja, $email){
        $this -> JMBAG = $JMBAG;
        $this -> ime = $ime;
        $this -> prezime = $prezime;   
        $this -> OIB = $OIB;
        $this -> spol = $spol;
        $this -> email = $email;
        $this -> datum_rodenja = $datum_rodenja;   
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
