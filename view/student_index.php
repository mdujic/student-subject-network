<?php require_once __SITE_PATH . '/view/_header.php'; ?>

		<ul>
	<?php 

		if ($studenti === null) {
            echo '<h2>Trenutno nemate niti jednog studenta</h2>';
        }else {
            foreach($studenti as $student){
                $ime_i_prezime = $student->ime . ' ' . $student->prezime;
                echo '<li><a href="index.php?rt=student/showStudentId&id_student=' . $student -> JMBAG . '">'
                . $ime_i_prezime . '</a></li>';
            }
        }
	?>
    </ul>

   <?php if($_SESSION['username'] === 'admin') { ?>

        <h2>Unesi novog studenta: </h2>
        <form method = "post" action = " <?php echo __SITE_URL . '/index.php?rt=student/insertStudent'?>">
            <label>Ime: </label>
            <input type="text" name="ime"/> <br/>
            <label>Prezime: </label>
            <input type="text" name="prezime"/> <br/>
            <label>Email: </label>
            <input type="text" name="email"/> <br/>
            <label>JMBAG:</label>
            <input type="text" name="jmbag"/> <br/>
            <label>OIB: </label>
            <input type="text" name="oib"/> <br/>
            <label>Datum rođenja (MM/DD/GG): </label>
            <input type = "text" name = "datum_rodenja"/> <br/>
            <label>Mjesto rođenja: </label>
            <input type = "text" name = "mjesto_rodenja"/> <br/>
            <label for = "spol"> Spol: </label>
            <select name = "spol" id = "spol">
                <option id="spol" name="spol" value="M" selected>M</option>
                <option id="spol" name="spol" value="Ž" >Ž</option>
            </select>
            <br />
            <button type="submit">Unesi novog studenta!</button>
        </form>
        <br/>
        <?php if(isset($message)){ echo '<p style = "color: ' . $tcolor . ';">' . $message . '</p>'; }?> 
    <?php }?>


  <?php require_once __SITE_PATH . '/view/_footer.php'; ?>