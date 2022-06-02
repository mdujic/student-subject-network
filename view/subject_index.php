<?php require_once __DIR__ . '/_header.php'; ?>

	<nav>
		<ul>
	<?php 

		if ($subjectList === null) {
            echo '<h2>Trenutno nemate niti jedan upisan predmet</h2>';
        }else {
            foreach( $subjectList as $subject )
		        {
		        	echo '<li><a href="index.php?rt=subject/showSubjectId&id_subject=' . $subject->subjectID . '">'
		        	. $subject->subjectName . '</a></li>';
		        }
        }
	?>
  </ul>
	</nav>
<?php require_once __DIR__ . '/_footer.php'; ?>