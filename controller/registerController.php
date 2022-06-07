<?php 

class RegisterController extends BaseController
{
	public function index() 
	{
		// Analizira $_POST iz forme za stvaranje novog korisnika

		$tuf = new TeamUpFunctions();
        if( !isset( $_POST['username'] ) || !isset( $_POST['password'] ) || !isset( $_POST['email'] ) )
        {
            $this->registry->template->title = 'You need to enter username, password and e-mail.';
			$this->registry->template->show( 'new' );
        }
        else if( !preg_match( '/^[A-Za-z]{3,10}$/', $_POST['username'] ) )
        {
            $this->registry->template->title = 'Username must have between 3 and 10 letters.';
			$this->registry->template->show( 'new' );
        }
        else if( !filter_var( $_POST['email'], FILTER_VALIDATE_EMAIL) )
        {
            $this->registry->template->title = 'E-mail is not valid.';
			$this->registry->template->show( 'new' );
        }
        else
        {
            // Provjeri jel već postoji taj korisnik u bazi
            $user = $tuf->getUserByUsername( $_POST['username'] );
            
            if( $user !== null )
            {
                $this->registry->template->title = 'User with that username already exists.';
                $this->registry->template->show( 'new' );
            }
            else
            {
                // Dakle sad je napokon sve ok.
                // Dodaj novog korisnika u bazu. Prvo mu generiraj random string od 10 znakova za registracijski link.
                $reg_seq = '';
                for( $i = 0; $i < 20; ++$i )
                    $reg_seq .= chr( rand(0, 25) + ord( 'a' ) ); // Zalijepi slučajno odabrano slovo

                $tuf->makeNewUser( $_POST['username'], $_POST['password'], $_POST['email'], $reg_seq );

                // Sad mu još pošalji mail
                $to       = $_POST['email'];
                $subject  = 'Registracijski mail';
                $message  = 'Poštovani ' . $_POST['username'] . "!\nZa dovršetak registracije kliknite na sljedeći link: ";
                $message .= 'http://' . $_SERVER['SERVER_NAME'] . htmlentities( dirname( $_SERVER['PHP_SELF'] ) ) . '/index.php?rt=completeregister&niz=' . $reg_seq . "\n";
                $headers  = 'From: rp2@studenti.math.hr' . "\r\n" .
                            'Reply-To: rp2@studenti.math.hr' . "\r\n" .
                            'X-Mailer: PHP/' . phpversion();

                $isOK = mail($to, $subject, $message, $headers);

                if( !$isOK )
                    exit( 'Greška: ne mogu poslati mail. (Pokrenite na rp2 serveru.)' );

                // Zahvali mu na prijavi.
                $this->registry->template->title = 'Thank you for your application.';
                $this->registry->template->show( 'login_thanks' );
            }
        }
    }
}
?>