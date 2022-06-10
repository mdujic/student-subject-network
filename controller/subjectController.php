<?php

class SubjectController extends BaseController
{
	public function index()
	{
        $ser = new Service();
        $this->registry->template->title = "Popis svih predmeta";
		$this->registry->template->subjectList = $ser->getAllSubjects();
		$this->registry->template->show( 'subject_index' );
	}

	public function showSubjectId() {
		$ser = new Service();
		if(isset($_GET['id_subject'])){
			$subject = $ser->getSubjectById($_GET['id_subject']);
			$this -> registry -> template -> title = $subject->subjectName;
            $students = $ser->getStudentsOfSubject($subject->subjectID);
            $this -> registry -> template -> students = $students;
            $this -> registry -> template -> subject = $subject;
			$this->registry->template->show( 'one_subject' );
		}else{
			$this->index();
		}
	}

	public function mySubjects(){
		$moj_jmbag = '1191242519';
		$predmet = '92978';
		$ser = new Service();
		$my_subjects = $ser -> getMySubjects($moj_jmbag);
			$this -> registry -> template -> predmeti = $my_subjects;
		$this -> registry -> template -> ime_i_prezime = $moj_jmbag;
		$preporuke = array();
		foreach($my_subjects as $subj){
			$best = $ser -> recommendMeSubject($moj_jmbag, $subj -> subjectID);
			$best = $best[0];
			$preporuke[] = $best;
		}
		$this -> registry -> template -> preporuka = $preporuke;
		$this -> registry -> template -> show( 'one_student' );
	}

}

?>