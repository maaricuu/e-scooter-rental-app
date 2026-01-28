<?php
require_once('konekcija.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['tip_problema'])) {
    $opis = $_POST['tip_problema'];

    $upitP = $db->query("SELECT id_korisnika, id_trotineta
                         FROM voznja
                         WHERE vreme_zavrsetka_voznje IS NOT NULL
                         ORDER BY vreme_zavrsetka_voznje DESC
                         LIMIT 1");

    if ($upitP && $upitP->num_rows > 0) {
        $row = $upitP->fetch_assoc();
        $id_korisnika = $row['id_korisnika'];
        $id_trotineta = $row['id_trotineta'];
                                                                                                                            
        $insertP = $db->prepare("INSERT INTO korisnicka_prijava (opis_prijave, id_korisnika, id_trotineta)                
                                 VALUES (?, ?, ?)");
        if ($insertP) {                                                                                             //Upis korisnicke prijave
            $insertP->bind_param("sss", $opis, $id_korisnika, $id_trotineta);
            $insertP->execute();
        } else {
            echo "Greška u pripremi upita.";
        }
    } else {
        echo "Nema završene vožnje za prijavu.";
    }
} else {
    echo "Neispravan zahtev.";
}
?>
