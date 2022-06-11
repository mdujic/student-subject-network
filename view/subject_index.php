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
<br/>
<br/>
<br/>
<?php

	if ( $_SESSION['username'] === 'admin') {
		?>
			<h2>Unesi novi predmet: </h2>
			<form method="post" action="<?php echo __SITE_URL . '/index.php?rt=subject'?>">
				Naziv predmeta:
				<input type="text" name="naziv" />
				<br />
				<br />
				Opis:
				<input type="text" name="opis" />
				<br />
				<br />
				ISVU šifra:
				<input type="text" name="ISVUsifra" />
				<br />
				<br />
				<label for="semestar">Ljetni/zimski semestar:</label>
				<select name="semestar" id="semestar">
					<option id="semestar" name="semestar" value="LJ" selected>Ljetni semestar</option>
					<option id="semestar" name="semestar" value="Z" >Zimski semestar</option>
				</select>
				<br />
				<br />
				<label for="godina">Odaberite godinu studija:</label>
				<select name="godina" id="godina">
					<option id="godina" name="godina" value="1" selected>1</option>
					<option id="godina" name="godina" value="2" >2</option>
					<option id="godina" name="godina" value="3" >3</option>
					<option id="godina" name="godina" value="4" >4</option>
					<option id="godina" name="godina" value="5" >5</option>
				</select>
				<br />
				<br />
				<label for="obavezni">Obavezni:</label>
				<select name="obavezni" id="obavezni">
					<option id="obavezni" name="obavezni" value="da" selected>DA</option>
					<option id="obavezni" name="obavezni" value="ne" >NE</option>
				</select>
				<br />
				<br />
				<label for="status">Status:</label>
				<select name="status" id="status">
					<option id="status" name="status" value="open" selected>Otvorene prijave</option>
					<option id="status" name="status" value="closed" >Zatvorene prijave</option>
				</select>
				<br />
				<br />
				<br />
				<button type="submit">Unesi novi predmet!</button>
			</form>
		<?php
	}

?>

<?php require_once __SITE_PATH . '/view/_footer.php'; ?>
