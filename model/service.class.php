<?php

class Service 
{


	function getAllSubjects()
	{
		try
		{
            $em = DB::getConnection();
			$query = $em->createQuery("MATCH (s:Subject) RETURN s");
			$result = $query->execute()[0];
		}
		catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }

		$arr = null;
		foreach($result as $node) {
            $arr[] = new Subject($node["ISVUsifra"], $node["imePredmeta"], "", $node["semestar"], "",
            $node["godina"], $node["obavezni"]); 
        }

		return $stud;
	}
    

    function getSubjectById( $id )
	{
		try
		{
			$m = new MongoClient();
            $db = $m->nbp;
            $subject = $db->subject;
            $query = array(
                "subjectID" => $id
            );
            $cursor = $subject->find($query);
		}
		catch( Exception $e ) { exit( 'PDO error ' . $e->getMessage() ); }
        $sub = null;
		foreach($cursor as $document) {
            $sub = new Subject($document['subjectID'], $document['subjectName'], $document['description'], $document['semester'], $document['status'], $document['godina'], $document['obavezni']);
        }

		return $sub;
	}

	function getStudentById( $jmbag_student )
	{
		try
		{
            $em = DB::getConnection();
			$query = $em->createQuery("MATCH (stud:Student) WHERE stud.jmbag={studentJMBAG} RETURN stud");
			$query->setParameter("studentJMBAG", $jmbag_student);
			$result = $query->execute()[0];
		}
		catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }

		$stud = null;
		foreach($result as $node) {
            $stud = new Student($node["jmbag"], $node["ime"], $node["prezime"], $node["oib"], $node["spol"],
            $node["datumRođenja"], $node["aai"]); 
        }

		return $stud;
	}

    function getStudentsOfSubject( $subjectId )
	{

		try
		{
            $em = DB::getConnection();
			$query = $em->createQuery("MATCH (s:Subject)--(stud:Student) WHERE s.ISVUsifra={subjectId} RETURN stud");
			$query->setParameter("subjectId", $subjectId);
			$result = $query->execute()[0];
		}
		catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }

		$arr = array();
		foreach($result as $node) {
            $arr[] = new Student($node["jmbag"], $node["ime"], $node["prezime"], $node["oib"], $node["spol"],
            $node["datumRođenja"], $node["aai"]); 
        }

		return $arr;
	}

	function getMySubjects( $jmbag_student )
	{

		try
		{
            $em = DB::getConnection();
			$query = $em->createQuery("MATCH (s:Subject)--(stud:Student) WHERE stud.jmbag={studentJMBAG} RETURN s");
			$query->setParameter("studentJMBAG", $jmbag_student);
			$result = $query->execute()[0];
		}
		catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }

		$arr = array();
		foreach($result as $node) {
            $arr[] = new Subject($node["ISVUsifra"], $node["imePredmeta"], "", $node["semestar"], "",
             $node["godina"], $node["obavezni"]); 
        }

		return $arr;
	}


	
};

?>

