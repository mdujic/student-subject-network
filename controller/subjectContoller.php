<?php
/*

class SubjectController
{
	public function index()
	{
        $ser = new Service();
        $title = "Popis svih predmeta";
        $popisPredmeta = $ser->getAllSubjects();
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
            
		}else{
			$this->index();
		}
	}

}
*/
?>