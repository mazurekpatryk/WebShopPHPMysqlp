<?php

    require_once "polaczenie.php";
    $polaczenie = @new mysqli($host, $user, $pass, $conn);

    if($polaczenie->connect_errno!=0)
    {
      echo "Error: ".$polaczenie->connect_errno;
    }
    error_reporting(0);
?>

<?php include('naglowek.php'); ?>

<?php
    $id_wybranego_produktu = (int) $_GET['id'];
    $sql_produkt = "SELECT Id, Nazwa, Cena, Opis, sciezka_img, kategoria_id FROM produkty WHERE Id=$id_wybranego_produktu";
    $result_produkt = $polaczenie->query($sql_produkt);

    $sql_produkt_inny_niz_wybrany = "SELECT Id, Nazwa, Cena, Opis, sciezka_img, kategoria_id FROM produkty WHERE Id<>$id_wybranego_produktu";
    $result_produkt_inny_niz_wybrany = $polaczenie->query($sql_produkt_inny_niz_wybrany);
?>




<div class="container">
    <div class="row">
        <div class="col text-center">
            <img src="<?php $row = $result_produkt->fetch_assoc(); echo $row["sciezka_img"]; ?>" class="card-img-top" alt="Skarpetka" style="height: 400px; width: 400px;">         
        </div>
        <div class="col">
            <h1 class="display-4 naglowek mt-5"><?php echo $row['Nazwa'] ?></h1>
            <h2 class="mb-3 mt-4 text-primary cena"><?php echo $row['Cena'] .".00 zł"; ?></h2>

            <p class="mt-5 lead pr-5 mb-5"><?php echo $row['Opis'] ?></p>

            <form action="dodaj_do_koszyka.php" method="post" class="mb-5">
                <div class="form-group">
                <div class="def-number-input number-input safari_only">

                    <button type="button" onclick="this.parentNode.querySelector('input[type=number]').stepDown()" class="minus"></button>
                    <input class="quantity" min="0" name="ilosc" value="1" type="number" id="replyNumber" min="1" max="99" data-bind="value:replyNumber"> 
                    <button type="button" onclick="this.parentNode.querySelector('input[type=number]').stepUp()" class="plus"></button>
                    </div>

                    <input type="hidden" name="id_produktu" value="<?php echo $row['Id'] ?>">
                    
                </div>
                <div class="btn btn-primary ">
                <?php if($_SESSION['zalogowany']){ ?>
                    <button type="submit" class="d-inline-flex btn btn-primary ">Dodaj do koszyka</button>
                <?php } else{ ?>
                    <a type="submit" href="logowanie.php" class="d-inline-flex btn btn-primary ">Dodaj do koszyka</a>
                <?php } ?>
                </div>
            </form>
            
        </div>
        <div class="col-12 border-top">
            <h4 style="margin-top: -20px" class="text-center"><span class="text-center bg-white">Zobacz również:<span></h4>
        </div>
    </div>

    <!-- Produkty -->
    
    <div class="col">
    <div class="container mt-2">
      <div class="row row-cols-1 row-cols-md-3">
        <?php $licznik=0; while($row = $result_produkt_inny_niz_wybrany->fetch_assoc()): $licznik++;?>
            <div class="col-md-5 col-lg-4 col-xl-3 mb-3">
              <a href="strona_produktu.php?id=<?php echo $row['Id']; ?>"> 
                <div class="card item">
                    
                        <img src="<?php echo $row["sciezka_img"]; ?>" class="card-img-top img-fluid" alt="...">
                    
                        <div class="card-body">
                            <p class="card-title"><?php echo $row["Nazwa"]; ?></p>
                            <h3><?php echo $row["Cena"] . ".00 zł"; ?></h3>
                        </div>            
                  </div>
                </a>    
                </div>
                
            
        <?php if($licznik==8) break; endwhile; ?>
        </div>
      </div>
    </div>
    <!-- Produkty -->

</div>

<?php include('stopka.php'); ?>