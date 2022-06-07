<?php

class Service 
{


	function getAllSubjects()
	{
		try
		{
			$em = DB_NEO4J::getConnection();
			$query = $em->createQuery("MATCH (s:Subject) RETURN s");
			$result = $query->execute();
		}
		catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }
		
		$arr = null;
		foreach($result as $node) {
			$arr[] = new Subject($node['s']->value('ISVUsifra'), $node['s']->value('imePredmeta'), "", $node['s']->value('semestar'), "",
    		$node['s']->value('godina'), $node['s']->value('obavezni'));
        }

		return $arr;
	}
    

    function getSubjectById( $id )
	{
		try
		{
			$m = new MongoDB\Driver\Manager('mongodb://localhost:27017');
            $filter= array('subjectID'=>92978);
        $options = array('limit'=>1);
        $query = new MongoDB\Driver\Query($filter, $options);
        $cursor = $m->executeQuery('nbp.subject', $query);
        
		}
		catch( Exception $e ) { exit( 'PDO error ' . $e->getMessage() ); }
        $sub = null;
		foreach($cursor as $document) {
            $sub = new Subject($document->subjectID, $document->subjectName, $document->description, $document->semester, $document->status, "", "");
        }

		return $sub;
	}

	function getStudentById( $jmbag_student )
	{
		try
		{
            $em = DB_NEO4J::getConnection();
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
            $em = DB_NEO4J::getConnection();
			$query = $em->createQuery("MATCH (s:Subject)--(stud:Student) WHERE s.ISVUsifra={subjectId} RETURN stud");
			$query->setParameter("subjectId", strval($subjectId));
			$result = $query->execute();
		}
		catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }
		$arr = array();
		foreach($result as $node) {
            $arr[] = new Student($node['stud']->value('jmbag'), $node['stud']->value("ime"), $node['stud']->value("prezime"), $node['stud']->value("oib"), $node['stud']->value("spol"),
			$node['stud']->value("datumRođenja(MM/DD/GG)"), $node['stud']->value("aai"));
        }
		return $arr;
	}

	function getMySubjects( $jmbag_student )
	{

		try
		{
            $em = DB_NEO4J::getConnection();
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

