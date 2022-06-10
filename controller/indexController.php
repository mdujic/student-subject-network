<?php 

class IndexController extends BaseController
{
	public function index() 
	{
		// Samo preusmjeri na allprojects podstranicu.
		if( !isset($_SESSION['username']) )
			$_SESSION['username'] = 'student';
		header( 'Location: ' . __SITE_URL . '/index.php?rt=subject' );
			
	}
}; 

?>
