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
                <th scope="col">Cena</th>
                <th scope="col" style="text-align: center;">Usuń</th>
                </tr>
            </thead>
            <tbody>
            <?php while($row = $result_koszyk->fetch_assoc()): ?>
                <tr>
                <td><img src="<?php echo $row["sciezka_img"]; ?>" class="card-img-top" alt="Skarpetka" style="height: 100px; width: 100px;"></td>
                <td class="align-middle"><?php echo $row['Nazwa'] ?></td>
                <td class="align-middle pl-4" ><?php echo $row['ilosc'] ?></td>
                <td class="align-middle"><?php echo $row['Cena']; $sum += $row['Cena'] * $row['ilosc']?>.00zł</td>
                <td class="align-middle pb-4">            
                    
                
                <form action="usun_z_koszyka.php" method="post">
                    <div class="form-group">
                        <input type="hidden" name="id_produktu_w_koszyku" value="<?php echo $row['id_k'] ?>">
                        
                    </div>
                    <div class="align-middle">
                        <button type="submit" class="w-100 d-inline btn btn-primary">Usuń</button>
                    </div>
                </form>
                </td>
                </tr>
            <?php endwhile; ?>
                <td colspan="3"></td>
                <td class="h3"> Suma zakupów:</td>
                <td class="h3" style="text-align: center;"><?php echo $sum ?>.00zł</td>
            </tbody>
        </table>
        <div class="d-flex justify-content-end">
                <a class="btn btn-primary btn-lg text-right mr-2 mb-5" href="podsumowanie.php" role="button">Przejdź do podsumowania</a>
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