<?php require_once __SITE_PATH . '/view/_header.php'; ?>

<p>
	Bravo, poštovani korisniče <?php echo $_SESSION['username']; ?>! Uspješno ste se ulogirali!
</p>

<p>
	Sada se možete <a href="<?php echo __SITE_URL . '/index.php?rt=logout'?>">odlogirati</a>!
</p>


<?php require_once __SITE_PATH . '/view/_footer.php'; ?>
