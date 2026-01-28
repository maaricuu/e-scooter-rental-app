<?php
session_start();
require_once('konekcija.php');

$voznje = [];

$selectV = $db->query("SELECT v.id_voznje,v.id_korisnika,v.id_trotineta,v.vreme_pocetka_voznje,v.vreme_zavrsetka_voznje,v.cena_po_minutu,
                              k.k_ime,k.datum_registracije
                       FROM voznja v
                       JOIN korisnik k ON v.id_korisnika = k.id_korisnika
                       ORDER BY v.vreme_pocetka_voznje DESC");

while ($row = mysqli_fetch_assoc($selectV)) {                                             //Pravljenje niza za voznje
    $voznje[] = $row;
}

$upit = $db->prepare("SELECT vreme_pocetka_voznje, vreme_zavrsetka_voznje, cena_po_minutu
                      FROM voznja
                      WHERE id_korisnika = ? AND vreme_zavrsetka_voznje IS NOT NULL
                      ORDER BY vreme_zavrsetka_voznje DESC
                      LIMIT 1");
$upit->bind_param("s", $_SESSION['id_korisnika']);                                         //Formiranje ukupne cene
$upit->execute();
$rez = $upit->get_result();

if ($row = $rez->fetch_assoc()) {
    $start = strtotime($row['vreme_pocetka_voznje']);
    $end   = strtotime($row['vreme_zavrsetka_voznje']);
    $minuti = ceil(($end - $start) / 60);
    $cena_poslednje = $minuti * $row['cena_po_minutu'];
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Vožnje</title>
  <link rel="stylesheet" href="CSS/voznjaStyle.css">
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

<form class="forma-voznja" method="POST" action="prijavi_problem.php">
  <h2>Informacije o vožnji:</h2>

  <div class="gornji-blok">

    <div class="scroll-tabela">
      <table>
        <tr>
          <th>Korisnik ID</th>
          <th>Trotinet ID</th>
          <th>Ime korisnika</th>
          <th>Datum registracije</th>
          <th>Cena vožnje</th>
        </tr>

        <?php foreach ($voznje as $v): ?>
        <tr>
          <td><?= htmlspecialchars($v['id_korisnika']) ?></td>
          <td><?= htmlspecialchars($v['id_trotineta']) ?></td>
          <td><?= htmlspecialchars($v['k_ime']) ?></td>
          <td><?= htmlspecialchars($v['datum_registracije']) ?></td>
          <td>
            <?php
            if ($v['vreme_zavrsetka_voznje']) {
                $start = strtotime($v['vreme_pocetka_voznje']);
                $end   = strtotime($v['vreme_zavrsetka_voznje']);
                $minuti = ceil(($end - $start) / 60);
                $cena = $minuti * $v['cena_po_minutu'];
                echo $cena . " RSD";
            } else {
                echo "Vožnja nije završena";
            }
            ?>
          </td>
        </tr>
        <?php endforeach; ?>
      </table>
    </div>

    <div class="cena">
      <h3>Cena vaše poslednje vožnje:</h3>
      <p><strong>
        <?php
        if ($cena_poslednje !== null) {
            echo $cena_poslednje . " RSD";
        } else {
            echo "Nema završenih vožnji";
        }
        ?>
      </strong></p>
    </div>

  </div>

  <div class="prijava">
    <h3>Prijavite problem sa vožnjom</h3>
    <label for="tip_problema">Odaberite vrstu problema:</label><br>
    <select name="tip_problema" id="tip_problema" required>
      <option value="">-- Izaberite --</option>
      <option value="baterija">Trotinet ima praznu bateriju</option>
      <option value="ostecenje">Trotinet je fizički oštećen</option>
      <option value="placanje">Imate poteškoće sa plaćanjem</option>
    </select><br><br>
    <button type="submit">Prijavi</button>
  </div>
</form>

<footer>
  <div class="footer-content">
    <p>
      Korisnički centar: 060-0000-000
      <a href="mailto:korisnickicentar@gmail.com">korisnickicentar@gmail.com</a>
    </p>
  </div>
</footer>

<script>
document.querySelector("form").addEventListener("submit", function(e) {
  e.preventDefault();
  const forma = new FormData(this);
  fetch("prijavi_problem.php", {
    method: "POST",
    body: forma
  }).then(() => {
    alert("Vaša prijava je poslata!");
  });
});
</script>

</body>
</html>
