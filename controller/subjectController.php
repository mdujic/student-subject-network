<?php

class SubjectController extends BaseController
{
	public function index()
	{
		if ( isset($_POST['naziv']) && $_SESSION['username'] === 'admin'){
			if ( !isset($_POST['naziv']) ||
				!isset($_POST['opis']) || 
				!isset($_POST['ISVUsifra']) || 
				!isset($_POST['semestar']) || 
				!isset($_POST['obavezni']) || 
				!isset($_POST['status']) || 
				!isset($_POST['godina']) ) {
				$this->registry->template->title = "Trebate popuniti svako polje";
				$this->registry->template->show( 'show_message' );
			} else {
				$ser = new Service();
				// TODO: add regex to check each value
				if ($ser->createSubject($_POST['naziv'], $_POST['opis'], (int)$_POST['ISVUsifra'], $_POST['semestar'], $_POST['obavezni'], $_POST['status'], (int)$_POST['godina'])){
					$this->registry->template->title = "Uspiješno kreiranje predmeta";
					$this->registry->template->show( 'show_message' );
				}else {
					$this->registry->template->title = "Neuspiješno kreiranje predmeta";
					$this->registry->template->show( 'show_message' );
				}
			}
		} else {
			$ser = new Service();
			$this->registry->template->title = "Popis svih predmeta";
			$this->registry->template->subjectList = $ser->getAllSubjects();
			$this->registry->template->show( 'subject_index' );
		}
        
	}

	public function showSubjectId() {
		$ser = new Service();
		if(isset($_GET['id_subject'])){
			$subject = $ser->getSubjectById($_GET['id_subject']);
			echo "tu sam doso i";
			echo $subject->subjectName;
			echo "naziv premetea";
			$this -> registry -> template -> title = $subject->subjectName;
            $students = $ser->getStudentsOfSubject($subject->subjectID);
            $this -> registry -> template -> students = $students;
            $this -> registry -> template -> subject = $subject;
            $input = $subject -> subjectID;
            //echo 'pokrecem ' . 'python3 tdfprep.py ' . $input;
            //$command = escapeshellcmd('tdfprep.py ' . $input);
            $mycom = exec('python3 ' . __DIR__ . '/tdfprep.py ' . $input);
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


}

?>