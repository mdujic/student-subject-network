<?php

class Service 
{


	function getAllSubjects()
	{
		try
		{
			$db = DB::getConnection();
			$st = $db->prepare( 'SELECT * FROM dz2_projects ORDER BY title' );
			$st->execute();
		}
		catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }

		$arr = array();
		while( $row = $st->fetch() )
		{
			$arr[] = new Project( $row['id'], $row['id_user'], $row['title'], $row['abstract'], $row['number_of_members'], $row['status'], $this->getUserById( $row['id_user'] )->username  );
		}

		return $arr;
	}
    

    function getSubjectById( $id )
	{
		try
		{
			$db = DB::getConnection();
			$st = $db->prepare( 'SELECT * FROM loans WHERE id=:id' );
			$st->execute( array( 'id' => $id ) );
		}
		catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }

		$arr = array();
		while( $row = $st->fetch() )
		{
			$arr[] = new Member( $row['id'], $row['id_project'], $row['id_user'], $row['member_type'], $this->getUserById( $id )->username );
		}

		return $arr;
	}

	function getStudentById( $id )
	{
		try
		{
			$db = DB::getConnection();
			$st = $db->prepare( 'SELECT * FROM loans WHERE id=:id' );
			$st->execute( array( 'id' => $id ) );
		}
		catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }

		$arr = array();
		while( $row = $st->fetch() )
		{
			$arr[] = new Member( $row['id'], $row['id_project'], $row['id_user'], $row['member_type'], $this->getUserById( $id )->username );
		}

		return $arr;
	}

    function getStudentsOfSubject( $subjectId )
	{

		try
		{
			$db = DB::getConnection();
			$st = $db->prepare( 'SELECT DISTINCT id_project
								 FROM dz2_projects
								 LEFT JOIN dz2_members
								 ON dz2_projects.id = dz2_members.id_project
								 WHERE dz2_members.id_user=:id_user
								 	AND	( member_type=:m1 OR member_type=:m2 OR member_type=:m3 )' );
			$st->execute( array( 'id_user' => $subjectId, 'm1' => 'member', 'm2' => 'application_accepted', 'm3' => 'invitation_accepted' ) );
		}
		catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }

		$arr = array();
		while( $row = $st->fetch() )
		{
			$project = $this->getProjectById( $row['id_project'] );
			$arr[] = new Project( $project->id, $project->id_user, $project->title, $project->abstract, $project->number_of_members, $project->status, $project->author );
		}

		return $arr;
	}

	function getMySubjects( $id_student )
	{

		try
		{
			$db = DB::getConnection();
			$st = $db->prepare( 'SELECT DISTINCT id_project
								 FROM dz2_projects
								 LEFT JOIN dz2_members
								 ON dz2_projects.id = dz2_members.id_project
								 WHERE dz2_members.id_user=:id_user
								 	AND	( member_type=:m1 OR member_type=:m2 OR member_type=:m3 )' );
			$st->execute( array( 'id_user' => $id_student, 'm1' => 'member', 'm2' => 'application_accepted', 'm3' => 'invitation_accepted' ) );
		}
		catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }

		$arr = array();
		while( $row = $st->fetch() )
		{
			$project = $this->getProjectById( $row['id_project'] );
			$arr[] = new Project( $project->id, $project->id_user, $project->title, $project->abstract, $project->number_of_members, $project->status, $project->author );
		}

		return $arr;
	}


	
};

?>

