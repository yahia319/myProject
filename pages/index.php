<?php
session_start();
$logged = false;
$role = 0;
if (isset($_SESSION['email']) && $_SESSION['email']) {
    $logged = true;
    $role = $_SESSION['role'];
}
?>
<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/style.css">

    <title>Page d'accueil</title>

</head>

<body>
    <nav class="navbar navbar-dark bg-dark navbar-expand-md fixed-top">
        <div class="container-fluid">


            <p><a class="navbar-brand" href="index.php">Smart Campus UC2</a></p>

            <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navCollapse"><span class="navbar-toggler-icon"></span></button>

            <div class="collapse navbar-collapse" id="navCollapse">
                <ul class="navbar-nav">

                    <li class="nav-item ">
                        <a class="nav-link" href="index.php">Accueil</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">A propros de nous</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Contact</a>
                    </li>

                </ul>

                <ul id="h" class="navbar-nav ml-auto">

                    <?php if ($logged) : ?>
                        <li class=""><button id="con-btn" class="bg-dark"><a class="nav-link active" href="logout.php"><span class="fas fa-sign-in-alt "></span> Deconnecter <?= $_SESSION['email'] ?></a></button></li>

                    <?php else : ?>
                        <li class=""><button id="con-btn" class="bg-dark"><a class="nav-link active" href="connexion.php"><span class="fas fa-sign-in-alt "></span> Connexion</a></button></li>
                        <li class="nav-item "><button id="insc-btn"><a class="nav-link active" href="inscrire.php"><span class="fa fa-user "></span> S'inscrire</a></button></li>
                    <?php endif; ?>
                </ul>

            </div>

        </div>

    </nav>

    <?php if ($role == 0) : ?>

        <div id="demo" class="carousel slide" data-ride="carousel">
            <ul class="carousel-indicators">
                <li data-target="#demo" data-slide-to="0" class="active"></li>
                <li data-target="#demo" data-slide-to="1"></li>
                <li data-target="#demo" data-slide-to="2"></li>
            </ul>
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="../img/image.jpg" alt="" width="1100" height="500">
                </div>
                <div class="carousel-item">
                    <img src="../img/la.jpg" alt="Chicago" width="1100" height="500">
                </div>
                <div class="carousel-item">
                    <img src="../img/myImage.jpg" alt="New York" width="1100" height="500">
                </div>
            </div>

        </div>

    <?php elseif ($role == 1) : ?>

        <div style="margin-top:100px">
            <p>Chercheur TODO: ajouter bouttons chercheur </p>
        </div>
    <?php endif; ?>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>


</body>

</html>