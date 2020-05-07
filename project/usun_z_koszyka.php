<?php

    session_start();

    require_once "polaczenie.php";

    $polaczenie = @new mysqli($host, $user, $pass, $conn);

    if($polaczenie->connect_errno!=0){
      echo "Error: ".$polaczenie->connect_errno;
    }
    else{
        $id_produktu = $_POST['id_produktu_w_koszyku'];
        
        
        // $znajdz_sqpl="SELECT * FROM koszyk WHERE id_k=$id_produktu";
        // $result_znajdz_sqpl= $polaczenie->query($znajdz_sqpl);

        

            if($polaczenie->query("DELETE FROM koszyk WHERE id_k=$id_produktu"))
            {
                header('Location: koszyk.php');
            }


        $polaczenie->close();
    }



?>
