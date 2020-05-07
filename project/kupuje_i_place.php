<?php

    session_start();

    require_once "polaczenie.php";

    $polaczenie = @new mysqli($host, $user, $pass, $conn);

    if($polaczenie->connect_errno!=0){
      echo "Error: ".$polaczenie->connect_errno;
    }
    else{
        $id_uzytkownika = $_SESSION['id_uzytkownika'];
        
        
        
        if(
        $polaczenie->query("INSERT INTO zamowienia (id_produktu, id_uzytkownika, ilosc) SELECT produkt_id, uzytkownik_id, ilosc  FROM koszyk WHERE uzytkownik_id=$id_uzytkownika") && 
        $polaczenie->query("DELETE FROM koszyk WHERE uzytkownik_id=$id_uzytkownika")
        ){
            header('Location: dziekowanie.php');
        }else{
            throw new Exception($polaczenie->error);
        }

        $polaczenie->close();
    }



?>