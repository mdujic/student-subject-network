<?php require_once __SITE_PATH . '/view/_header.php'; ?>

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

<?php require_once __SITE_PATH . '/view/_footer.php'; ?>
