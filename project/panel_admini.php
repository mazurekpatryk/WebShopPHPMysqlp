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
 

    $sql_koszyk = "SELECT * FROM zamowienia INNER JOIN produkty on zamowienia.id_produktu = produkty.id ORDER BY id_z DESC";
    $result_koszyk = $polaczenie->query($sql_koszyk);


?>


<?php include('naglowek.php'); ?>

<?php if($_SESSION['zalogowany'] && $_SESSION['uprawnienia']==1){ ?>

<div class="container">

    <h1 class="mb-4 mt-4">Zarzadzanie zamowieniami</h1>

    <table class="table">
        <thead>
            <tr>
                <th scope="col">Zdjęcie</th>
                <th scope="col">Nazwa</th>
                <th scope="col">ID użytkownika</th>
                <th scope="col">Ilosc</th>
                <th scope="col">Cena całkowita</th>
                <th scope="col">Status Wysyłki</th>
            </tr>
        </thead>
        <tbody>
            <?php while($row = $result_koszyk->fetch_assoc()): ?>
            <tr>
                <td><img src="<?php echo $row["sciezka_img"]; ?>" class="card-img-top" alt="Skarpetka"
                        style="height: 50px; width: 50px;"></td>
                <td><?php echo $row['Nazwa'] ?></td>
                <td><?php echo $row['id_uzytkownika'] ?></td>
                <td><?php echo $row['ilosc'] ?></td>
                <td><?php echo $row['Cena']; $sum += $row['Cena'] * $row['ilosc']?>.00zł</td>
                <td>


                    <form action="ustaw_jako_wyslane.php" method="post" class="form-inline">
                        <div class="form-group">
                            <input type="hidden" name="id_produktu_zamowionego" value="<?php echo $row['id_z'] ?>">

                        </div>
                        <div class="ml-4">
                            <?php if( $row['status']==1){ ?>
                            <button type="submit" class="btn btn-lg btn-success" disabled>Wysłane</button>
                            <?php } else { ?>
                            <button type="submit" class="btn btn-lg btn-danger">Wyślij</button>
                            <?php }?>
                        </div>
                    </form>

            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>
<?php }else{header('Location: index.php');} ?>


<?php include('stopka.php'); ?>