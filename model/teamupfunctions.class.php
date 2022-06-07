<?php

class TeamUpFunctions
{
	function getUserById( $id )
	{
		try
		{
			$db = DB_SQL::getConnection();
			$st = $db->prepare( 'SELECT * FROM dz2_users WHERE id=:id' );
			$st->execute( array( 'id' => $id ) );
		}
		catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }

		$row = $st->fetch();
		if( $row === false )
			return null;
		else
			return new User( $row['id'], $row['username'], $row['password_hash'], $row['email'], $row['registration_sequence'], $row['has_registered'] );
	}

    function getUserByUsername( $username )
	{
		try
		{
			$db = DB_SQL::getConnection();
			$st = $db->prepare( 'SELECT * FROM dz2_users WHERE username=:username' );
			$st->execute( array( 'username' => $username ) );
		}
		catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }

		$row = $st->fetch();
		if( $row === false )
			return null;
		else
			return new User( $row['id'], $row['username'], $row['password_hash'], $row['email'], $row['registration_sequence'], $row['has_registered'] );
	}

	function getUserByRegSeq( $reg_seq )
	{
		// Nađi korisnika s tim nizom u bazi
        $db = DB_SQL::getConnection();

        try
        {
            $st = $db->prepare( 'SELECT * FROM dz2_users WHERE registration_sequence=:reg_seq' );
            $st->execute( array( 'reg_seq' => $reg_seq ) );
        }
        catch( PDOException $e ) { exit( 'Greška u bazi: ' . $e->getMessage() ); }
		$row = $st->fetch();

        if( $st->rowCount() !== 1 )
            return false;
        else
        {
            // Sad znamo da je točno jedan takav. Postavi mu has_registered na 1.
            try
            {
                $st = $db->prepare( 'UPDATE dz2_users SET has_registered=1 WHERE registration_sequence=:reg_seq' );
                $st->execute( array( 'reg_seq' => $reg_seq ) );
            }
            catch( PDOException $e ) { exit( 'Greška u bazi: ' . $e->getMessage() ); }

            return true;
        }
	}

	function getAllUsers( )
	{
		try
		{
			$db = DB_SQL::getConnection();
			$st = $db->prepare( 'SELECT * FROM dz2_users ORDER BY username' );
			$st->execute();
		}
		catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }

		$arr = array();
		while( $row = $st->fetch() )
		{
			$arr[] = new User( $row['id'], $row['username'], $row['password_hash'], $row['email'], $row['registration_sequence'], $row['has_registered'] );
		}

		return $arr;
	}


	function getProjectById( $id )
	{
		try
		{
			$db = DB_SQL::getConnection();
			$st = $db->prepare( 'SELECT * FROM dz2_projects WHERE id=:id' );
			$st->execute( array( 'id' => $id ) );
		}
		catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }

		$row = $st->fetch();
		if( $row === false )
			return null;
		else
			return new Project( $row['id'], $row['id_user'], $row['title'], $row['abstract'], $row['number_of_members'], $row['status'], $this->getUserById( $row['id_user'] )->username );
	}


	function getProjectByTitle( $title )
	{
		try
		{
			$db = DB_SQL::getConnection();
			$st = $db->prepare( 'SELECT * FROM dz2_projects WHERE title=:title ORDER BY title' );
			$st->execute( array( 'title' => $title ) );
		}
		catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }

		$row = $st->fetch();
		if( $row === false )
			return null;
		else
			return new Project( $row['id'], $row['id_user'], $row['title'], $row['abstract'], $row['number_of_members'], $row['status'], $this->getUserById( $row['id_user'] )->username );
	}


	function getAllProjects()
	{
		try
		{
			$db = DB_SQL::getConnection();
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

	function makeNewUser( $username, $password, $email, $reg_seq )
	{
		try
		{
			$db = DB_SQL::getConnection();
			$st = $db->prepare( 'INSERT INTO dz2_users(username, password_hash, email, registration_sequence, has_registered) VALUES ' .
								'(:username, :password_hash, :email, :registration_sequence, 0)' );
			
			$st->execute( array( 'username' => $username, 
								'password_hash' => password_hash( $password, PASSWORD_DEFAULT ), 
								'email' => $email, 
								'registration_sequence'  => $reg_seq ) );
		}
		catch( PDOException $e ) { exit( 'Greška u bazi: ' . $e->getMessage() ); }
	}

	function getMemberById( $id )
	{
		try
		{
			$db = DB_SQL::getConnection();
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

	function getProjectsForUser( $id_user )
	{

		try
		{
			$db = DB_SQL::getConnection();
			$st = $db->prepare( 'SELECT DISTINCT id_project
								 FROM dz2_projects
								 LEFT JOIN dz2_members
								 ON dz2_projects.id = dz2_members.id_project
								 WHERE dz2_members.id_user=:id_user
								 	AND	( member_type=:m1 OR member_type=:m2 OR member_type=:m3 )' );
			$st->execute( array( 'id_user' => $id_user, 'm1' => 'member', 'm2' => 'application_accepted', 'm3' => 'invitation_accepted' ) );
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

	function makeNewProject( $id_user, $title, $abstract, $number_of_members )
	{
		// Provjeri prvo jel postoji taj user
		try
		{
			$db = DB_SQL::getConnection();
			$st = $db->prepare( 'SELECT * FROM dz2_users WHERE id=:id' );
			$st->execute( array( 'id' => $id_user ) );
		}
		catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }

		if( $st->rowCount() !== 1 )
			throw new Exception( 'makeNewProject :: User with the given id_user does not exist.' );



		// Sad možemo stvoriti novi projekt
		try
		{
            $status = 'open';
			$db = DB_SQL::getConnection();
			$st = $db->prepare( 'INSERT INTO dz2_projects(id_user, title, abstract, number_of_members, status) VALUES (:id_user, :title, :abstract, :number_of_members, :status)' );
			$st->execute( array( 'id_user' => $id_user, 'title' => $title, 'abstract' => $abstract, 'number_of_members' => $number_of_members, 'status' => $status ) );
		}
		catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }

		return $this->getProjectByTitle( $title );
	}

	function assignMembership( $id_project, $id_user, $member_type )
	{
		try
		{
            $status = 'open';
			$db = DB_SQL::getConnection();
			$st = $db->prepare( 'INSERT INTO dz2_members(id_project, id_user, member_type) VALUES (:id_project, :id_user, :member_type)' );
			$st->execute( array( 'id_project' => $id_project, 'id_user' => $id_user, 'member_type' => $member_type ) );
		}
		catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }
	}

	function addUserToTeam( $id_project, $id_user )
	{
        // Prvo provjerimo postoje li project i user
        try
		{
			$db = DB_SQL::getConnection();
			$st = $db->prepare( 'SELECT * FROM dz2_projects WHERE id=:id' );
			$st->execute( array( 'id' => $id_project ) );
		}
		catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }

		if( $st->rowCount() !== 1 )
			throw new Exception( 'addUserToTeam :: Project with the given id_project does not exist.' );
        
		try
		{
			$db = DB_SQL::getConnection();
			$st = $db->prepare( 'SELECT * FROM dz2_users WHERE id=:id' );
			$st->execute( array( 'id' => $id_user ) );
		}
		catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }

		if( $st->rowCount() !== 1 )
			throw new Exception( 'addUserToTeam :: User with the given id_user does not exist.' );	

        // Sada stvaramo članstvo
        try
		{
            $member_type = 'member';
			$db = DB_SQL::getConnection();
			$st = $db->prepare( 'INSERT INTO dz2_members(id_project, id_user, member_type) VALUES (:id_project, :id_user, :member_type)' );
			$st->execute( array( 'id_project' => $id_project, 'id_user' => $id_user, 'member_type' => $member_type ) );
		}
		catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }
	}

	function getMembershipsForUser( $id_user, $member_type )
	{
		try
		{
			$db = DB_SQL::getConnection();
			$st = $db->prepare( 'SELECT * FROM dz2_members WHERE id_user=:id_user AND member_type=:member_type' );
			$st->execute( array( 'id_user' => $id_user, 'member_type' => $member_type ) );
		}
		catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }

		$arr = array();
		while( $row = $st->fetch() )
		{
			$arr[] = new Member( $row['id'], $row['id_project'], $row['id_user'], $row['member_type'], $this->getUserById( $id_user )->username );
		}

		return $arr;
	}
	
	function getMembershipsForProject( $id_project )
	{
		try
		{
			$db = DB_SQL::getConnection();
			$st = $db->prepare( 'SELECT * FROM dz2_members 
								 LEFT JOIN dz2_users 
								 ON dz2_members.id_user = dz2_users.id 
								 WHERE dz2_members.id_project=:id_project AND ( member_type=:m1 OR member_type=:m2 OR member_type=:m3 )' );
			$st->execute( array( 'id_project' => $id_project, 'm1' => 'member', 'm2' => 'invitation_accepted', 'm3' => 'application_accepted' ) );
		}
		catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }

		$arr = array();
		while( $row = $st->fetch() )
		{
			$arr[] = new Member( $row['id'], $row['id_project'], $row['id_user'], $row['member_type'], $this->getUserById( $row['id_user'] )->username );
		}

		return $arr;
	}

	function makeNewApplication( $username, $id_project )
	{
		$user = $this->getUserByUsername( $username );
		$project = $this->getProjectById( $id_project );
		$member_type = 'application_pending';
		try
		{
			$db = DB_SQL::getConnection();
			$st = $db->prepare( 'INSERT INTO dz2_members(id_project, id_user, member_type) VALUES (:id_project, :id_user, :member_type)' );
			$st->execute( array( 'id_project' => $id_project, 'id_user' => $user->id, 'member_type' => $member_type ) );
		}
		catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }
	}
	
	function checkStatusOfProject( $id_project )
	{
		$project = $this->getProjectById( $id_project );
		if( $this->noOfProjectMembers( $id_project )  >= $project->number_of_members )
		{
			try
			{
				$db = DB_SQL::getConnection();
				$st = $db->prepare('UPDATE dz2_projects
									SET
										status = :status
									WHERE
										id = :id_project' );
				$st->execute( array( 'id_project' => $id_project, 'status' => 'closed' ) );
			}
			catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }
		}
		else
		{
			try
			{
				$db = DB_SQL::getConnection();
				$st = $db->prepare('UPDATE dz2_projects
									SET
										status = :status
									WHERE
										id = :id_project' );
				$st->execute( array( 'id_project' => $id_project, 'status' => 'open' ) );
			}
			catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }
		}
	}

	function noOfProjectMembers( $id_project )
	{
		try
		{
			$db = DB_SQL::getConnection();
			$st = $db->prepare( 'SELECT COUNT(DISTINCT id_user) AS c
								FROM dz2_members
								WHERE id_project=:id_project
									AND ( member_type=:m1 OR member_type=:m2 OR member_type=:m3 )' );
			$st->execute( array( 'id_project' => $id_project, 'm1' => 'member', 'm2' => 'application_accepted', 'm3' => 'invitation_accepted' ) );
			
			$row = $st->fetch();
			return $row['c'];
		}
		catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }
	}

	function getPendingApplicationsForProject( $id_project )
	{
		$project = $this->getProjectById( $id_project );
		try
		{
			$db = DB_SQL::getConnection();
			$st = $db->prepare('SELECT * FROM dz2_members 
								LEFT JOIN dz2_users 
								ON dz2_users.id = dz2_members.id_user
								WHERE dz2_members.id_project=:id_project AND member_type=:member_type' );
			$st->execute( array( 'id_project' => $id_project, 'member_type' => 'application_pending') );
		}
		catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }

		$arr = array();
		while( $row = $st->fetch() )
		{
			$arr[] = new Member( $row['id'], $row['id_project'], $row['id_user'], $row['member_type'], $row['username'] );
		}

		return $arr;
	}

	function changePendingApplicationToAcceptedApplication( $concatenated_ids )
	{
		$pieces = explode("/", $concatenated_ids);
		$id_user = $pieces[0];
		$id_project = $pieces[1];

		try
		{
			$db = DB_SQL::getConnection();
			$st = $db->prepare('UPDATE dz2_members
								SET
									member_type = :member_type
								WHERE
									id_project = :id_project AND id_user = :id_user' );
			$st->execute( array( 'id_project' => $id_project, 'id_user' => $id_user, 'member_type' => 'application_accepted') );
		}
		catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }
	}

	function inviteUserToProject( $username, $id_project )
	{
		$project = $this->getProjectById( $id_project );
		$user = $this->getUserByUsername( $username );
		try
		{
			$db = DB_SQL::getConnection();
			$st = $db->prepare('SELECT * FROM dz2_members 
								WHERE dz2_members.id_project=:id_project AND id_user=:id_user' );
			$st->execute( array( 'id_project' => $id_project, 'id_user' => $user->id ) );
		}
		catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }

		if( $st->rowCount() !== 0 )
			throw new Exception( 'inviteUserToProject :: membership already exists.' );
        else{
			try
			{
				$db = DB_SQL::getConnection();
				$st = $db->prepare( 'INSERT INTO dz2_members(id_project, id_user, member_type) VALUES (:id_project, :id_user, :member_type)' );
				$st->execute( array( 'id_project' => $id_project, 'id_user' => $user->id, 'member_type' => 'invitation_pending' ) );
			}
			catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }
		}
		

	}

	function acceptInvitation( $concatenated_ids )
	{
		$pieces = explode("/", $concatenated_ids);
		$id_user = $pieces[0];
		$id_project = $pieces[1];

		try
		{
			$db = DB_SQL::getConnection();
			$st = $db->prepare('UPDATE dz2_members
								SET
									member_type = :member_type
								WHERE
									id_project = :id_project AND id_user = :id_user' );
			$st->execute( array( 'id_project' => $id_project, 'id_user' => $id_user, 'member_type' => 'invitation_accepted') );
		}
		catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }
	}
	function rejectInvitation( $concatenated_ids )
	{
		$pieces = explode("/", $concatenated_ids);
		$id_user = $pieces[0];
		$id_project = $pieces[1];
	}
};

?>

