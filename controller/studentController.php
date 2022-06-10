<?php

class StudentController extends BaseController
{
	public function index(){
        $ser = new Service();
		$this->registry->template->title = "Popis svih studenata";
		$this->registry->template->studenti = $ser->getAllStudents();

		$this->registry->template->show( 'student_index' );
    }

	public function showStudentId() {
		$ser = new Service();
		if(isset($_GET['id_student'])){
			$moj_jmbag = $_GET['id_student'];
			$my_subjects = $ser -> getMySubjects($moj_jmbag);
			$this -> registry -> template -> predmeti = $my_subjects;
			$this -> registry -> template -> ime_i_prezime = $moj_jmbag;
			$this -> registry -> template -> student = $ser -> getStudentById($moj_jmbag);
			$preporuke = array();
			foreach($my_subjects as $subj){
				$best = $ser -> recommendMeSubject($moj_jmbag, $subj -> subjectID);
				$best = $best[0];
				$preporuke[] = $best;
			}
			$this -> registry -> template -> preporuka = $preporuke;
			$this -> registry -> template -> show( 'one_student' );
		}else{
			$this->index();

		}
	}

}

?>