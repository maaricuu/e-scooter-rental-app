<?php
require_once('konekcija.php');

$res = $db->query("SELECT COUNT(*) AS ukupno FROM korisnik");           //Brojac korisnika
$row = $res ? $res->fetch_assoc() : ['ukupno' => 0];
$broj_korisnika = $row['ukupno'];

?>

<!DOCTYPE html>
<html>
<head>
<title>Pocetna</title>
<link rel="stylesheet" href="CSS/pocetnaStyle.css">
</head>

<body>

 <div class="menu">☰ Menu</div>
<nav class="sidebar">
  <ul>
    <li><a href="pocetna.php">Početna</a></li>
    <li><a href="trotineti.php">Dostupni trotineti</a></li>
    <li><a href="iznajmljivanje.php">Iznajmljivanje</a></li>
    <li><a href="voznja.php">Vožnje</a></li>
    <li><a href="index.php">Odjavi se</a></li>
    
  </ul>
</nav>

<div id="main">
	<div class="hero">
  <h1>Brzo i lako do trotineta</h1>
  <p>Izaberi, vozi, uživaj u Beogradu!</p>
  <a href="trotineti.php" class="dugme">Pogledaj dostupne</a>
</div>

<div class="koraci">
  <h2>Kako funkcioniše</h2>
  <div class="korak">
    <h3>1. Izaberi trotinet</h3>
    <p>Pregledaj slobodne trotinete u svom kraju.</p>
  </div>
  <div class="korak">
    <h3>2. Popuni podatke</h3>
    <p>Unesi osnovne informacije i potvrdi iznajmljivanje.</p>
  </div>
  <div class="korak">
    <h3>3. Vozi</h3>
    <p>Uživaj u vožnji kroz grad!</p>
  </div>
</div>

<div class="statistika">
  <h2>Statistika</h2>
  <p>Ukupno registrovanih korisnika: <strong><?php echo $broj_korisnika; ?></strong></p>
</div>

</div>

</body>
</html>

