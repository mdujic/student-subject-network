<?php require_once __SITE_PATH . '/view/_header_out.php'; ?>

<form method="post" action="<?php echo __SITE_URL . '/index.php?rt=login'?>">
	Korisničko ime:
	<input type="text" name="username" />
	<br />
	Lozinka:
	<input type="password" name="password" />
	<br />
	<button type="submit">Ulogiraj se!</button>
</form>

<p>
	Ako nemate korisnički račun, otvorite ga <a href="<?php echo __SITE_URL . '/index.php?rt=register'?>">ovdje</a>.
</p>

<?php require_once __SITE_PATH . '/view/_footer.php'; ?>
