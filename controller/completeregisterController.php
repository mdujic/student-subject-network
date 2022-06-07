<?php 

class CompleteRegisterController extends BaseController
{
	public function index() 
	{
        $tuf = new TeamUpFunctions();
        // Ova skripta analizira $_GET['niz'] i u bazi postavlja has_registered=1 za onog korisnika koji ima taj niz.
        // Jako je mala šansa da dvojica imaju isti.

        if( !isset( $_GET['niz'] ) || !preg_match( '/^[a-z]{20}$/', $_GET['niz'] ) )
            exit( 'Nešto ne valja s nizom.' );
        else
        {
            $user = $tuf->getUserByRegSeq( $_GET['niz'] );

            if($user === false)
                exit( 'Taj registracijski niz ima ' . $st->rowCount() . 'korisnika, a treba biti točno 1 takav.' );
            else
            {
                $this->registry->template->title = 'Thank you for your registration.';
                $this->registry->template->show( 'register_thanks' );
            }
        }
    }
}
?>