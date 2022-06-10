<?php require_once __DIR__ . '/_header.php'; ?>

<?php
function obojaj($status) {
	if($status === 'open'){
		return '#0cb500';
	}
	return '#d90723';
}

echo '<h3 style="color:' . obojaj($subject->status) . '">Status:   ' . $subject->status . '</h3>';

?>
<p>
    <?php echo $subject->description ?>
    <h2>Možda želite upisati i sljedeće predmete: </h2>
    <table>
    <?php
	 	foreach($similar_subjects as $predmet){
			echo '<tr>' .
			'<td>' . '<a href="index.php?rt=subject/showSubjectId&id_subject=' . $predmet -> subjectID . '">' .
			$predmet -> subjectName . '</a>' . '</td>' .
	    	'<td>' . $predmet -> subjectID . '</td>' .
		    '</tr>';
		}	
	?>
	</table>

</p>
<h2>Popis upisanih studenata:</h2>
<table>
<tr><th>Student id</th><th>Student name</th></tr>
<?php 
    foreach( $students as $student )
	{
		echo '<tr>' .
		'<td>' . $student->JMBAG . '</td>' .
		'<td>' . $student->ime . ' ' . $student -> prezime . '</td>';
		'</tr>';
	}
?>
</table>

<?php 

if ($subject->status === 'open'){
	?>
	<form method="post" action="index.php?rt=subject/send_application&id_subject=<?php echo $subject->subjectID ?>">
			
			<button type="submit" name="gumb" value="send_application">Pošalji zahtjev za pridruživanje!</button>
            <br />
            
	</form>
	<?php 
}


require_once __DIR__ . '/_footer.php'; ?>
