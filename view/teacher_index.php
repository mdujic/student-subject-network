<?php require_once __SITE_PATH . '/view/_header.php'; ?>

<ul>
	<?php 

		if ($teachers === null) {
            echo '<h2>Trenutno nemate niti jedan upisan predmet</h2>';
        }else {
            foreach( $teachers as $teacher )
		        {
                    $ime_i_prezime = $teacher->ime . ' ' . $teacher->prezime;
		        	echo '<li><a href="index.php?rt=teacher/showTeacherId&id_teacher=' . $teacher->OIB . '">'
		        	. $ime_i_prezime . '</a></li>';
		        }
        }
	?>
</ul>

<?php require_once __SITE_PATH . '/view/_footer.php'; ?>
