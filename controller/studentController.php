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

	public function insertStudent(){
		if(!isset($_POST['email']) || !isset($_POST['jmbag']) || !isset($_POST['ime']) || 
			!isset($_POST['prezime']) || !isset($_POST['oib']) || !isset($_POST['datum_rodenja']) ||
			!isset($_POST['mjesto_rodenja']) || !isset($_POST['spol'])){
				$this -> registry -> template -> tcolor = "red";
				$this -> registry -> template -> message = 'Neispravan unos!';
				$this -> registry -> template -> show('student_index');
				return;
		}

		$ser = new Service();
		$r = $ser -> createStudent($_POST['email'], $_POST['datum_rodenja'], $_POST['ime'], $_POST['jmbag'], 
			$_POST['mjesto_rodenja'], $_POST['oib'], $_POST['prezime'], $_POST['spol']);
		if($r == false){
			$this -> registry -> template -> tcolor = "red";
			$this -> registry -> template -> message = 'Unos nije uspio (Neo)!';
			$this -> registry -> template -> show('student_index');
		}else{
			$this -> registry -> template -> tcolor = "green";
			$this -> registry -> template -> message = 'Uspješan unos!';
			$this -> registry -> template -> title = "Popis svih studenata";
			$this -> registry -> template -> studenti = $ser->getAllStudents();
			$this -> registry -> template -> show('student_index');
		}
	}


}

?>