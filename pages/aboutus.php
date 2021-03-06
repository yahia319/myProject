<?php
session_start();
$logged = false;

if (isset($_SESSION['email']) && $_SESSION['email']) {
    $logged = true;
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

    <title>A propros nous</title>

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
                        <a class="nav-link active" href="aboutus.php">A propros de nous</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="">contactez nous</a>
                    </li>

                </ul>

                <ul id="h" class="navbar-nav ml-auto">


                    <?php if ($logged) : ?>
                        <li class="nav-item "><a class="nav-link " href="profil.php"><span class="fa fa-user-circle"></span> Mon Profil</a></li>
                        <li class=""><button id="con-btn" class="bg-dark"><a class="nav-link active" href="logout.php"><span class="fas fa-sign-out-alt "></span> Se d??connecter </a></button></li>
                    <?php else : ?>
                        <li class=""><button id="con-btn" class="bg-dark"><a class="nav-link active" href="connexion.php"><span class="fas fa-sign-in-alt "></span> Connexion</a></button></li>
                        <li class="nav-item "><button id="insc-btn"><a class="nav-link active" href="inscrire.php"><span class="fa fa-user "></span> S'inscrire</a></button></li>
                    <?php endif; ?>

                </ul>

            </div>

        </div>

    </nav>

    <div class="cap " style="margin-top: 200px; padding-bottom: 70px;">
        <h1 class="text-center display-4">A propros nous</h1><br>

        <h5>
            Notre Universit?? Abdelhamid Mehri Constantine 02 a pour projet de r??aliser un laboratoire de recherches au sein de l?????tablissement universitaire ceci a pour but
            d???encourager les recherches scientifiques et donc qui va aussi permettre d???offrir un grand plus et une meilleure exp??rience et formation pour ses ??tudiants.
            Donc nous en tant qu???informaticiens nous avons les comp??tences et les ressources n??cessaires pour informatiser ce projet qui consiste ?? r??aliser un site ou
            une application web qui aura donc pour but de facilit?? le travail des chercheurs et autres employ??s du ?? UC2 Smart Campus ?? et aussi la gestion du laboratoire.
            Les laboratoires constituent le potentiel de recherche de l'Universit?? de Constantine 02 Abdelhamid Mehri. Ils couvrent l'ensemble des disciplines scientifiques
            qui mobilisent enseignants-chercheurs, ing??nieurs et doctorants. Ces ??quipes collaborent dans des projets interdisciplinaires ?? fort enjeux soci??taux.
            Ce site facilite et am??liore la gestion des diff??rents laboratoires, projets, ??quipes et autres membres du personnel et qui offre une meilleure exp??rience
            de la recherche scientifique au sein du campus.
        </h5>
    </div>

    <?php include '../includes/footer.php'; ?>

    <script type="text/javascript">
        var body = document.getElementsByTagName('body')[0];
        body.style.backgroundImage = 'url(../img/image3.jpg)';
        body.style.backgroundRepeat = 'no-repeat';
        body.style.backgroundSize = 'cover';
        body.style.color = 'white';
    </script>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>


</body>

</html>