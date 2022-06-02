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

    protected $students;

    protected $teachers;
    
    protected $status;



    public function __construct($subjectID= "", $subjectName= "", $description="", $semester="", $students = new Collection(), $teacher = new Collection(), $status="open")
    {
        $this->subjectID = $subjectID;
        $this->subjectName = $subjectName;
        $this->semester = $semester;
        $this->students = $students;
        $this->teacher = $teacher;
        $this->description = $description;
        $this->status = $status;
    }

    function __get($prop) { return $this->$prop; }
    function __set($prop, $val) { $this->$prop = $val; return $this; }
}

?>
