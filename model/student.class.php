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


    public function __construct($JMBAG, $ime, $prezime){
        $this -> JMBAG = $JMBAG;
        $this -> ime = $ime;
        $this -> prezime = $prezime;   
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
