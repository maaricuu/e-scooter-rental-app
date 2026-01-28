<!DOCTYPE html>
<html>
<head>
<title>Trotineti</title>
<link rel="stylesheet" href="CSS/trotinetiStyle.css">
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
    <h1 class="naslov">Dostupni trotineti</h1>
    <div class="grid">
        <?php
        $lokacije = [
            "Kalemegdan", "Tašmajdan park", "Ada Ciganlija", "Knez Mihailova", "Slavija",
            "Dorćol", "Zemun", "Banovo brdo", "Karaburma", "Vračar",
            "Blok 70", "Autokomanda", "Studentski trg", "Botanička bašta", "Palilula"
        ];

        for ($i = 1; $i <= 15; $i++) {
            $oznaka = 't' . str_pad($i, 3, '0', STR_PAD_LEFT);
            $baterija = rand(60, 100);
            $lokacija = $lokacije[$i - 1];

            echo "
            <div class='kartica'>
                <div class='header'>
                    <h3>$oznaka</h3>
                </div>
                <div class='info'>
                    <p><strong>Baterija:</strong> $baterija%</p>
                    <p><strong>Lokacija:</strong> $lokacija</p>
                    <p><strong>Status:</strong> slobodan</p>
                </div>
                <form action='iznajmljivanje.php' method='GET'>
                    <input type='hidden' name='trotinet' value='$oznaka'>
                    <button type='submit'>Izaberi</button>
                </form>
            </div>
            ";
        }
        ?>
    </div>
</div>

<footer>
     <div class="footer-content">
         <p>Korisnicki centar:060-0000-000 <a href="mailto:info@tvojprojekat.com">korisnickicentar@gmail.com</a></p> 
     </div> 
</footer>

</body>
</html>
