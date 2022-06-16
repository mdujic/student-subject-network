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


<?php
	if ( $_SESSION['username'] === 'admin') {
		?>
			<h2>Unesi novog profesora: </h2>
			<form method="post" action="<?php echo __SITE_URL . '/index.php?rt=teacher'?>">
				Ime:
				<input type="text" name="ime" />
				<br />
				<br />
				Prezime:
				<input type="text" name="prezime" />
				<br />
				<br />
				Email:
				<input type="text" name="email" />
				<br />
				<br />
				OIB:
				<input type="text" name="oib" />
				<br />
				<br />
				<label for="spol">Spol:</label>
				<select name="spol" id="spol">
					<option id="spol" name="spol" value="M" selected>M</option>
					<option id="spol" name="spol" value="Ž" >Ž</option>
				</select>
				<br />
				<br />
				<br />
				<button type="submit">Unesi novog profesora!</button>
			</form>
		<?php
	}
?>

<?php require_once __SITE_PATH . '/view/_footer.php'; ?>
