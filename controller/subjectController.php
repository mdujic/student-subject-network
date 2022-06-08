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
			$title = $subject->subjectName;
            $students = $ser->getStudentsOfSubject($subject->subjectID);
			$this->registry->template->show( 'one_subject' );
	
            
		}else{
			$this->index();
		}
	}

}

?>