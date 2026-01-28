<?php
session_start();
require_once('konekcija.php');

$trotinet_id = $_GET['trotinet'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ime = trim($_POST['ime']);
    $prezime = trim($_POST['prezime']);
    $email = trim($_POST['email']);
    $telefon = trim($_POST['telefon']);
    $trotinet = trim($_POST['trotinet_id']);

    if ($ime !== '' && $prezime !== '' && $email !== '' && $telefon !== '' && $trotinet !== '') {
        
        $upitID = $db->query("SELECT id_korisnika FROM korisnik ORDER BY CAST(SUBSTRING(id_korisnika, 2) AS UNSIGNED) DESC LIMIT 1");  //Selektovanje poslednjeg ID-a 
        $nextID = ($upitID->num_rows > 0) ? intval(substr($upitID->fetch_assoc()['id_korisnika'], 1)) + 1 : 1;                         //i formiranje novog            
        $id_korisnika = "k" . $nextID;

        $insertID = $db->prepare("INSERT INTO korisnik (id_korisnika, k_ime, k_prezime, k_email, br_telefona) VALUES (?, ?, ?, ?, ?)");
        $insertID->bind_param("sssss", $id_korisnika, $ime, $prezime, $email, $telefon);
        $insertID->execute();

        $upitV = $db->query("SELECT id_voznje FROM voznja ORDER BY CAST(SUBSTRING(id_voznje, 2) AS UNSIGNED) DESC LIMIT 1");           //Selektovanje poslednjeg ID-a 
        $nextV = ($upitV->num_rows > 0) ? intval(substr($upitV->fetch_assoc()['id_voznje'], 1)) + 1 : 1;                               //i formiranje novog
        $id_voznje = "v" . $nextV;

        $insertV = $db->prepare("INSERT INTO voznja (id_voznje, id_korisnika, id_trotineta, vreme_pocetka_voznje, cena_po_minutu) VALUES (?, ?, ?, NOW(), 10.00)");
        $insertV->bind_param("sss", $id_voznje, $id_korisnika, $trotinet);
        $insertV->execute();

        $updateT = $db->prepare("UPDATE trotinet SET status = 'zauzet' WHERE id_trotineta = ?");                                        //Promena statusa trotineta
        $updateT->bind_param("s", $trotinet);
        $updateT->execute();

        $_SESSION['id_voznje'] = $id_voznje;
        $_SESSION['id_korisnika'] = $id_korisnika;
        $_SESSION['id_trotineta'] = $trotinet;

        echo "<script>document.addEventListener('DOMContentLoaded',()=>{document.getElementById('formContainer').style.display='none';document.getElementById('popup').style.display='block';});</script>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Iznajmljivanje</title>
  <link rel="stylesheet" href="CSS/iznajmljivanjeStyle.css">
</head>

<body>

    <div class="menu">☰ Menu</div>
    <nav class="sidebar">
        <ul>
            <li><a href="pocetna.php">Početna</a></li>
            <li><a href="trotineti.php">Dostupni trotineti</a></li>
            <li><a href="iznajmljivanje.php">Iznajmljivanje</a></li>
            <li><a href="zavrsi_voznju.php">Vožnje</a></li>
            <li><a href="index.php">Odjavi se</a></li>
        </ul>
    </nav>

    <div class="wrapper" id="wrapper">
        <div class="form-container" id="formContainer">
            <h2>Zahtev za iznajmljivanje</h2>
            <form id="rentalForm" method="POST" action="">
                <input type="text" name="ime" placeholder="Ime" required>
                <input type="text" name="prezime" placeholder="Prezime" required>
                <input type="text" name="trotinet_id" placeholder="Trotinet ID" value="<?php echo htmlspecialchars($trotinet_id); ?>" required readonly>
                <input id="email" type="email" name="email" value="<?php echo isset($_SESSION['user_email']) ? htmlspecialchars($_SESSION['user_email']) : ''; ?>" readonly>

                <input type="tel" name="telefon" placeholder="Broj telefona" required>

                <div class="button-group">
                    <button type="submit">Pošalji zahtev za registraciju</button>
                    <button type="reset">Resetuj formu</button>
                </div>
            </form>
        </div>

        <div class="popup" id="popup">
            <h3>Vaš zahtev za iznajmljivanje je uspešan!</h3>
            <button class="dugme-zavrsi" type="submit" onclick="window.location.href='zavrsi_voznju.php'">Završi vožnju</button>
        </div>
    </div>

    <footer>
        <div class="footer-content">
            <p>Korisnički centar: 060-0000-000 <a href="mailto:korisnickicentar@gmail.com">korisnickicentar@gmail.com</a></p>
        </div>
    </footer>

    <script>
const form = document.getElementById('rentalForm');
const popup = document.getElementById('popup');
const formContainer = document.getElementById('formContainer');

form.addEventListener('submit', function() {
    
});
    </script>
</body>
</html>
