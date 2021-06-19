<?php
include '../includes/bd.php';

session_start();
if (isset($_SESSION['email']) && $_SESSION['email']) {

    $role = $_SESSION['role'];
    $id = $_SESSION['id'];
    $equipe = $_SESSION['equipe'];
    $labo = $_SESSION['labo'];
    $projet = $_SESSION['projet'];
    $nom_utilisateur = $_SESSION['nom'];
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

    <title>Admin </title>

</head>

<body>
    <nav class="navbar navbar-dark bg-dark navbar-expand-md ">
        <div class="container-fluid">


            <p><a class="navbar-brand" href="index.php">Smart Campus UC2</a></p>

            <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navCollapse"><span class="navbar-toggler-icon"></span></button>

            <div class="collapse navbar-collapse" id="navCollapse">
                <ul class="navbar-nav">

                    <li class="nav-item ">
                        <a class="nav-link" href="index.php">Accueil</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="aboutus.php">A propros de nous</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="contact.php">Contact</a>
                    </li>

                </ul>

                <ul id="h" class="navbar-nav ml-auto">


                    <li class="nav-item "><a class="nav-link " href="profil.php"><span class="fa fa-user-circle"></span> Mon Profil</a></li>
                    <li class=""><button id="con-btn" class="bg-dark"><a class="nav-link active" href="logout.php"><span class="fas fa-sign-out-alt "></span> Se déconnecter </a></button></li>


                </ul>

            </div>

        </div>

    </nav>



    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>

</body>

</html>