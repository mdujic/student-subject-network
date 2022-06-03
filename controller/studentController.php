<?php

require_once "model/service.class.php";

class SubjectController
{
	public function index(){
        $ser = new Service();
        $title = "Popis svih studenata";
        $studenti = $ser -> getAllStudents();
		require_once __DIR__ . '/../view/student_index.php';
    }

	public function showStudent() {
        $ser = new Service();
		if(isset($_GET['id_subject'])){
			$student = $ser -> getStudentById($_GET['id_student']);
            $predmeti = $ser -> getMySubjects($_GET['id_student']);
            
			require_once __DIR__ . '/../view/one_student.php';
		}else{
			$this->index();
		}
	}

}

?>