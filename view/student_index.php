<?php require_once __DIR__ . '/_header.php'; ?>

	<nav>
		<ul>
	<?php 

		if ($studenti === null) {
            echo '<h2>Trenutno nemate niti jedan upisan predmet</h2>';
        }else {
            foreach($studenti as $student){
                $ime_i_prezime = $student -> ime . ' ' . $student -> prezime;
                echo '<li><a href="index.php?rt=student/showStudent&id_student=' . $student -> JMBAG . '">'
                . $ime_i_prezime . '</a></li>';
            }
        }
	?>
  </ul>
	</nav>
<?php require_once __DIR__ . '/_footer.php'; ?>