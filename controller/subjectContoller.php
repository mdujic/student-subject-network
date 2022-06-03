<?php

require_once "model/service.class.php";

class SubjectController
{
	public function index()
	{
        $ser = new Service();
        $title = "Popis svih predmeta";
        $popisPredmeta = $ser->getAllSubjects();
		require_once __DIR__ . '/../view/subject_index.php';
	}

	public function showSubjectId() {
		$ser = new Service();
		if(isset($_GET['id_subject'])){
			$subject = $ser->getSubjectById($_GET['id_project']);
			$title = $subject->subjectName;
            $students = $ser->getStudentsOfSubject($subject->subjectID);

			foreach($students as $student){
				$student->id = $ser->getStudentById($student->id)->name;
			}
            
			require_once __DIR__ . '/../view/one_subject.php';
		}else{
			$this->index();
		}
	}

}

?>