<?php
ob_start();
?>

<?php
    session_start();
    error_reporting(0);
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/7ddcda0d1c.js" crossorigin="anonymous"></script>
    <link href="https://fonts.googleapis.com/css?family=Fjalla+One&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Lato&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">
    <title>Sklep</title>
</head>
    
    
    <div class="shadow-sm mb-4">
		<div class="container">
			<nav class="navbar navbar-expand-lg">
				<a class="nav-link nav-item fas fa-socks text-secondary Btn h2 border rounded" href="index.php">
                </a>
                

				<?php if($_SESSION['zalogowany']){ ?>
				<div class="nav-item d-block d-xl-none d-lg-none">
					<a class=" nav-item fas fa-user text-secondary Btn " href="panel_uzytkownika.php">
					</a>

				</div>
				<?php } ?>

				<div id="wozek_z_numerkim ">
                <?php if($_SESSION['zalogowany']){ ?>
					<a id="" class="nav-link nav-item fas fa-shopping-cart text-secondary Btn d-block d-xl-none d-lg-none"
						href="koszyk.php">
						<!-- <div class="qty">0</div> -->
                    </a>
                <?php }else{?>
                    <a id="" class="nav-link nav-item fas fa-shopping-cart text-secondary Btn d-block d-xl-none d-lg-none"
						href="logowanie.php">
						<!-- <div class="qty">0</div> -->
                    </a>
                <?php } ?>

				</div>

				<button class="navbar-toggler text-secondary" type="button" data-toggle="collapse"
					data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
					aria-label="Toggle navigation">
					<span class="fas fa-bars"></span>
				</button>


				<div class="collapse navbar-collapse " id="navbarSupportedContent">
					<form action="szukaj.php" method="post"
						class="form-inline mr-auto w-100 d-block d-xl-none d-lg-none">
						<input class="form-control w-75" type="search" placeholder="Wyszukaj..." name="szukaj"
							aria-describedby="button-addon5">
						<button id="button-addon5" class="btn btn-outline-primary" type="submit"><i class="fa fa-search"></i></button>

					</form>

					<form action="szukaj.php" method="post"
						id="wyszukiwarka" class="form-inline mr-auto  w-50 d-none d-xl-block d-lg-block pl-5 ml-5">
						<input class="form-control w-75" type="search" placeholder="Wyszukaj..." name="szukaj"
							aria-describedby="button-addon5">

                            <button id="button-addon5" class="btn btn-outline-primary" type="submit"><i class="fa fa-search"></i></button>
					</form>




					<ul class="navbar-nav my-2 my-lg-0">
						<li class="nav-item">

						</li>




						<h2 class="d-none d-xl-block d-lg-block">
							<a class="nav-link nav-item fas fa-th text-secondary Btn" href="index.php">
							</a></h2>

						<div id="wozek_z_numerkim" class="d-none d-xl-block d-lg-block">
                        <?php if($_SESSION['zalogowany']){ ?>
							<a id="myBtn" class="nav-link nav-item fas fa-shopping-cart text-secondary Btn h2" href="koszyk.php">

                            
                                <a id="" class="nav-link nav-item fas fa-shopping-cart text-secondary Btn d-block d-xl-none d-lg-none"
						href="koszyk.php">
						<!-- <div class="qty">0</div> -->
                    </a>
                <?php }else{?>
                    <a id="" class="nav-link nav-item fas fa-shopping-cart text-secondary Btn d-block d-xl-none d-lg-none"
						href="logowanie.php">
						<!-- <div class="qty">0</div> -->
                    </a>
                <?php } ?>
						</div>

						<?php if ((isset($_SESSION['zalogowany'])) && ($_SESSION['zalogowany']==true) && ($_SESSION['uprawnienia']==0))
                    { ?>
						<li class="nav-item mr-2 d-none d-xl-block d-lg-block">
							<a class="nav-link fas fa-user h2" href="panel_uzytkownika.php"></a>
							<a href="panel_uzytkownika.php"><span id="user_nav"
									class="h3 color-white float-right text-secondary"
									style="padding-top: 8px"><?php echo $_SESSION['login']; ?></span></a>
						</li>

						<li class="nav-item ">
							<a class="nav-link h4 btn btn-primary d-none d-xl-block d-lg-block mt-1"
                            href="wylogowanie.php">Wyloguj się</a>
							<a class="nav-link d-block d-xl-none d-lg-none" href="wylogowanie.php">
								Wyloguj się
							</a>
                        </li>
                        <?php } elseif ((isset($_SESSION['zalogowany'])) && ($_SESSION['zalogowany']==true) && ($_SESSION['uprawnienia']==1)) { ?>
                            <li class="nav-item mr-2 d-none d-xl-block d-lg-block">
							<a class="nav-link fas fa-user h2" href="panel_admini.php"></a>
							<a href="panel_admini.php"><span id="user_nav"
									class="h3 color-white float-right text-secondary"
									style="padding-top: 3px"><?php echo $_SESSION['login']; ?></span></a>
						</li>

						<li class="nav-item ">
							<a class="nav-link h4 btn btn-primary d-none d-xl-block d-lg-block"
                            href="wylogowanie.php">Wyloguj się</a>
							<a class="nav-link d-block d-xl-none d-lg-none" href="wylogowanie.php">
								Wyloguj się
							</a>
                        </li>
						<?php } else { ?>
						<li class="nav-item">
							<a class="nav-link btn btn-primary mr-lg-2  d-none d-xl-block d-lg-block"
								href="logowanie.php">Logowanie</a>
							<a class="nav-link d-block d-xl-none d-lg-none"
								href="logowanie.php">Logowanie</a>
						</li>
						<li class="nav-item">
							<a class="nav-link btn btn-primary d-none d-xl-block d-lg-block"
								href="rejestracja.php">Rejestracja</a>
							<a class="nav-link d-block d-xl-none d-lg-none"
								href="rejestracja.php">Rejestracja</a>
						</li>
						<?php } ?>
					</ul>
				</div>



			</nav>
		</div>
	</div>


