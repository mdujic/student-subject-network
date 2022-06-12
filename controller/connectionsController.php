<?php

class ConnectionsController extends BaseController{
	public function index(){
		if(!isset($_SESSION['username']) || $_SESSION['username'] !== 'admin'){
			header( 'Location: ' . __SITE_URL . '/index.php?rt=subject');
			return;
		}

		$this -> registry -> template -> show('upisi_forma');
	}

	public function teacherToSubject(){
		if(!isset($_POST['oib_profesora']) || !isset($_POST['isvu_kolegija'])){
			$this -> registry -> template -> tcolor = "red";
			$this -> registry -> template -> message = 'Neispravan unos!';
			$this -> registry -> template -> show('upisi_forma');
			return;
		}

		$ser = new Service();
		$prof = $ser -> getTeacherById($_POST['oib_profesora']);
		if($prof == null){
			$this -> registry -> template -> tcolor = "red";
			$this -> registry -> template -> message = 'Profesor s ovim OIB-om ne postoji u bazi!';
			$this -> registry -> template -> show('upisi_forma');
			return;	
		}

		$sub = $ser -> getSubjectById($_POST['isvu_kolegija']);
		if($sub == null){
			$this -> registry -> template -> tcolor = "red";
			$this -> registry -> template -> message = 'Kolegij s ovim ISVU-om ne postoji u bazi!';
			$this -> registry -> template -> show('upisi_forma');
			return;		
		}

		if(!$ser -> signTeacherToSubject($prof -> OIB, $sub -> subjectID)){
			$this -> registry -> template -> tcolor = "red";
			$this -> registry -> template -> message = 'Neuspjeli upis. Problem s bazom (Neo)';
			$this -> registry -> template -> show('upisi_forma');
		}else{
			$this -> registry -> template -> tcolor = "green";
			$this -> registry -> template -> message = 'Uspješan upis!';
			$this -> registry -> template -> show('upisi_forma');	
		}
	}

	public function studentToSubject(){
		if(!isset($_POST['jmbag_studenta']) || !isset($_POST['isvu_kolegija'])){
			$this -> registry -> template -> tcolor = "red";
			$this -> registry -> template -> message2 = 'Neispravan unos!';
			$this -> registry -> template -> show('upisi_forma');
			return;
		}

		$ser = new Service();
		$stud = $ser -> getStudentById($_POST['jmbag_studenta']);
		if($stud == null){
			$this -> registry -> template -> tcolor = "red";
			$this -> registry -> template -> message2 = 'Student s ovim JMBAG-om ne postoji u bazi!';
			$this -> registry -> template -> show('upisi_forma');
			return;	
		}

		$sub = $ser -> getSubjectById($_POST['isvu_kolegija']);
		if($sub == null){
			$this -> registry -> template -> tcolor = "red";
			$this -> registry -> template -> message2 = 'Kolegij s ovim ISVU-om ne postoji u bazi!';
			$this -> registry -> template -> show('upisi_forma');
			return;		
		}

		if(!$ser -> signStudentToSubject($stud -> JMBAG, $sub -> subjectID)){
			$this -> registry -> template -> tcolor = "red";
			$this -> registry -> template -> message2 = 'Neuspjeli upis. Problem s bazom (Neo)';
			$this -> registry -> template -> show('upisi_forma');
		}else{
			$this -> registry -> template -> tcolor = "green";
			$this -> registry -> template -> message2 = 'Uspješan upis!';
			$this -> registry -> template -> show('upisi_forma');	
		}
	}

	


}

?>