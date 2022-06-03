<?php require_once __DIR__ . '/_header.php'; ?>

<?php
function obojaj($status) {
	if($status === 'open'){
		return '#0cb500';
	}
	return '#d90723';
}

echo '<h3 style="color:' . $ime_i_prezime . '</h3>';

?>

<h2>Popis predmeta ovog studenta: </h2>
<table>
<tr><th>SubjectID</th><th>Ime predmeta</th></tr>

<?php 
    foreach($predmeti as $predmet){
		echo '<tr>' .
		'<td>' . $predmet -> id . '</td>' .
		'<td>' . $predmet -> subjectID . '</td>';
		'</tr>';
		
		
	}
?>
</table>

<?php 
    
require_once __DIR__ . '/_footer.php'; ?>
