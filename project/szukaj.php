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
    $haslo_wyszukiwania = $_POST['szukaj'];

    $sql_produkty = "SELECT * FROM produkty WHERE nazwa LIKE '%$haslo_wyszukiwania%'";
    if($result_produkty = $polaczenie->query($sql_produkty))
    {
        $row_cnt = $result_produkty->num_rows;     
    }
    else{
        throw new Exception($polaczenie->error);
    }

    
?>

<?php include('naglowek.php'); ?>

<?php if($row_cnt>0) { ?>
  <div class="container">
    <div class="col-md-12">
      <!-- Produkty -->
      <div class="container pt-5 mt-5">
        <div class="row">
          <?php while($row = $result_produkty->fetch_assoc()): ?>
          <div class="col-md-5 col-lg-3 mb-3">
            <a href="strona_produktu.php?id=<?php echo $row['id']; ?>">
              <div class="card item">

                <img src="<?php echo $row["sciezka_img"]; ?>" class="card-img-top img-fluid" alt="...">

                <div class="card-body">
                  <p class="card-title"><?php echo $row["Nazwa"]; ?></p>
                  <h3><?php echo $row["Cena"] . ".00 zł"; ?></h3>
                </div>
              </div>
          </div>
          </a>
          <?php endwhile; ?>

        </div>

      </div>
    </div>
    </div>
    <?php }else{ ?>
      <div class="container">
        <div class="row">
          <div class="col-12 mt-5">
            <p id="kategorie" class="text-center">BRAK WYNIKÓW!<p>
          </div>
          <div class="col-12 d-flex justify-content-center mb-5">
            <p  class="fas fa-times display-1"></p>
          </div>
        </div>
        
      </div>
        
    <?php } ?>

<?php include('stopka.php'); ?>