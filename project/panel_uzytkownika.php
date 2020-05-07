<?php
    error_reporting(0);
    session_start();

    require_once "polaczenie.php";
    $polaczenie = @new mysqli($host, $user, $pass, $conn);

    if($polaczenie->connect_errno!=0)
    {
      echo "Error: ".$polaczenie->connect_errno;
    }

?>

<?php
    $id_uzytkownika = $_SESSION['id_uzytkownika'];

    $sql = "SELECT * FROM uzytkownik WHERE id=$id_uzytkownika";
    $result_dane_uzytkownika = $polaczenie->query($sql);

    $sql_kontakt = "SELECT * FROM kontakt WHERE uzytkownik_id=$id_uzytkownika";
    $result_kontakt = $polaczenie->query($sql_kontakt);

    $sql_adres = "SELECT * FROM adres WHERE uzytkownik_id=$id_uzytkownika";
    $result_adres = $polaczenie->query($sql_adres);

    
?>


<?php include('naglowek.php'); ?>




<div class="container">

  
  <p class="h1">Dane użykownika:</p>
  <div class="pl-4">  




    <table class="table table-borderless">
    <tr>
    <?php $row = $result_dane_uzytkownika->fetch_assoc() ?>
      <td class="h5">Nazwa użytkownika:</td>
        <td><?php echo $row['login'] ?></td>
    </tr>
    <tr>
      <td class="h5">E-mail:</td>
        <td><?php echo $row['email'] ?></td>
    </tr>
    <tr>
      <td class="h5">Numer telefonu:</td>
      <?php $row = $result_kontakt->fetch_assoc() ?>
        <td><?php echo $row['numer_telefonu'] ?>frfe</td>
    </tr>
    <tr>
      <td class="h5">Ulica:</td>
      <?php $row = $result_adres->fetch_assoc() ?>
        <td><?php echo $row['ulica'] ?></td>
    </tr>
    <tr>
        </tr>
    <tr>  <td class="h5">Numer domu:</td>
      <td><?php echo $row['numer_domu'] ?></td>
        </tr>
    <tr>  <td class="h5">Miasto:</td>
      <td><?php echo $row['miasto'] ?></td>
        </tr>
    <tr>  <td class="h5">Kod pocztowy:</td>
      <td><?php echo $row['kod_pocztowy'] ?></td>

    </table>
    
  </div>

  <a class="btn btn-primary mb-5 " href="histoira_zakupow.php" role="button"><i class="fas fa-history h2"></i><span class="h2"> Historia zakupów</span></a>
</div>




<?php include('stopka.php'); ?>