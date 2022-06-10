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
            $input = $subject -> subjectID;
            //echo 'pokrecem ' . 'python3 tdfprep.py ' . $input;
            //$command = escapeshellcmd('tdfprep.py ' . $input);
            $mycom = exec('python3 /home/jurica/public_html/student-subject-network/controller/tdfprep.py ' . $input);
			//$output = exec('/usr/bin/env/python3 /home/jurica/kurac.py');
			//$output = exec('python3 /home/jurica/tdfprep.py');
			$polje = explode('/', $mycom); 
			//echo 'dobio sam ' . $polje[0] . ' ' . $polje[1];
			//return;
			$tdf_slicni = [];
			foreach($polje as $pp){
				$cur_subject = $ser -> getSubjectById($pp);
				$tdf_slicni[] = $cur_subject;
			}
            $this -> registry -> template -> similar_subjects = $tdf_slicni;
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