<?php

namespace Ispitomat;

use GraphAware\Neo4j\OGM\Annotations as OGM;
use GraphAware\Neo4j\OGM\Common\Collection;

/**
 *
 * @OGM\Node(label="Subject")
 */
class Subject
{
    protected $subjectID;
	protected $subjectName;
    protected $description;
	protected $semester;
    protected $status;
    protected $godina, $obavezni;

    public function __construct($subjectID= "", $subjectName= "", $description="", $semester="", $status="open", $godina = "", $obavezni = "")
    {
        $this->subjectID = $subjectID;
        $this->subjectName = $subjectName;
        $this->semester = $semester;
        $this->students = $students;
        $this->teacher = $teacher;
        $this->description = $description;
        $this->status = $status;
        $this->godina = $godina;
        $this->godina = $obavezni;
    }

    function __get($prop) { return $this->$prop; }
    function __set($prop, $val) { $this->$prop = $val; return $this; }
}

?>
