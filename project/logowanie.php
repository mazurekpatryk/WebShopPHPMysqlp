<?php    include('naglowek.php'); ?>

<?php if($_SESSION['zalogowany']) { header('Location: index.php'); echo "CYCKI"; }else{?>
    <div class="p-5 m-5">
        <div class="d-flex justify-content-center">
            <form action="zaloguj.php" method="post">
            <div class="form-group">
                    <label>Login</label>
                    <input type="text" class="form-control" aria-describedby="loginHelp" name="login">
            </div>
            
            <div class="form-group">
                <label>Hasło</label>
                <input type="password" class="form-control" name="haslo" />
            </div> 

            <button type="submit" class="btn btn-primary btn-lg btn-block">Zaloguj</button>
                <p><?php
                    if(isset($_SESSION['blad']))	
                        echo $_SESSION['blad'];
                ?></p>
                <a href="rejestracja.php">Jeśli nie posiadasz konta zarejestruj się</a>
            </form>
        </div>
    </div>

    <?php } ?>
<?php include('stopka.php'); ?>