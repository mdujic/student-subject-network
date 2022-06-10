<?php require_once __SITE_PATH . '/view/_header.php'; ?>

		<ul>
	<?php 

		if ($studenti === null) {
            echo '<h2>Trenutno nemate niti jednog studenta</h2>';
        }else {
            foreach($studenti as $student){
                $ime_i_prezime = $student->ime . ' ' . $student->prezime;
                echo '<li><a href="index.php?rt=student/showStudentId&id_student=' . $student -> JMBAG . '">'
                . $ime_i_prezime . '</a></li>';
            }
        }
	?>
  </ul>
  <?php require_once __SITE_PATH . '/view/_footer.php'; ?>