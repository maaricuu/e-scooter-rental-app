<?php
require_once('konekcija.php');


$servisi = [];                                                                                  //Pravljenje niza za servise
$selectS = $db->query("SELECT id_servisa, naziv_servisa FROM servis");
while ($row = $selectS->fetch_assoc()) {
    $servisi[] = $row;
}

$zaposleni = [];                                                                                //Pravljenje niza za zaposlene
$selectZ = $db->query("SELECT ime_zaposlenog, prezime_zaposlenog FROM zaposleni");
while ($row = $selectZ->fetch_assoc()) {
    $zaposleni[] = $row;
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Interni Interface</title>
    <link rel="stylesheet" href="CSS/interniStyle.css">
</head>
<body>
    <div class="container">
        <h2>Dobrodošli u interni interface!</h2>
        <p>Ovo je sadržaj samo za zaposlene.</p>

        <div class="scroll-tabela">
            <table>
                <tr>
                    <th>ID trotinet</th>
                    <th>Opis prijave</th>
                </tr>
                <?php
                $q = $db->query("SELECT id_trotineta, opis_prijave
                                 FROM korisnicka_prijava
                                 WHERE opis_prijave IN ('ostecenje', 'baterija')
                                 ORDER BY id_prijave DESC");
                                 
                while ($row = $q->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row['id_trotineta']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['opis_prijave']) . "</td>";
                    echo "</tr>";
                }
                
                ?>
            </table>
        </div>

        <form class="forma-blok" action="faktura.php" method="POST">
            <input type="text" name="id_trotineta" placeholder="ID trotinet" required>

            <label>Posao:</label>
            <div class="checkbox-grupa">
                <label><input type="checkbox" name="posao[]" value="popravka"> Popravka</label>
                <label><input type="checkbox" name="posao[]" value="punjenje"> Punjenje</label>
                <label><input type="checkbox" name="posao[]" value="odrzavanje"> Održavanje</label>
            </div>

            <label for="servis">Servis:</label>
            <select name="servis" id="servis" required>
                <option value="" disabled selected>-- Izaberite servis --</option>
                <?php foreach ($servisi as $s): ?>
                    <option value="<?php echo htmlspecialchars($s['id_servisa']); ?>">
                        <?php echo htmlspecialchars($s['naziv_servisa']); ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <label for="zaposleni">Zaposleni:</label>
            <select name="zaposleni" id="zaposleni" required>
                <option value="" disabled selected>-- Izaberite zaposlenog --</option>
                <?php foreach ($zaposleni as $z): ?>
                    <option value="<?php echo htmlspecialchars($z['ime_zaposlenog']); ?>">
                        <?php echo htmlspecialchars($z['ime_zaposlenog'] . ' ' . $z['prezime_zaposlenog']); ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <button type="submit">Pošalji</button>
        </form>
        <a href="index.php" class="odjavi-btn">Odjavi se</a>
    </div>
</body>
</html>