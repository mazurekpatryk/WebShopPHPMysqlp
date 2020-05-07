<div class="container">
  <div class="row">

<!-- Kategorie -->
  <div class="col-12">
    <h1 id="kategorie" class="text-center mt-5 ">Kategorie</h1>
    <div id="menutop">
    <ul class="list_shop_categories list-centered">
								<li class="category_item menu_m text-secondary">
									<a href="index.php" class="category_item_link text-uppercase text-decoration-none mt-2 text-overflow">
										<span class="category_name">WSZYSTKIE</span>
									</a>
                </li>
                <?php while($row = $result_kategorie->fetch_assoc()): ?>
								<li class="category_item menu_m text-secondary">
									<a  href="wybor_kategori.php?id=<?php echo $row['Id']; ?>" class="category_item_link text-uppercase text-decoration-none mt-2 text-overflow">
										<span class="category_name"><?php echo $row["Nazwa"]; ?></span>
									</a>
                </li>
                <?php endwhile; ?>
    </ul>
    </div>
  </div>
    <!-- Kategorie -->




    <div class="col-md-12">
      <!-- Produkty -->
      <div class="container pt-5 mt-5">
        <div class="row">
          <?php while($row = $result_produkty->fetch_assoc()): ?>
          <div class="col-md-5 col-lg-3 mb-3">
            <a href="strona_produktu.php?id=<?php echo $row['Id']; ?>">
              <div class="card item  shadow-sm">

                <img src="<?php echo $row["sciezka_img"]; ?>" class="card-img-top img-fluid" alt="...">

                <div class="card-body">
                  <p class="card-title h4"><?php echo $row["Nazwa"]; ?></p>
                  <h3 class="font-weight-light"><?php echo $row["Cena"] . ".00 zł"; ?></h3>
                </div>
              </div>
          </div>
          </a>
          <?php endwhile; ?>

        </div>

      </div>
    </div>
  </div>
</div>