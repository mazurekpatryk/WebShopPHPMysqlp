<?php error_reporting(0); if($_SESSION['zalogowany']){ header('Location: index.php')?>
<?php }else{ ?>
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
    $sql_produkty = "SELECT Id, Nazwa, Cena, Opis, sciezka_img FROM produkty";
    $result_produkty = $polaczenie->query($sql_produkty);

    $id_uzytkownika = $_SESSION['id_uzytkownika'];

    $sql_koszyk = "SELECT * FROM koszyk INNER JOIN produkty on koszyk.produkt_id = produkty.id WHERE uzytkownik_id=$id_uzytkownika";
    $result_koszyk = $polaczenie->query($sql_koszyk);

    $row_cnt = $result_koszyk->num_rows;
?>

<?php include('naglowek.php'); ?>


    <div class="container">

    <?php if($row_cnt>0){ ?>

        <table class="table">
            <thead>
                <tr>
                <th scope="col">Produkt</th>
                <th scope="col"></th>
                <th scope="col" >Ilość</th>
                <th scope="col" class="text-right">Cena</th>
                </tr>
            </thead>
            <tbody>
            <?php while($row = $result_koszyk->fetch_assoc()): ?>
                <tr>
                <td><img src="<?php echo $row["sciezka_img"]; ?>" class="card-img-top" alt="Skarpetka" style="height: 100px; width: 100px;"></td>
                <td class="align-middle"><?php echo $row['Nazwa'] ?></td>
                <td class="align-middle pl-4" ><?php echo $row['ilosc'] ?></td>
                <td class="align-middle text-right"><?php echo $row['Cena']; $sum += $row['Cena'] * $row['ilosc']?>.00zł</td>

                </tr>
            <?php endwhile; ?>
            </tbody>
        </table>

        <h3 class="text-right border-top">Koszt całkowity:</h3>
        <h1 class="text-right"><?php echo $sum ?>.00zł</h1>

        <div class="">
        <div class="border-top">
            <p class="h1">Sposób dostawy:</p>
        </div>
        <div class="pl-4 h5">
            <input type="radio" id="kurier" name="dostawa" value="kurier" checked>
            <label for="kurier">Kurier</label>
        </div>
        <div class="pl-4 h5">
            <input type="radio" id="osobisty" name="dostawa" value="osobisty">
            <label for="osobisty">Odbiór osobisty</label>
        </div>
        <p class="font-weight-normal pl-5">Łódź (CH-R Sukcesja) </br> al. Politechniki 1 </br> 93-590 Łódź</p>

        <form action="kupuje_i_place.php" method="post" class="form-inline">
            <div class="mb-5">
                <button type="submit" class="d-inline btn btn-primary btn-lg">Kupuję i płacę</button>
            </div>
        </form>
    </div>


            <?php }else{ ?>
                <div class="row">
          <div class="col-12 mt-5">
            <p id="kategorie" class="text-center">BRAK PRODUKTÓW W KOSZYKU!<p>
          </div>
          <div class="col-12 d-flex justify-content-center mb-5">
            <p  class="fas fa-times display-1"></p>
          </div>
        </div>

        <?php } ?>




</div>
    <?php } ?>

<?php include('stopka.php'); ?>