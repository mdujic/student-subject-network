<?php require_once __DIR__ . '/_header.php'; ?>

<h2><?php echo $student->ime . " " . $student->prezime ?></h2>
<div><b>Email: </b><?php echo $student->email ?></div>
<div><b>Datum rođenja: </b><?php echo $student->datum_rodenja ?></div>
<div><b>Spol: </b><?php echo $student->spol ?></div>
<div><b>JMBAG: </b><?php echo $student->JMBAG ?></div>
<h2>Popis upisanih predmeta: </h2>
<table>
<tr><th>Ime predmeta</th><th>ISVU šifra</th><th>Kolegij prijatelj</th></tr>

<?php
  $i = 0;
  foreach($predmeti as $predmet){
		echo '<tr>' .
		'<td>' . '<a href="index.php?rt=subject/showSubjectId&id_subject=' . $predmet -> subjectID . '">' .
		$predmet -> subjectName . '</a>' . '</td>' .
    '<td>' . $predmet -> subjectID . '</td>' .
		'<td>' . '<a href="index.php?rt=subject/showSubjectId&id_subject=' . $preporuka [$i] -> subjectID . '">' .
		$preporuka[$i] -> subjectName . '</a>' . '</td>' .
    '</tr>';
    $i++;  
	}
?>
</table>

<?php 

require_once __DIR__ . '/_footer.php'; ?>
