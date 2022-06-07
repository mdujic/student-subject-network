<?php require_once __SITE_PATH . '/view/_header_out.php'; ?>

<form method="post" action="<?php echo __SITE_URL . '/index.php?rt=register'?>">
	Odaberite korisničko ime:
	<input type="text" name="username" />
	<br />
	Odaberite lozinku:
	<input type="password" name="password" />
	<br />
	Vaša mail-adresa:
	<input type="text" name="email" />
	<br />
	<button type="submit">Stvori korisnički račun!</button>
</form>

<p>
	Povratak na <a href="<?php echo __SITE_URL . '/index.php?rt=login'?>">login</a>.
</p>

<p>
	Povratak na <a href="<?php echo __SITE_URL . '/index.php?rt=allprojects'?>">popis svih projekata</a>.
</p>


<?php require_once __SITE_PATH . '/view/_footer.php'; ?>
