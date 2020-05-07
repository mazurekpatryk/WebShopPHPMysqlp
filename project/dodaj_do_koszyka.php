<?php

    session_start();

    require_once "polaczenie.php";

    $polaczenie = @new mysqli($host, $user, $pass, $conn);

    if($polaczenie->connect_errno!=0){
      echo "Error: ".$polaczenie->connect_errno;
    }
    else{
        $id_uzytkownika = $_SESSION['id_uzytkownika'];
        $id_produktu = $_POST['id_produktu'];
        $ilosc = $_POST['ilosc'];
        
        
        $czy_jest_taki_produkt_w_koszyku="SELECT * FROM koszyk WHERE produkt_id=$id_produktu AND uzytkownik_id=$id_uzytkownika";
        $result_czy_jest_taki_produkt_w_koszyku= $polaczenie->query($czy_jest_taki_produkt_w_koszyku);

        $row_cnt = $result_czy_jest_taki_produkt_w_koszyku->num_rows;
        
        if($row_cnt>0)
        {
            $duplikat="SELECT * FROM koszyk WHERE produkt_id=$id_produktu AND uzytkownik_id=$id_uzytkownika";
            $result_duplikat = $polaczenie->query($duplikat);
            $row = $result_duplikat->fetch_assoc();
            $stara_ilosc = $row["ilosc"];

            if($polaczenie->query("UPDATE koszyk SET ilosc = $stara_ilosc + $ilosc WHERE produkt_id=$id_produktu AND uzytkownik_id=$id_uzytkownika")){
                header('Location: koszyk.php');
            }else{
                throw new Exception($polaczenie->error);
            }

        }else{
            //dodajemy 
            if($polaczenie->query("INSERT INTO koszyk VALUES (NULL, '$ilosc', '$id_produktu', '$id_uzytkownika')")){
                header('Location: koszyk.php');
            }else{
                throw new Exception($polaczenie->error);
            }
        }

        $polaczenie->close();
    }



?>