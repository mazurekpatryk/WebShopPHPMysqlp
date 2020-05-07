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

<?php include('naglowek.php'); ?>

<?php
    $id_uzytkownika = $_SESSION['id_uzytkownika'];

     $sql_koszyk = "SELECT * FROM zamowienia INNER JOIN produkty on zamowienia.id_produktu = produkty.id WHERE id_uzytkownika = $id_uzytkownika ORDER BY id_z";
     $result_koszyk = $polaczenie->query($sql_koszyk);
     $row_cnt = $result_koszyk->num_rows;
?>

<div class="container">
<?php if($row_cnt>0){ ?>
    <table class="table">
            <thead>
                <tr>
                <th scope="col" class="h4">Produkt</th>
                    <th scope="col" class="h4"></th>
                    <th scope="col"  class="h4">Ilość</th>
                    <th scope="col" class="text-right h4">Cena</th>
                    <th scope="col" class="text-right h4">Status Wysyłki</th>
                </tr>
            </thead>
            <tbody>
            <?php while($row = $result_koszyk->fetch_assoc()): ?>
                <tr>
                <td><img src="<?php echo $row["sciezka_img"]; ?>" class="card-img-top" alt="Skarpetka" style="height: 50px; width: 50px;"></td>
                <td class="align-middle"><?php echo $row['Nazwa'] ?></td>
                <td class="align-middle pl-4" ><?php echo $row['ilosc'] ?></td>
                <td class="align-middle text-right"><?php echo $row['Cena']; $sum += $row['Cena'] * $row['ilosc']?>.00zł</td>
                <td  class="align-middle text-right"><?php if($row['status']==0) echo '<i class="fas fa-times-circle h1 text-danger"></i>'; else echo '<i class="fas fa-check-circle h1 text-success"></i>'; ?></td>
            <?php endwhile; ?>
            </tbody>
    </table>
    <?php }else{ ?>
        <div class="row">
          <div class="col-12 mt-5">
            <p id="kategorie" class="text-center">BRAK KUPIONYCH PRODUKTÓW!<p>
          </div>
          <div class="col-12 d-flex justify-content-center mb-5">
            <p  class="fas fa-times display-1"></p>
          </div>
        </div>

        <?php } ?>
</div>
<?php include('stopka.php'); ?>