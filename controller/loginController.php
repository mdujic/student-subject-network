<?php 

class LoginController extends BaseController
{
	public function index() 
	{
		// Analizira $_POST iz forme za login

		$tuf = new TeamUpFunctions();
		if( !isset( $_POST['username'] ) || !isset( $_POST['password'] ) )
		{
			$this->registry->template->title = 'Enter username and password.';
			$this->registry->template->show( 'login_form' );
		}
		else if( !preg_match( '/^[a-zA-Z]{3,10}$/', $_POST['username'] ) )
		{
			$this->registry->template->title = 'Username must have between 3 and 10 letters.';
			$this->registry->template->show( 'login_form' );
		}
		else
		{
			// Dakle dobro je korisničko ime. 
			// Provjeri taj korisnik postoji u bazi; dohvati njegove ostale podatke.
			$user = $tuf->getUserByUsername( $_POST['username'] );
			
			if( $user === null )
			{
				$this->registry->template->title = 'User with that name doesn\'t exist.';
				$this->registry->template->show( 'login_form' );
			}
			else if( $user->has_registered === '0' )
			{
				$this->registry->template->title = 'User with that name has not been registered yet. Check your e-mail.';
				$this->registry->template->show( 'login_form' );	
			}
			else if( !password_verify( $_POST['password'], $user->password_hash ) )
			{
				$this->registry->template->title = 'You entered wrong password.';
				$this->registry->template->show( 'login_form' );
			}
			else
			{
				// Sad je valjda sve OK. Ulogiraj ga.
				$_SESSION['username'] = $_POST['username'];
				$this->registry->template->title = 'You have successfully logged in.';
				$this->registry->template->show( 'logged_in' );
			}
		}
	}

}; 

?>
