<?php

    session_start();

    if ((!isset($_POST['login'])) || (!isset($_POST['haslo'])))
	{
		header('Location: index.php');
		exit();
	}

    require_once "polaczenie.php";

    $polaczenie = @new mysqli($host, $user, $pass, $conn);

    if($polaczenie->connect_errno!=0){
      echo "Error: ".$polaczenie->connect_errno;
    }
    else{
        $login = $_POST['login'];
        $haslo = $_POST['haslo'];

        $login = htmlentities($login, ENT_QUOTES, "UTF-8");
		

        $sql = "SELECT * FROM uzytkownik WHERE login='$login' AND haslo='$haslo'";
        

        if($rezultat = @$polaczenie->query(
            sprintf("SELECT * FROM uzytkownik WHERE login='%s'", 
            mysqli_real_escape_string($polaczenie,$login)
            ))){
            $ilu_uzytkownikow = $rezultat->num_rows;

            if($ilu_uzytkownikow>0){
                $wiersz = $rezultat->fetch_assoc();
                if(password_verify($haslo, $wiersz['haslo']))
                {     
                    $_SESSION['zalogowany'] = true;                    
                    $_SESSION['login'] = $wiersz['login'];
                    $_SESSION['id_uzytkownika'] = $wiersz['id'];

                    $id_uzytkownika = $_SESSION['id_uzytkownika'];

                    $sql = "SELECT * FROM uzytkownik WHERE id=$id_uzytkownika";
                    $result_dane_uzytkownika = $polaczenie->query($sql);
                    $row = $result_dane_uzytkownika->fetch_assoc();
                    $tym = $row['admin'];
                    $_SESSION['uprawnienia'] = "$tym";
                    
                    $row = $result_dane_uzytkownika->fetch_assoc();

                    unset($_SESSION['blad']);
                    $rezultat->close();
                    $result_dane_uzytkownika->close();
                    header('Location: index.php');
                }
                else{
                    $_SESSION['blad'] = '<span style="color:red">Nieprawidłowy login lub hasło!</span>';
                    header('Location: logowanie.php');
                }
            }
            else{
                $_SESSION['blad'] = '<span style="color:red">Nieprawidłowy login lub hasło!</span>';
				header('Location: logowanie.php');
            }

        }


        $polaczenie->close();
    }





?>