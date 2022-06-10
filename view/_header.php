<!DOCTYPE html>
<html>
<head>
	<meta charset="utf8">
	<title>Student subject network</title>
	<link rel="stylesheet" href="<?php echo __SITE_URL;?>/css/style.css?v=<?php echo time(); ?>">
</head>
<body>
	<div style="padding: 1em;
		height: 5%;
		background-color: #43424d;
		overflow: hidden;
		color: white;">
		<h1>Student subject network</h1>
		<h2 style="float:right">Hello, <?php echo $_SESSION['username']; ?>!</h2>
	</div>

	<ul>
		<li><a href="index.php?rt=subject">Popis svih predmeta</a></li>
		<li><a href="index.php?rt=teacher">Popis svih profesora</a></li>
		<li><a href="index.php?rt=student">Popis svih studenata</a></li>
		<li><a href="index.php?rt=login">Prijavi se!</a></li>
		<?php 
			if ($_SESSION['username'] == 'admin'){
				echo '<li><a href="index.php?rt=logout">Odjavi se!</a></li>';
				echo '<li><a href="index.php?rt=connections">Upisi</a></li>';
			}
		?>
	</ul>
	
	<h1><?php echo $title; ?></h1>
