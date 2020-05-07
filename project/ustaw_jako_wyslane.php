<?php

    session_start();

    require_once "polaczenie.php";

    $polaczenie = @new mysqli($host, $user, $pass, $conn);

    if($polaczenie->connect_errno!=0){
      echo "Error: ".$polaczenie->connect_errno;
    }
    else{
        $id_produktu = $_POST['id_produktu_zamowionego'];
        
        
        // $znajdz_sqpl="SELECT * FROM koszyk WHERE id_k=$id_produktu";
        // $result_znajdz_sqpl= $polaczenie->query($znajdz_sqpl);

        

            if($polaczenie->query("UPDATE zamowienia SET status='1' WHERE id_z=$id_produktu"))
            {
                header('Location: panel_admini.php');
            }


        $polaczenie->close();
    }



?>
