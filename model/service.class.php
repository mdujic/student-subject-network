<?php

class Service 
{
	//$_POST['ime'], $_POST['prezime'], $_POST['email'], $_POST['oib'], $_POST['spol']
	function createTeacher($ime, $prezime, $email, $oib, $spol){
		// Pisanje u neo4j
		try{
			$em = DB_NEO4J::getConnection();

			$query = $em->createQuery("CREATE (t:Teacher {aai: {teacherAAI}, ime: {teacherIme}, oib: {teacherOIB}
				, prezime: {teacherPrezime}, spol: {teacherSpol}})");

			$query->setParameter("teacherOIB", $oib);
			$query->setParameter("teacherIme", $ime);
			$query->setParameter("teacherPrezime", $prezime);
			$query->setParameter("teacherAAI", $email);
			$query->setParameter("teacherSpol", $spol);

			$result = $query->execute();
		} catch (Exception $e){
			return false;
		}
		return true;
	}

	function createStudent($aai, $datumRodenja, $ime, $jmbag, $mjesto_rodenja, $oib, $prezime, $spol){
		// Pisanje u neo4j
		try{
			$em = DB_NEO4J::getConnection();
			$query = $em -> createQuery("CREATE (s:Student {aai: {AAI}, datumRodenja: {datum}, ime: {ime}, 
			 jmbag: {jmbag}, mjestoRodenja: {mjesto}, oib: {oib}, prezime: {prezime}, spol: {spol}})");
			$query->setParameter("oib", $oib);
			$query->setParameter("ime", $ime);
			$query->setParameter("prezime", $prezime);
			$query->setParameter("AAI", $aai);
			$query->setParameter("spol", $spol);
			$query->setParameter("datum", $datumRodenja);
			$query->setParameter("mjesto", $mjesto_rodenja);
			$query->setParameter("jmbag", $jmbag);			
			$result = $query->execute();
		}catch (Exception $e){
			return false;
		}

		return true;
	}



	//$_POST['naziv'], $_POST['opis'], $_POST['ISVUsifra'], $_POST['semestar'], $_POST['obavezni'], $_POST['status'], $_POST['godina'])
	function createSubject($naziv, $opis, $ISVUsifra, $semestar, $obavezni, $status, $godina) {
		// Pisanje u neo4j
		try{
			$em = DB_NEO4J::getConnection();

			$query = $em->createQuery("CREATE (s:Subject {ISVUsifra: {subjectSifra}, godina: {subjectGodina}, imePredmeta: {subjectNaziv}
				, obavezni: {subjectObavezni}, semestar: {subjectSemestar}})");

			$query->setParameter("subjectSifra", strval($ISVUsifra));
			$query->setParameter("subjectGodina", $godina);
			$query->setParameter("subjectNaziv", $naziv);
			$query->setParameter("subjectObavezni", $obavezni);
			$query->setParameter("subjectSemestar", $semestar);

			$result = $query->execute();
		} catch (Exception $e){
			return false;
		}

		// Pisanje u mongo
		try{
			$m = DB_MONGO::getConnection();

			$bulk = new MongoDB\Driver\BulkWrite;
	
			$document = ['ISVUsifra' => $ISVUsifra,
						'imePredmeta' => $naziv,
						'semestar' => $semestar,
						'obavezni' => $obavezni,
						'godina' => $godina,
						'opis' => $opis,
						'status' => $status,
						];
				
			$_id1 = $bulk->insert($document);
	
			$result = $m->executeBulkWrite('nbp.subject', $bulk);
		} catch (Exception $e){
			return false;
		}
		return true;
	}


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

	function getAllStudents()
	{
		try
		{
			$em = DB_NEO4J::getConnection();
			$query = $em->createQuery("MATCH (s:Student) RETURN s");
			$result = $query->execute();
		}
		catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }
		
		$arr = null;
		foreach($result as $node) {
			$arr[] = new Student($node['s']->value('jmbag'), $node['s']->value('ime'), $node['s']->value('prezime'), $node['s']->value('oib'), $node['s']->value('spol'),
            $node['s']->value('datumRodenja'), $node['s']->value('aai'));
        }

		return $arr;
	}

	function getAllTeachers()
	{
		try
		{
			$em = DB_NEO4J::getConnection();
			$query = $em->createQuery("MATCH (s:Teacher) RETURN s");
			$result = $query->execute();
		}
		catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }
		
		$arr = null;
		foreach($result as $node) {
			$arr[] = new Teacher($node['s']->value('ime'), $node['s']->value('prezime'), $node['s']->value('oib'),
			 $node['s']->value('spol'), $node['s']->value('aai'));
        }

		return $arr;
	}
    

    function getSubjectById( $id )
	{
		try
		{
			$m = DB_MONGO::getConnection();
            $filter= array('ISVUsifra'=>(int)$id);
			$options = array('limit'=>1);
			$query = new MongoDB\Driver\Query($filter, $options);
			$cursor = $m->executeQuery('nbp.subject', $query);
        
		}
		catch( Exception $e ) { exit( 'PDO error ' . $e->getMessage() ); }
		$sub = null;
		foreach($cursor as $document) {
			$sub = new Subject($document->ISVUsifra, $document->imePredmeta, $document->opis, $document->semestar, $document->status, $document->godina, $document->obavezni);
    	}	

		return $sub;
	}

	function getStudentById( $jmbag_student )
	{
		try
		{
            $em = DB_NEO4J::getConnection();
			$query = $em->createQuery("MATCH (s:Student) WHERE s.jmbag={studentJMBAG} RETURN s");
			$query->setParameter("studentJMBAG", $jmbag_student);
			$result = $query->execute();
		}
		catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }

		$stud = null;
		foreach($result as $node) {
            $stud = new Student($node['s']->value('jmbag'), $node['s']->value('ime'), $node['s']->value('prezime'), $node['s']->value('oib'), $node['s']->value('spol'),
            $node['s']->value('datumRodenja'), $node['s']->value('aai'));
        }

		return $stud;
	}

	function getTeacherById( $oib_teacher )
	{
		try
		{
            $em = DB_NEO4J::getConnection();
			$query = $em->createQuery("MATCH (s:Teacher) WHERE s.oib={OIBteacher} RETURN s");
			$query->setParameter("OIBteacher", $oib_teacher);
			$result = $query->execute();
		}
		catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }

		$stud = null;
		foreach($result as $node) {
            $stud = new Teacher($node['s']->value('ime'), $node['s']->value('prezime'), $node['s']->value('oib'),
			$node['s']->value('spol'), $node['s']->value('aai'));
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
			$node['stud']->value("datumRodenja"), $node['stud']->value("aai"));
        }
		return $arr;
	}

	function getSubjectsOfTeacher( $oib_teacher )
	{

		try
		{
            $em = DB_NEO4J::getConnection();
			$query = $em->createQuery("MATCH (s:Subject)--(t:Teacher) WHERE t.oib={OIBteacher} RETURN s");
			$query->setParameter("OIBteacher", $oib_teacher);
			$result = $query->execute();
		}
		catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }
		$arr = array();
		foreach($result as $node) {
            $arr[] = new Subject($node['s']->value('ISVUsifra'), $node['s']->value('imePredmeta'), "", $node['s']->value('semestar'), "",
    		$node['s']->value('godina'), $node['s']->value('obavezni'));
        }
		return $arr;
	}

	function getMySubjects( $jmbag_student )
	{
		try
		{
            $em = DB_NEO4J::getConnection();
			$query = $em->createQuery("MATCH (s:Subject)--(stud:Student) WHERE stud.jmbag={studentJMBAG} RETURN s");
			$query->setParameter("studentJMBAG", strval($jmbag_student));
			$result = $query->execute();
		}
		catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }

        //print_r($result);

		$arr = array();
		foreach($result as $node) {
			$isvu_predmet = $node['s'] -> value('ISVUsifra');
			$ime_predmeta = $node['s'] -> value('imePredmeta');
			$semestar = $node['s'] -> value('semestar');
			$godina = $node['s'] -> value('godina');
			$obavezni = $node['s'] -> value('obavezni');
            $cur = new Subject($isvu_predmet, $ime_predmeta, "", $semestar, "", $godina, $obavezni);
            $arr[] = $cur;
        }
		return $arr;
	}

	function recommendMeSubject($my_jmbag, $sourceSubjectIsvu){
		//source subject isvu je predmet na temelju kojeg dajem preporuku
		try{
            $em = DB_NEO4J::getConnection();
			$query = $em -> createQuery("match(ja:Student{jmbag:  {studentJMBAG}}) - [:ENROLLED_IN] -> (predmet:Subject{ISVUsifra: {source_id}}) - [:ENROLLED_IN] - (student:Student) - [:ENROLLED_IN] -> (popularni:Subject)
				where student <> ja
				and not	(ja) - [:ENROLLED_IN] -> (popularni)
				return popularni, count(distinct(student)) as freq
				order by freq desc
				limit 1;");
			$query -> setParameter("studentJMBAG", $my_jmbag);
			$query -> setParameter("source_id", strval($sourceSubjectIsvu));
			$result = $query->execute();
		}
		catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }

		$arr = array();
		//echo 'veliko je ' . count($result);
		foreach($result as $node) {
			$isvu_predmet = $node['popularni'] -> value('ISVUsifra');
			$ime_predmeta = $node['popularni'] -> value('imePredmeta');
			$semestar = $node['popularni'] -> value('semestar');
			$godina = $node['popularni'] -> value('godina');
			$obavezni = $node['popularni'] -> value('obavezni');
            
            $arr[] = new Subject($isvu_predmet, $ime_predmeta, "", $semestar, "", $godina, $obavezni); 
        }
        //print_r($result);
		return $arr;
	}

	function signTeacherToSubject($teacher_oib, $sub_isvu){
		try{
			$em = DB_NEO4J::getConnection();
			$query = $em -> createQuery("match (prof:Teacher), (sub:Subject)
				where prof.oib = {teacherOIB} and sub.ISVUsifra = {isvuSifra}
				create (prof) - [r:TEACHES] -> (sub)
				return type(r)");
			$query -> setParameter("teacherOIB", strval($teacher_oib));
			$query -> setParameter("isvuSifra", strval($sub_isvu));
			$result = $query -> execute();
		} catch (Exception $e){
			return false;
		}
		return true;
	}

	function signStudentToSubject($student_jmbag, $sub_isvu){
		$upisani = $this -> getStudentsOfSubject($sub_isvu);
		foreach($upisani as $ts){
			if(strval($ts -> JMBAG) === strval($student_jmbag)){
				return true; //vec je upisan na tom kolegiju
			}
		}
		
		try{
			$em = DB_NEO4J::getConnection();
			$query = $em -> createQuery("match (stud:Student), (sub:Subject)
				where stud.jmbag = {studJMBAG} and sub.ISVUsifra = {isvuSifra}
				create (stud) - [r:ENROLLED_IN] -> (sub)
				return type(r)");
			$query -> setParameter("studJMBAG", strval($student_jmbag));
			$query -> setParameter("isvuSifra", strval($sub_isvu));
			$result = $query -> execute();
		} catch (Exception $e){
			return false;
		}
		return true;
	}

	
};
?>

