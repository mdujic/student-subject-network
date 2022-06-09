<?php require_once __DIR__ . '/_header.php'; ?>

<?php
function obojaj($status) {
	if($status === 'open'){
		return '#0cb500';
	}
	return '#d90723';
}

echo '<h3> Ja sam ' . $ime_i_prezime . '</h3>';

?>
<h2>Popis mojih predmeta: </h2>
<table>
<tr><th>SubjectID</th><th>Ime predmeta</th><th>Kolegij prijatelj</th></tr>

<?php
  $i = 0;
  foreach($predmeti as $predmet){
		echo '<tr>' .
		'<td>' . $predmet -> subjectName . '</td>' .
    '<td>' . $predmet -> subjectID . '</td>' .
    '<td>' . $preporuka[$i] -> subjectName . '</td>' .
    '</tr>';
    $i++;  
	}
?>
</table>

<?php 

require_once __DIR__ . '/_footer.php'; ?>
