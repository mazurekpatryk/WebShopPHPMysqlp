<?php include('naglowek.php'); ?>

<?php 
        if(!isset($_SESSION['udanarejestracja']))
        {
            header('Location: index.php');
            exit();
        }
        else
        {
            unset($_SESSION['udanarejestracja']);
        }

        //usuwanie zmiennych pamietanych wartosci wpisane do formularza
        	//Usuwanie zmiennych pamiętających wartości wpisane do formularza
        if (isset($_SESSION['fr_login'])) unset($_SESSION['fr_login']);
        if (isset($_SESSION['fr_email'])) unset($_SESSION['fr_email']);
        if (isset($_SESSION['fr_haslo1'])) unset($_SESSION['fr_haslo1']);
        if (isset($_SESSION['fr_haslo2'])) unset($_SESSION['fr_haslo2']);
        if (isset($_SESSION['fr_regulamin'])) unset($_SESSION['fr_regulamin']);
        
        //Usuwanie błędów rejestracji
        if (isset($_SESSION['fr_login'])) unset($_SESSION['fr_login']);
        if (isset($_SESSION['e_email'])) unset($_SESSION['e_email']);
        if (isset($_SESSION['e_haslo'])) unset($_SESSION['e_haslo']);
        if (isset($_SESSION['e_regulamin'])) unset($_SESSION['e_regulamin']);
    
?>


    <div class="p-5 m-5">
        <div class="d-flex justify-content-center">
            <h1>Udało się zarejestrować nowego użytkownika!</h1>
        </div>
    </div>

<?php include('stopka.php'); ?>