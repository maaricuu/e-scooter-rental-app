<?php
session_start();
require_once('konekcija.php');

$id_voznje     = $_SESSION['id_voznje'];
$id_trotineta  = $_SESSION['id_trotineta'];
$id_korisnika  = $_SESSION['id_korisnika'];


$vreme_zavrsetka = date("Y-m-d H:i:s");                                                         //Upis vremena završetka vožnje
$update = $db->prepare("UPDATE voznja                                                   
                        SET vreme_zavrsetka_voznje = ? 
                        WHERE id_voznje = ?");
$update->bind_param("ss", $vreme_zavrsetka, $id_voznje);
$update->execute();



$upitT = $db->query("SELECT id_transakcije                                                      
                     FROM transakcija 
                     ORDER BY CAST(SUBSTRING(id_transakcije, 6) AS UNSIGNED) DESC 
                     LIMIT 1");

$nextT = ($upitT->num_rows > 0) ? intval(substr($upitT->fetch_assoc()['id_transakcije'], 5)) + 1 : 1;        //Kreiranje nove transakcije
$id_transakcije = "trans" . str_pad($nextT, 3, "0", STR_PAD_LEFT);

$insertT = $db->prepare("INSERT INTO transakcija (id_transakcije, id_voznje, id_korisnika, id_trotineta, datum_transakcije)
                         VALUES (?, ?, ?, ?, NOW())");
$insertT->bind_param("ssss", $id_transakcije, $id_voznje, $id_korisnika, $id_trotineta);
$insertT->execute();



$ut = $db->prepare("UPDATE trotinet 
                    SET status = 'slobodan' 
                    WHERE id_trotineta = ?");
$ut->bind_param("s", $id_trotineta);                                            //Promena statusa trotineta
$ut->execute();

header("Location: voznja.php");
exit;
?>
