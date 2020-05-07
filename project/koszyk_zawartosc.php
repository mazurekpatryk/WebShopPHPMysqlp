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
?>

<?php include('naglowek.php'); ?>

    

    <table class="table">
        <thead>
            <tr>
            <th scope="col">Produkt</th>
            <th scope="col"></th>
            <th scope="col">Ilość</th>
            <th scope="col">Cena</th>
            <th scope="col">Usuń</th>
            </tr>
        </thead>
        <tbody>
        <?php while($row = $result_koszyk->fetch_assoc()): ?>
            <tr>
            <td><img src="<?php echo $row["sciezka_img"]; ?>" class="card-img-top" alt="Skarpetka" style="height: 100px; width: 100px;"></td>
            <td class="align-middle"><?php echo $row['Nazwa'] ?></td>
            <td class="align-middle"><?php echo $row['ilosc'] ?></td>
            <td class="align-middle"><?php echo $row['Cena']; $sum += $row['Cena'] * $row['ilosc']?>.00zł</td>
            <td>            
                
            
            <form action="usun_z_koszyka.php" method="post">
                <div class="form-group">
                    <input type="hidden" name="id_produktu_w_koszyku" value="<?php echo $row['id_k'] ?>">
                    
                </div>
                <div class="btn btn-primary">
                    <button type="submit" class="d-inline btn btn-primary align-middle">Usuń</button>
                </div>
            </form>

            </tr>
        <?php endwhile; ?>  
            <td colspan="5"><?php echo $sum ?>.00zł</td>
        </tbody>
    </table>
