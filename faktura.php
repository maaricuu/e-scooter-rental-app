<?php
require_once('konekcija.php');

$uspesnoPlacanje = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['plati']) && isset($_POST['id_fakture'])) {
        $id_fakture = $_POST['id_fakture'];
        $datum_placanja = date("Y-m-d H:i:s");
                                                                                                                
        $insertP = $db->prepare("INSERT INTO placanje (id_fakture, datum_placanja) VALUES (?, ?)");
        $insertP->bind_param("is", $id_fakture, $datum_placanja);
        $insertP->execute();
        $insertP->close();

        $uspesnoPlacanje = true;
    } else {
        $id_trotineta = $_POST['id_trotineta'];
        $posao = $_POST['posao'];
        $id_servisa = $_POST['servis'];
        $zaposleni = $_POST['zaposleni'];

        $opis_posla = is_array($posao) ? implode(", ", $posao) : $posao;
        $datum_servisiranja = date("Y-m-d H:i:s");

        $cena = 0;
        $select = $db->prepare("SELECT cena_posla FROM servisiranje WHERE opis_posla = ? LIMIT 1");                                     //Uzimanje cene iz baze
        $select->bind_param("s", $opis_posla);
        $select->execute();
        $select->bind_result($cena);
        $select->fetch();
        $select->close();

        $insertF = $db->prepare("INSERT INTO faktura (opis_posla, id_servisa, datum_servisiranja, id_trotineta) VALUES (?, ?, ?, ?)");
        $insertF->bind_param("ssss", $opis_posla, $id_servisa, $datum_servisiranja, $id_trotineta);
        $insertF->execute();                                                                                                            //Pamcenje poslednjeg ID-a
        $id_fakture = $insertF->insert_id;                                                                                              //insert_id
        $insertF->close();

        $insertPS = $db->prepare("INSERT INTO prijava_servisu (opis_posla, id_servisa, id_trotineta) VALUES (?, ?, ?)");
        $insertPS->bind_param("sss", $opis_posla, $id_servisa, $id_trotineta);
        $insertPS->execute();
        $insertPS->close();

        $servis = $id_servisa;
    }
    
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Faktura</title>
    <link rel="stylesheet" href="CSS/fakturaStyle.css">
</head>
<body>
    <a href="interni.php" class="nazad-btn">Nazad</a>

    <?php if ($uspesnoPlacanje): ?>
        <div class="uspesno">Plaćanje uspešno evidentirano!
    <?php else: ?>
        <div class="faktura">
            <h2>Faktura uspešno kreirana</h2>

            <div class="stavka"><span>ID trotinet:</span> <?= htmlspecialchars($id_trotineta) ?></div>
            <div class="stavka"><span>Posao:</span> <?= htmlspecialchars($opis_posla) ?></div>
            <div class="stavka"><span>Servis:</span> <?= htmlspecialchars($servis) ?></div>
            <div class="stavka"><span>Zaposleni:</span> <?= htmlspecialchars($zaposleni) ?></div>
            <div class="datum">Datum: <?= $datum_servisiranja ?></div>
            <div class="cena">Cena: <?= $cena ?> RSD</div>

            <form method="POST">
                <input type="hidden" name="id_fakture" value="<?= $id_fakture ?>">
                <button type="submit" name="plati" class="plati-btn">Plati</button>
            </form>
        </div>
    <?php endif; ?>
</body>
</html>