<?php require_once __DIR__ . '/_header.php'; ?>



<h2><?php echo $teacher->ime . " " . $teacher->prezime ?></h2>
<div><b>Email: </b><?php echo $teacher->email ?></div>
<div><b>Spol: </b><?php echo $teacher->spol ?></div>
<div><b>OIB: </b><?php echo $teacher->OIB ?></div>
<h2>Popis predmeta kojih predaje: </h2>
<table>
<tr><th>Ime predmeta</th><th>ISVU šifra</th></tr>

<?php
  foreach($predmeti as $predmet){
		echo '<tr>' .
		'<td>' . '<a href="index.php?rt=subject/showSubjectId&id_subject=' . $predmet -> subjectID . '">' .
		$predmet -> subjectName . '</a>' . '</td>' .
		'<td>' . $predmet -> subjectID . '</td>';  
	}
?>
</table>

<?php 

require_once __DIR__ . '/_footer.php'; ?>
