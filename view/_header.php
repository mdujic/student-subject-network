<!DOCTYPE html>
<html>
<head>
	<meta charset="utf8">
	<title>Ime aplikacije</title>
	<link rel="stylesheet" href="css/style.css">
</head>
<body>
	<h1>Ime aplikacije</h1>

	<nav>
		<ul>
			<li><a href="index.php?rt=subject">Popis svih predmeta</a></li>
			<li><a href="index.php?rt=my_projects">Moji predmeti</a></li>
			<li><a href="index.php?rt=projects/create_project">Kreiraj novi predmet</a></li>
			<li><a href="index.php?rt=users/logout">Odjavi se!</a></li>
		</ul>
	</nav>
	<h1><?php echo $title; ?></h1>