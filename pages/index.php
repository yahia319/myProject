<?php
include '../includes/bd.php';
session_start();
$logged = false;
$role = 0;
if (isset($_SESSION['email']) && $_SESSION['email']) {
    $logged = true;
    $role = $_SESSION['role'];
    $id = $_SESSION['id'];
    $equipe = $_SESSION['equipe'];
    $labo = $_SESSION['labo'];
    $projet = $_SESSION['projet'];
}

$nom = "";
$categorie = "";
$description = "";
if (isset($_POST['submit'])) {

    $nom = $_POST['nom'];
    $categorie = $_POST['categorie'];
    $description = $_POST['desc'];

    $query = " INSERT INTO `production_sientifique`(`num_chercheur`, `nom_ps`, `categorie_ps`, `description`) VALUES ('$id','$nom','$categorie','$description')";
    mysqli_query($con, $query) or die(mysqli_error($con));
    $saved = "Vous avez ajouter un PS";
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

    <title></title>

</head>

<body>
    <nav class="navbar navbar-dark bg-dark navbar-expand-md ">
        <div class="container-fluid">


            <p><a class="navbar-brand" href="index.php">Smart Campus UC2</a></p>

            <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navCollapse"><span class="navbar-toggler-icon"></span></button>

            <div class="collapse navbar-collapse" id="navCollapse">
                <ul class="navbar-nav">

                    <li class="nav-item ">
                        <a class="nav-link active" href="index.php">Accueil</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="aboutus.php">A propros de nous</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="contact.php">Contact</a>
                    </li>

                </ul>

                <ul id="h" class="navbar-nav ml-auto">

                    <?php if ($logged) : ?>
                        <li class="nav-item "><a class="nav-link " href="profil.php">Mon Profil</a></li>
                        <li class=""><button id="con-btn" class="bg-dark"><a class="nav-link active" href="logout.php"><span class="fas fa-sign-out-alt "></span> Se déconnecter </a></button></li>
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

            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="../img/image.jpg" alt="" width="1100" height="500">
                </div>
                <div class="carousel-item">
                    <img src="../img/la.jpg" alt="" width="1100" height="500">
                </div>
                <div class="carousel-item">
                    <img src="../img/myImage.jpg" alt="" width="1100" height="500">
                </div>
            </div>

        </div>


        <script type="text/javascript">
            document.title = "Page d'accueil"
        </script>

    <?php elseif ($role == 1) : ?>
        <!--************************************************************************************************************* -->


        <h4 style=" padding: 10px; padding-left: 60px; background-color: gray; color: white;"> Espace Chercheur </h4>


        <div class=" container">
            <ul id="list">

                <a href="" data-toggle="collapse" data-target="#demo">
                    <li>Fournir des Producrions Scientifiques</li>
                </a>
                <a href="" data-toggle="collapse" data-target="#ch">
                    <li>Afficher list chercheurs</li>
                </a>
                <a href="" data-toggle="collapse" data-target="#equipe">
                    <li>Afficher list chercheur du meme equipe</li>
                </a>
                <a href="" data-toggle="collapse" data-target="#labo">
                    <li>Afficher list chercheur du meme laboratoire</li>
                </a>
                <a href="" data-toggle="collapse" data-target="#projet">
                    <li>Afficher list chercheur du meme projet</li>
                </a>

            </ul>
        </div>
        <!--************************************ Fournir Production Sientifique ************************************************************************* -->

        <div class="row justify-content-center">
            <div id="demo" class="collapse">

                <form method="POST" action="" class="form" style="margin-top: 50px;">
                    <fieldset>

                        <legend class="text-center display-4">Fournir Production Sientifique</legend>
                        <?= isset($saved) ? "<p class= 'alert alert-success'>$saved</p>" : ""; ?>

                        <div class="form-row">

                            <div class="form-group col-md-6">

                                <label for="nom">Nom du PS</label>
                                <input type="text" name="nom" class="inpt" id="nom" placeholder="Nom du production sientifique" required>

                            </div>

                            <div class="form-group col-md-6">
                                <label for="categorie">Catégorie</label>
                                <input type="text" name="categorie" class="inpt" id="categorie" placeholder="Article,livre,conference..." required>
                            </div>

                        </div>


                        <div class="form-group">
                            <label for="desc">Description</label>
                            <textarea name="desc" class="inpt d-block" id="desc" rows="3" placeholder="Description du Production Sientifique"></textarea>
                        </div>

                        <div class="text-center">
                            <button type="submit" name="submit" id="submit-btn" class="btn btn-primary w-50 p-2 text-center">Fournir</button>
                        </div>

                    </fieldset>
                </form>

            </div>

        </div>
        <!--************************************************************************************************************* -->

        <div class="container-fluid">
            <div id="ch" class="collapse">

                <?php
                $query = "SELECT * FROM utilisateurs";

                $users = mysqli_query($con, $query);



                if ($users->num_rows > 0) : ?>


                    <p class="display-4 text-center cap" style="margin-top: 50px; color: white;">List Des Chercheurs</p>

                    <table class="table table-striped table-hover text-center" style="margin-top: 50px; color: white;">

                        <tbody>
                            <tr>
                                <th>Nom</th>
                                <th>Prenom </th>
                                <th>Contact </th>
                                <th>Date de naissance </th>
                                <th>Adresse </th>

                            </tr>
                            <?php while ($row = mysqli_fetch_assoc($users)) : ?>


                                <tr>
                                    <td><?= $row["nom"] ?></td>
                                    <td><?= $row["prenom"] ?></td>
                                    <td><?= $row["email"] ?></td>
                                    <td><?= $row["date_nais"] ?></td>
                                    <td><?= $row["adr"] ?></td>
                                </tr>

                            <?php endwhile; ?>
                        </tbody>

                    </table>


                <?php endif; ?>

            </div>

        </div>
        <!--************************************************************************************************************* -->
        <div class="container-fluid">
            <div id="equipe" class="collapse">
                <?php
                $query = "SELECT * FROM utilisateurs WHERE num_equipe = '$equipe'";

                $users = mysqli_query($con, $query);

                if ($users->num_rows > 0) : ?>

                    <p class="display-4 text-center cap" style="margin-top: 50px; color: white;">List Des Chercheurs du meme Equipe</p>

                    <table class="table table-striped table-hover" style="margin-top: 50px; color: white;">

                        <tbody>
                            <tr>
                                <th>Nom</th>
                                <th>Prenom </th>
                                <th>Contact </th>
                                <th>Date de naissance </th>
                                <th>Adresse </th>

                            </tr>
                            <?php while ($row = mysqli_fetch_assoc($users)) : ?>


                                <tr>
                                    <td><?= $row["nom"] ?></td>
                                    <td><?= $row["prenom"] ?></td>
                                    <td><?= $row["email"] ?></td>
                                    <td><?= $row["date_nais"] ?></td>
                                    <td><?= $row["adr"] ?></td>
                                </tr>

                            <?php endwhile; ?>
                        </tbody>

                    </table>


                <?php endif; ?>


            </div>

        </div>
        <!--************************************************************************************************************* -->
        <div class="container-fluid">
            <div id="labo" class="collapse">
                <?php
                $query = "SELECT * FROM utilisateurs WHERE num_labo = '$labo'";

                $users = mysqli_query($con, $query);

                if ($users->num_rows > 0) : ?>

                    <p class="display-4 text-center cap" style="margin-top: 50px; color: white;">List Des Chercheurs du meme Laboratoire</p>

                    <table class="table table-striped table-hover" style="margin-top: 50px; color: white;">

                        <tbody>
                            <tr>
                                <th>Nom</th>
                                <th>Prenom </th>
                                <th>Contact </th>
                                <th>Date de naissance </th>
                                <th>Adresse </th>

                            </tr>
                            <?php while ($row = mysqli_fetch_assoc($users)) : ?>


                                <tr>
                                    <td><?= $row["nom"] ?></td>
                                    <td><?= $row["prenom"] ?></td>
                                    <td><?= $row["email"] ?></td>
                                    <td><?= $row["date_nais"] ?></td>
                                    <td><?= $row["adr"] ?></td>
                                </tr>

                            <?php endwhile; ?>
                        </tbody>

                    </table>


                <?php endif; ?>


            </div>

        </div>
        <!--************************************************************************************************************* -->
        <div class="container-fluid">
            <div id="projet" class="collapse">
                <?php
                $query = "SELECT * FROM utilisateurs WHERE num_projet = '$projet'";

                $users = mysqli_query($con, $query);

                if ($users->num_rows > 0) : ?>

                    <p class="display-4 text-center cap" style="margin-top: 50px; color: white;">List Des Chercheurs du meme Projet</p>

                    <table class="table table-striped table-hover" style="margin-top: 50px; color: white;">

                        <tbody>
                            <tr>
                                <th>Nom</th>
                                <th>Prenom </th>
                                <th>Contact </th>
                                <th>Date de naissance </th>
                                <th>Adresse </th>

                            </tr>
                            <?php while ($row = mysqli_fetch_assoc($users)) : ?>


                                <tr>
                                    <td><?= $row["nom"] ?></td>
                                    <td><?= $row["prenom"] ?></td>
                                    <td><?= $row["email"] ?></td>
                                    <td><?= $row["date_nais"] ?></td>
                                    <td><?= $row["adr"] ?></td>
                                </tr>

                            <?php endwhile; ?>
                        </tbody>

                    </table>


                <?php endif; ?>


            </div>

        </div>
        <!--************************************************************************************************************* -->

        <script type="text/javascript">
            document.title = "Espace Chercheur";
            var body = document.getElementsByTagName('body')[0];
            body.style.backgroundImage = 'url(../img/la.jpg)';
            body.style.backgroundRepeat = 'no-repeat';
            body.style.backgroundSize = 'cover';
        </script>

    <?php endif; ?>



    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>


</body>

</html>