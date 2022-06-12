<?php require_once __DIR__ . '/_header.php'; ?>
	<html>
		<h2> Uvođenje novog profesora na kolegij </h2>
		<form method = "post" action = "<?php echo __SITE_URL . '/index.php?rt=connections/teacherToSubject'?>">
			<label>OIB profesora: </label> 
			<input type = "text" name = "oib_profesora"/> <br>
			<label>ISVU kolegija: </label>
			<input type = "text" name = "isvu_kolegija"/> <br> <br>
			<button type = "submit"> Dodaj </button> 
		</form>
		<?php if(isset($message)){ echo '<p style = "color: ' . $tcolor . ';">' . $message . '</p>'; }?> 
		<br><br>

		<h2> Upis novog studenta na kolegij </h2>
		<form method = "post" action = "<?php echo __SITE_URL . '/index.php?rt=connections/studentToSubject'?>">
			<label>JMBAG studenta: </label> 
			<input type = "text" name = "jmbag_studenta"/> <br>
			<label>ISVU kolegija: </label>
			<input type = "text" name = "isvu_kolegija"/> <br> <br>
			<button type = "submit"> Dodaj </button> 
		</form>
		<?php if(isset($message2)){ echo '<p style = "color: ' . $tcolor . ';">' . $message2 . '</p>';}?> <br/><br/>

	</html>

<?php require_once __DIR__ . '/_footer.php'; ?>
