<?php 

class IndexController extends BaseController
{
	public function index() 
	{
		// Samo preusmjeri na allprojects podstranicu.
		if( isset($_SESSION['username']) )
			header( 'Location: ' . __SITE_URL . '/index.php?rt=subject' );
		else 
			header( 'Location: ' . __SITE_URL . '/index.php?rt=login' );
	}
}; 

?>
