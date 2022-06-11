<?php

class TeacherController extends BaseController
{
	public function index(){
		if ( isset($_POST['ime']) && $_SESSION['username'] === 'admin'){
			if ( !isset($_POST['ime']) ||
				!isset($_POST['prezime']) || 
				!isset($_POST['email']) || 
				!isset($_POST['oib']) || 
				!isset($_POST['spol']) ) {
				$this->registry->template->title = "Trebate popuniti svako polje";
				$this->registry->template->show( 'show_message' );
			} else {
				$ser = new Service();
				// TODO: add regex to check each value
				if ($ser->createTeacher($_POST['ime'], $_POST['prezime'], $_POST['email'], $_POST['oib'], $_POST['spol'])){
					$this->registry->template->title = "Uspiješno dodavanje profesora";
					$this->registry->template->show( 'show_message' );
				}else {
					$this->registry->template->title = "Neuspiješno dodavanje profesora";
					$this->registry->template->show( 'show_message' );
				}
			}
		} else {
			$ser = new Service();
			$this->registry->template->title = "Popis svih profesora";
			$this->registry->template->teachers = $ser->getAllTeachers();

			$this->registry->template->show( 'teacher_index' );
		}
        
    }

	public function showTeacherId() {
		$ser = new Service();
		if(isset($_GET['id_teacher'])){
			$teacher = $ser->getTeacherById($_GET['id_teacher']);
			$this -> registry -> template -> teacher = $teacher;
            $this -> registry -> template -> predmeti = $ser->getSubjectsOfTeacher($teacher->OIB);
			print($predmeti[0]->title);
			$this->registry->template->show( 'one_teacher' );
		}else{
			$this->index();
		}
	}

}

?>