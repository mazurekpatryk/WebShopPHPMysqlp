<?php

    require_once "polaczenie.php";
    $polaczenie = @new mysqli($host, $user, $pass, $conn);

    if($polaczenie->connect_errno!=0)
    {
      echo "Error: ".$polaczenie->connect_errno;
    }

?>

<?php include('naglowek.php'); ?>

<?php
    $id_wybranej_kategori = (int) $_GET['id'];
    $sql_produkty = "SELECT Id, Nazwa, Cena, Opis, sciezka_img, kategoria_id FROM produkty WHERE kategoria_id=$id_wybranej_kategori";
    $result_produkty = $polaczenie->query($sql_produkty);

    $sql_kategorie = "SELECT Id, Nazwa FROM kategorie";
    $result_kategorie = $polaczenie->query($sql_kategorie);

?>

<?php include('produkty.php'); ?>
<?php include('stopka.php'); ?>