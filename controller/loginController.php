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
			if($_POST['username'] === 'admin' && $_POST['password'] === '1234'){
				$_SESSION['username'] = "admin";
				header( 'Location: ' . __SITE_URL . '/index.php?rt=subject' );
			}
		}
	}

}; 

?>
