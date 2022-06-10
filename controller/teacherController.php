<?php

class TeacherController extends BaseController
{
	public function index(){
        $ser = new Service();
		$this->registry->template->title = "Popis svih profesora";
		$this->registry->template->teachers = $ser->getAllTeachers();

		$this->registry->template->show( 'teacher_index' );
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