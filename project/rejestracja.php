<?php include('naglowek.php'); ?>

<?php 


    if(isset($_POST['email'])){
        $wszystko_ok=true;

        $login = $_POST['login'];


        //sprawdz login
        if((strlen($login)<3) || (strlen($login)>20)){
            $wszystko_ok=false;
            $_SESSION['e_login']="Login musi posiadać od 3 do 20 znaków!";
        }

        if (ctype_alnum($login)==false){
            $wszystko_ok=false;
            $_SESSION['e_login']="Login może składać się tylko z liter i cyfr (bez polskich znaków)";
        }

        //sprawdz email
        $email = $_POST['email'];
        $emailB = filter_var($email, FILTER_SANITIZE_EMAIL);

        if((filter_var($emailB, FILTER_VALIDATE_EMAIL)==false) || ($emailB!=$email))
        {
            $wszystko_ok=false;
            $_SESSION['e_email']="Podaj poprawny email!";
        }


        $haslo1 = $_POST['haslo1'];
        $haslo2 = $_POST['haslo2'];

        if(strlen($haslo1)<8 || strlen($haslo1)>20){
            $wszystko_ok=false;
            $_SESSION['e_haslo1']="Hasło musi posiadać od 8 do 20 znaków";
        }

        if($haslo1!=$haslo2){
            $wszystko_ok=false;
            $_SESSION['e_haslo2']="Hasło są różne";
        }

        $haslo_hash = password_hash($haslo1, PASSWORD_DEFAULT);

        if(!isset($_POST['regulamin'])){
            $wszystko_ok=false;
            $_SESSION['e_regulamin']="Potwierdź akceptacje regulaminu";
        }

        $ulica = $_POST['ulica'];
        $numer = $_POST['numer'];
        $miasto = $_POST['miasto'];
        $kod_pocztowy = $_POST['kod_pocztowy'];
        $numer_telefonu = $_POST['numer_telefonu'];

        if(strlen($ulica)<=0){
            $wszystko_ok=false;
            $_SESSION['e_ulica']="Proszę podać ulicę";
        }

        if(strlen($numer)<=0){
            $wszystko_ok=false;
            $_SESSION['e_numer']="Proszę podać numer lokalu";
        }

        if(strlen($miasto)<=0){
            $wszystko_ok=false;
            $_SESSION['e_miasto']="Proszę podać nazwę miasta";
        }

        if(strlen($kod_pocztowy)<=0){
            $wszystko_ok=false;
            $_SESSION['e_kod_pocztowy']="Proszę podać ulicę";
        }

        if(strlen($numer_telefonu)<=0){
            $wszystko_ok=false;
            $_SESSION['e_numer_telefonu']="Proszę podać numer telefonu";
        }


        //Zapamietaj wprowadzone dane
        $_SESSION['fr_login'] = $login;
        $_SESSION['fr_email'] = $email;
        $_SESSION['fr_haslo1'] = $haslo1;
        $_SESSION['fr_haslo2'] = $haslo2;
        $_SESSION['fr_ulica'] = $ulica;
        $_SESSION['fr_numer'] = $numer;
        $_SESSION['fr_miasto'] = $miasto;
        $_SESSION['fr_kod_pocztowy'] = $kod_pocztowy;
        $_SESSION['fr_numer_telefonu'] = $numer_telefonu;
        if(isset($_POST['regulamin'])) $_SESSION['fr_regulamin'] = true;

        require_once "polaczenie.php";
        mysqli_report(MYSQLI_REPORT_STRICT);
        
        try{
            $polaczenie = new mysqli($host, $user, $pass, $conn);
            if($polaczenie->connect_errno!=0){
                throw new Exception(mysqli_connect_errno());
            }
            else{
                //czy istnieje taki email?
                $rezultat = $polaczenie->query("SELECT id FROM uzytkownik WHERE email='$email'");

                if(!$rezultat) throw new Exception($polaczenie->error);

                $ile_takich_maili = $rezultat->num_rows;
                if($ile_takich_maili>0){
                    $wszystko_ok=false;
                    $_SESSION['e_email']="Istnieje już konto przypisane do tego adresu e-mail";
                }

                
                //czy istnieje taki login?
                $rezultat = $polaczenie->query("SELECT id FROM uzytkownik WHERE login='$login'");

                if(!$rezultat) throw new Exception($polaczenie->error);

                $ile_takich_loginow = $rezultat->num_rows;
                if($ile_takich_loginow>0){
                    $wszystko_ok=false;
                    $_SESSION['e_login']="Istnieje już konto przypisane do tego loginu";
                }

                if($wszystko_ok==true)
                {
                    //dodajemy uzytkownika do bazy danych
                    if($polaczenie->query("INSERT INTO uzytkownik VALUES (NULL, '$login', '$haslo_hash', '$email', 'NULL')")){
                        

                        $sql_login = "SELECT * FROM uzytkownik WHERE login='$login'";
                        if($result_login = $polaczenie->query($sql_login))
                        {
                            while($row = $result_login->fetch_assoc()):
                                $id_uzytkownika = $row['id'];
    
                                if($polaczenie->query("INSERT INTO adres VALUES (NULL, '$ulica', '$numer', '$miasto', '$kod_pocztowy', '$id_uzytkownika')") && 
                                $polaczenie->query("INSERT INTO kontakt VALUES (NULL, '$numer_telefonu', '$email', '$id_uzytkownika')")
                                ){
                                    $_SESSION['udanarejestracja']=true;
                                    header('Location: witamy.php');
                                }else{
                                    throw new Exception($polaczenie->error);
                                }
                            endwhile; 
                        }else{
                            throw new Exception($polaczenie->error);
                        }
  
                    }else{
                        throw new Exception($polaczenie->error);
                    }

                }

                $polaczenie->close();
            }
        }
        catch(Exception $e)
        {
            echo '<span style="color:red;">Błąd serwera! Przepraszamy za niedogodności i prosimy o rejestrację w innym terminie!</span>';
        }


    }
?>

<?php if($_SESSION['zalogowany']) { header('Location: index.php'); echo "CYCKI"; }else{?>
    <div class="p-5 m-5">
        <div class="d-flex justify-content-center">
            <form method="post">
            <div class="form-group">
                    <label>Login</label>
                    <input type="text" class="form-control" value="<?php if(isset($_SESSION['fr_login'])){ echo $_SESSION['fr_login']; unset($_SESSION['fr_login']); } ?>" name="login" />
                    <?php 
                        if(isset($_SESSION['e_login'])){
                            echo'<div class="error text-danger">'.$_SESSION['e_login'].'</div>';
                            unset($_SESSION['e_login']);
                        }
                    ?>
            </div>

            <div class="form-group">
                    <label>E-mail</label>
                    <input type="text" class="form-control" value="<?php if(isset($_SESSION['fr_email'])){ echo $_SESSION['fr_email']; unset($_SESSION['fr_email']); } ?>" name="email" />
                    <?php 
                        if(isset($_SESSION['e_email'])){
                            echo'<div class="error text-danger">'.$_SESSION['e_email'].'</div>';
                            unset($_SESSION['e_email']);
                        }
                    ?>
            </div>
            
            <div class="form-group">
                <label>Hasło</label>
                <input type="password" class="form-control" value="<?php if(isset($_SESSION['fr_haslo1'])){ echo $_SESSION['fr_haslo1']; unset($_SESSION['fr_haslo1']); } ?>" name="haslo1" />
                <?php 
                        if(isset($_SESSION['e_haslo1'])){
                            echo'<div class="error text-danger">'.$_SESSION['e_haslo1'].'</div>';
                            unset($_SESSION['e_haslo1']);
                        }
                ?>
            </div> 

            <div class="form-group">
                <label>Hasło</label>
                <input type="password" class="form-control" value="<?php if(isset($_SESSION['fr_haslo2'])){ echo $_SESSION['fr_haslo2']; unset($_SESSION['fr_haslo2']); } ?>" name="haslo2" />
                <?php 
                        if(isset($_SESSION['e_haslo2'])){
                            echo'<div class="error text-danger">'.$_SESSION['e_haslo2'].'</div>';
                            unset($_SESSION['e_haslo2']);
                        }
                ?>
            </div>
            
            <div class="form-group">
                <label>Ulica</label>
                <input type="text" class="form-control" value="<?php if(isset($_SESSION['fr_ulica'])){ echo $_SESSION['fr_ulica']; unset($_SESSION['fr_ulica']); } ?>" name="ulica" />
                <?php 
                        if(isset($_SESSION['e_ulica'])){
                            echo'<div class="error text-danger">'.$_SESSION['e_ulica'].'</div>';
                            unset($_SESSION['e_ulica']);
                        }
                ?>
            </div> 

            <div class="form-group">
                <label>Numer</label>
                <input type="text" class="form-control" value="<?php if(isset($_SESSION['fr_numer'])){ echo $_SESSION['fr_numer']; unset($_SESSION['fr_numer']); } ?>" name="numer" />
                <?php 
                        if(isset($_SESSION['e_numer'])){
                            echo'<div class="error text-danger">'.$_SESSION['e_numer'].'</div>';
                            unset($_SESSION['e_numer']);
                        }
                ?>
            </div> 

            <div class="form-group">
                <label>Miasto</label>
                <input type="text" class="form-control" value="<?php if(isset($_SESSION['fr_miasto'])){ echo $_SESSION['fr_miasto']; unset($_SESSION['fr_miasto']); } ?>" name="miasto" />
                <?php 
                        if(isset($_SESSION['e_miasto'])){
                            echo'<div class="error text-danger">'.$_SESSION['e_miasto'].'</div>';
                            unset($_SESSION['e_miasto']);
                        }
                ?>
            </div>  
            
            <div class="form-group">
                <label>Kod pocztowy</label>
                <input type="number"  class="form-control" value="<?php if(isset($_SESSION['fr_kod_pocztowy'])){ echo $_SESSION['fr_kod_pocztowy']; unset($_SESSION['fr_kod_pocztowy']); } ?>" name="kod_pocztowy" />
                <?php 
                        if(isset($_SESSION['e_kod_pocztowy'])){
                            echo'<div class="error text-danger">'.$_SESSION['e_kod_pocztowy'].'</div>';
                            unset($_SESSION['e_kod_pocztowy']);
                        }
                ?>
            </div>
            
            <div class="form-group">
                <label>Numer telefonu</label>
                <input type="number" class="form-control" value="<?php if(isset($_SESSION['fr_numer_telefonu'])){ echo $_SESSION['fr_numer_telefonu']; unset($_SESSION['fr_numer_telefonu']); } ?>" name="numer_telefonu" />
                <?php 
                        if(isset($_SESSION['e_numer_telefonu'])){
                            echo'<div class="error text-danger">'.$_SESSION['e_numer_telefonu'].'</div>';
                            unset($_SESSION['e_numer_telefonu']);
                        }
                ?>
            </div> 

            <div class="form-group">
                <label>
                    <input type="checkbox" name="regulamin" <?php if(isset($_SESSION['fr_regulamin'])){ echo "checked"; unset($_SESSION['fr_regulamin']); } ?> />
                Akceptuje regulamin</label>
                <?php 
                        if(isset($_SESSION['e_regulamin'])){
                            echo'<div class="error text-danger">'.$_SESSION['e_regulamin'].'</div>';
                            unset($_SESSION['e_regulamin']);
                        }
                ?>
            </div> 
            
            <button type="submit" class="btn btn-primary btn-lg btn-block">Zarejestruj się</button>

            </form>
        </div>

    </div>

                    <?php } ?>
<?php include('stopka.php'); ?>