<?php

class SubjectController extends BaseController
{
	public function index(){
        $ser = new Service();
        $title = "Popis svih studenata";
        $studenti = $ser -> getAllStudents();
    }

	public function showStudent() {
        $ser = new Service();
		if(isset($_GET['id_subject'])){
			$student = $ser -> getStudentById($_GET['id_student']);
            $predmeti = $ser -> getMySubjects($_GET['id_student']);
            
		}else{
			$this->index();
		}
	}

}

?>