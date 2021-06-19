<?php
include '../includes/bd.php';
include '../includes/notifications.php';

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
    $nom_utilisateur = $_SESSION['nom'];
}
// ******** Fournir production scientifique *****
$nom = "";
$categorie = "";
$description = "";
if (isset($_POST['submit'])) {

    $nom = $_POST['nom'];
    $categorie = $_POST['categorie'];
    $description = $_POST['desc'];

    $query = " INSERT INTO `production_sientifique`(`num_chercheur`, `nom_ps`, `categorie_ps`, `description`) VALUES ('$id','$nom','$categorie','$description')";
    mysqli_query($con, $query) or die(mysqli_error($con));


    // envoie notif
    $emails = array();

    $sql = "SELECT email FROM utilisateurs, equipe WHERE utilisateurs.id = equipe.num_chef AND equipe.num_equipe =  " . $_SESSION['equipe'];

    $result = mysqli_query($con, $sql);
    $email_chef_equipe_result = mysqli_fetch_assoc($result);
    $email_chef_equipe = $email_chef_equipe_result['email'];

    $sql = "SELECT email FROM utilisateurs, labo WHERE utilisateurs.id = labo.num_directeur AND labo.num_labo =  " . $_SESSION['labo'];

    $result = mysqli_query($con, $sql);
    $email_dir_labo_result = mysqli_fetch_assoc($result);
    $email_dir_labo = $email_dir_labo_result['email'];
    $emails[] = $email_dir_labo;
    $emails[] = $email_chef_equipe;


    // email utilisateurs ont même domaine d'intéret

    $sql = "select DISTINCT email from utilisateurs,avoir_domaine,domaine_interet 
    where utilisateurs.id = avoir_domaine.id_utilisateur and domaine_interet.num_domaine=avoir_domaine.num_domaine 
    and domaine_interet.nom in ( 
        select domaine_interet.nom from utilisateurs,avoir_domaine,domaine_interet 
        where utilisateurs.id = avoir_domaine.id_utilisateur 
        and domaine_interet.num_domaine=avoir_domaine.num_domaine and 
        utilisateurs.id = " . $_SESSION["id"] . ") ";


    $result = mysqli_query($con, $sql);

    if ($result->num_rows > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $em = $row["email"];
            $emails[] = $em;
        }
    }



    notifyByEmail(implode(",", $emails), "nouvelle production scientifique", $nom_utilisateur, $nom, "LIEN Prod: TODO");


    $saved = "Vous avez ajouter un PS";
} ///////////////////////////////////////////////////////////////////////////////////////////////////////

// ******** Ajouter chercheur *****

if (isset($_POST['ajout'])) {

    $email = $_POST['email'];
    $sql = "SELECT * FROM utilisateurs WHERE email LIKE '$email'";
    $result = mysqli_query($con, $sql);
    $user = mysqli_fetch_assoc($result);
    if ($user == null) {
        $error = "Cet utilisateur n'existe pas vérifier l'email";
    } else {
        $query = "UPDATE utilisateurs SET num_equipe='$equipe',num_labo='$labo' WHERE email LIKE '$email'";
        mysqli_query($con, $query) or die(mysqli_error($con));
        $saved = "Vous avez ajouter un Chercheur dans l'équipe";
    }
} ///////////////////////////////////////////////////////////////////////////////////////////////////////

// ******** Supprimer chercheur *****

if (isset($_POST['sup'])) {
    $email = $_POST['email'];

    $sql = "SELECT * FROM utilisateurs WHERE email LIKE'$email'";
    $result = mysqli_query($con, $sql);
    $user = mysqli_fetch_assoc($result);

    if ($email == $_SESSION['email'] || $user['role'] != 1 || $user['num_equipe'] != $equipe) {
        $error = "Vous n'avez pas le droit de supprimer cet utilisateur";
    } else {

        $query = "UPDATE utilisateurs SET num_equipe= NULL,num_labo= NULL WHERE email LIKE '$email'";
        mysqli_query($con, $query) or die(mysqli_error($con));
        $saved = "Vous avez Supprimer un Chercheur de l'équipe ";
    }
} ///////////////////////////////////////////////////////////////////////////////////////////////////////

// ******** Créer une Equipe et  Ajouter ChefEquipe dedans *****

if (isset($_POST['ajoutChef'])) {

    $email = $_POST['email'];

    $sql = "SELECT * FROM utilisateurs WHERE email LIKE'$email'";
    $result = mysqli_query($con, $sql);
    $user = mysqli_fetch_assoc($result);
    $chef = $user['id']; // ****** récupérer l'id' du chef *******

    if ($user['num_labo'] != $labo) {
        $error = "Cet utilisateur n'appartient pas à ce laboratoire";
    } elseif ($user['role'] == 2) {
        $error = "Cet utilisateur est un Chef dans une autre équipe";
    } else {

        $query = "INSERT INTO `equipe`( `num_chef`, `num_labo`) VALUES ('$chef','$labo')";
        mysqli_query($con, $query) or die(mysqli_error($con)); // *****  Créer une équipe  ******

        $sql1 = "SELECT * FROM equipe WHERE num_chef LIKE'$chef'";
        $result1 = mysqli_query($con, $sql1);
        $eq = mysqli_fetch_assoc($result1);
        $numeq =  $eq['num_equipe']; // ****** récupérer le numéro d'équipe que vous avez créé  *******

        $query1 = "UPDATE utilisateurs SET role= 2,num_equipe='$numeq' WHERE email LIKE '$email'";
        mysqli_query($con, $query1) or die(mysqli_error($con));
        $saved = "Vous avez ajouter un Chef dans equipe n" . $numeq;
    }
} ///////////////////////////////////////////////////////////////////////////////////////////////////////

// ******** Supprimer Equipe et ChefEquipe *****

if (isset($_POST['suppChef'])) {

    $email = $_POST['email'];
    $sql = "SELECT * FROM utilisateurs WHERE email LIKE'$email'";
    $result = mysqli_query($con, $sql);
    $user = mysqli_fetch_assoc($result);
    $chef = $user['id']; // ****** récupérer l'id' du chef *******

    if ($user['num_labo'] != $labo) {
        $error = "Cet utilisateur n'appartient pas à ce laboratoire";
    } elseif ($user['role'] != 2) {
        $error = "Cet utilisateur n'est pas un Chef";
    } else {

        $sql1 = "SELECT * FROM equipe WHERE num_chef LIKE'$chef'";
        $result1 = mysqli_query($con, $sql1);
        $eq = mysqli_fetch_assoc($result1);
        $numeq =  $eq['num_equipe']; // ****** récupérer le numéro d'équipe  *******

        $query1 = "SELECT * FROM utilisateurs WHERE num_equipe ='$numeq'";
        $users = mysqli_query($con, $query1); // ****** récupérer Tous les utilisateurs qui appartiennent à cette équipe  *******

        if ($users->num_rows > 0) {
            while ($row = mysqli_fetch_assoc($users)) {
                $em = $row["email"];
                $query2 = "UPDATE utilisateurs SET role= 1,num_equipe = NULL,num_labo= NULL WHERE email LIKE '$em'";
                mysqli_query($con, $query2) or die(mysqli_error($con)); // *****  Mettre à jour les informations de l'utilisateur ******
            }
        }

        $query = "DELETE FROM `equipe` WHERE num_chef ='$chef' ";
        mysqli_query($con, $query) or die(mysqli_error($con)); // *****  Supprimer l'équipe  ******
        $saved = "Vous avez supprimer léquipe numéro " . $numeq;
    }
} ///////////////////////////////////////////////////////////////////////////////////////////////////////

// ******** Modifier ChefEquipe *****

if (isset($_POST['modChef'])) {

    $email = $_POST['email1'];
    $sql = "SELECT * FROM utilisateurs WHERE email LIKE'$email'";
    $result = mysqli_query($con, $sql);
    $user = mysqli_fetch_assoc($result);
    $chefa = $user['id']; // ****** récupérer l'id' du ancien chef *******
    $num = $user['num_equipe'];

    $email1 = $_POST['email2'];
    $sql1 = "SELECT * FROM utilisateurs WHERE email LIKE'$email1'";
    $result1 = mysqli_query($con, $sql1);
    $user1 = mysqli_fetch_assoc($result1);
    $chefn = $user1['id']; // ****** récupérer l'id' du nouveau chef *******

    if ($user['num_labo'] != $labo || $user1['num_labo'] != $labo) {
        $error = "Cet utilisateur n'appartient pas à ce laboratoire";
    } elseif ($user['role'] != 2) {
        $error = "Cet utilisateur n'est pas un Chef";
    } elseif ($user1['role'] != 1) {
        $error = "Cet utilisateur est un chef dans une autre équipe";
    } else {

        $query = "UPDATE equipe SET num_chef='$chefn' WHERE num_chef='$chefa'";
        mysqli_query($con, $query) or die(mysqli_error($con));

        $query = "UPDATE utilisateurs SET role= 1 WHERE id LIKE '$chefa'";
        mysqli_query($con, $query) or die(mysqli_error($con));

        $query = "UPDATE utilisateurs SET role= 2, num_equipe='$num'WHERE id LIKE '$chefn'";
        mysqli_query($con, $query) or die(mysqli_error($con));
        $saved = "Vous avez modifier le chef de l'équipe numéro " . $num;
    }
}

$query = "SELECT * FROM utilisateurs where role = 1";

$users = mysqli_query($con, $query);
///////////////////////////////////////////////////////////////////////////////////////////////////////
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

    <!--role == 0 c-à-d Visiteur -->

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


        <script>
            document.title = "Page d'accueil"
        </script>

        <!-- role == 1 c-à-d Chercheur // role == 2 c-à-d Chef-equipe // role == 3 c-à-d Directeur  -->

    <?php elseif ($role == 1 || $role == 2 || $role == 3) : ?>

        <?php if ($role == 1) : ?>
            <h4 style=" padding: 10px; padding-left: 60px; background-color: gray; color: white;"> Espace Chercheur </h4>
            <script>
                document.title = "Espace Chercheur";
            </script>
        <?php elseif ($role == 2) : ?>
            <div class="row" style=" padding: 6px; padding-left: 60px; background-color: gray; color: white;">
                <h4 class="col-8"> Espace Chef Equipe </h4>
                <h5 class="col text-center" style="padding-top: 4px;"> Equipe numéro <?php echo $equipe ?> </h5>
            </div>
            <script>
                document.title = "Espace Chef D'équipe";
            </script>
        <?php elseif ($role == 3) : ?>
            <div class="row" style=" padding: 6px; padding-left: 60px; background-color: gray; color: white;">
                <h4 class="col-8"> Espace Directeur </h4>
                <h5 class="col text-center" style="padding-top: 4px;"> Laboratoire numéro <?php echo $labo ?> </h5>
            </div>

            <script>
                document.title = "Espace Directeur";
            </script>
        <?php endif; ?>
        <!--************************************** *********************************************************************** -->

        <?= isset($saved) ? "<p class= 'alert alert-success'>$saved</p>" : ""; ?>
        <?= isset($error) ? "<p class= 'alert alert-danger'>$error</p>" : ""; ?>

        <div class="row" style="margin-left: 60px;">
            <div class=" d-flex" style=" width:400px ;">
                <ul id="list">

                    <!--Fonctions Chercheur -->

                    <a href="" data-toggle="collapse" data-target="#demo">
                        <li>Fournir des Producrions Scientifiques</li>
                    </a>

                    <!--Fonctions Chef equipe -->

                    <?php if ($role == 2 || $role == 3) : ?>

                        <a href="" data-toggle="collapse" data-target="#ajout">
                            <li>Ajouter Chercheur</li>
                        </a>
                        <a href="" data-toggle="collapse" data-target="#supp">
                            <li>Supprimer Chercheur</li>
                        </a>

                        <!--Fonctions Directeur -->

                        <?php if ($role == 3) : ?>
                            <a href="" data-toggle="collapse" data-target="#ajoutChef">
                                <li>Ajouter Chef</li>
                            </a>
                            <a href="" data-toggle="collapse" data-target="#suppChef">
                                <li>Supprimer Chef</li>
                            </a>
                            <a href="" data-toggle="collapse" data-target="#modChef">
                                <li>Modifier Chef</li>
                            </a>
                        <?php endif; ?>

                        <!--Fin Fonctions Directeur -->

                    <?php endif; ?>

                    <!--Fin Fonctions Chef equipe -->

                    <a href="" data-toggle="collapse" data-target="#ch">
                        <li>Afficher list chercheurs</li>
                    </a>

                    <?php if ($equipe != null) : ?>
                        <a href="" data-toggle="collapse" data-target="#equipe">
                            <li>Afficher list chercheurs du meme equipe</li>
                        </a>
                        <a href="" data-toggle="collapse" data-target="#labo">
                            <li>Afficher list chercheurs du laboratoire</li>
                        </a>
                    <?php endif; ?>

                    <?php if ($projet != null) : ?>
                        <a href="" data-toggle="collapse" data-target="#projet">
                            <li>Afficher list chercheurs du meme projet</li>
                        </a>
                    <?php endif; ?>

                    <!--Fin Fonctions Chercheur -->

                </ul>
            </div>
            <!--************************************ Fournir Production Sientifique ************************************************************************* -->


            <div id="demo" class="collapse">

                <form method="POST" action="" class="form" style="margin-left: 180px; margin-top: 50px;">
                    <fieldset>

                        <legend class="text-center display-4">Fournir Production Sientifique</legend>


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


            <div id="ajout" class="collapse">

                <form method="POST" action="" class="form" style="margin-left: 300px;margin-top: 50px;">
                    <fieldset>

                        <legend class="text-center display-4">Ajouter Chercheur</legend>


                        <div class="form-group">
                            <label for="email">Email</label>
                            <input name="email" class="inpt d-block" id="email" placeholder="L'email du chercheur"></input>
                        </div>

                        <div class="text-center">
                            <button type="submit" name="ajout" id="submit-btn" class="btn btn-primary w-50 p-2 text-center">Ajouter Chercheur</button>
                        </div>

                    </fieldset>
                </form>

            </div>

            <div id="supp" class="collapse">

                <form method="POST" action="" class="form" style="margin-left: 300px;margin-top: 50px;">
                    <fieldset>

                        <legend class="text-center display-4">Supprimer Chercheur</legend>


                        <div class="form-group">
                            <label for="email">Email</label>
                            <input name="email" class="inpt d-block" id="email" placeholder="L'email du chercheur"></input>
                        </div>

                        <div class="text-center">
                            <button type="submit" name="sup" id="submit-btn" class="btn btn-primary w-50 p-2 text-center">Supprimer Chercheur</button>
                        </div>

                    </fieldset>
                </form>

            </div>

            <div id="ajoutChef" class="collapse">

                <form method="POST" action="" class="form" style="margin-left: 300px;margin-top: 50px;">
                    <fieldset>

                        <legend class="text-center display-4">Ajouter Chef</legend>


                        <div class="form-group">
                            <label for="email">Email</label>
                            <input name="email" class="inpt d-block" id="email" placeholder="L'email du chercheur"></input>
                        </div>

                        <div class="text-center">
                            <button type="submit" name="ajoutChef" id="submit-btn" class="btn btn-primary w-50 p-2 text-center">Ajouter Chef</button>
                        </div>

                    </fieldset>
                </form>

            </div>

            <div id="suppChef" class="collapse">

                <form method="POST" action="" class="form" style="margin-left: 300px;margin-top: 50px;">
                    <fieldset>

                        <legend class="text-center display-4">Supprimer Chef</legend>


                        <div class="form-group">
                            <label for="email">Email</label>
                            <input name="email" class="inpt d-block" id="email" placeholder="L'email du chercheur"></input>
                        </div>

                        <div class="text-center">
                            <button type="submit" name="suppChef" id="submit-btn" class="btn btn-primary w-50 p-2 text-center">Supprimer Chef</button>
                        </div>

                    </fieldset>
                </form>

            </div>

            <div id="modChef" class="collapse">

                <form method="POST" action="" class="form" style="margin-left: 300px;margin-top: 50px;">
                    <fieldset>

                        <legend class="text-center display-4">Modifier Chef</legend>


                        <div class="form-group">
                            <label for="email1">Ancien Chef</label>
                            <input name="email1" type="email" class="inpt d-block" id="email1" placeholder="email du ancien Chef"></input>
                        </div>

                        <div class="form-group">
                            <label for="email2">Nouveau Chef</label>
                            <input name="email2" type="email" class="inpt d-block" id="email2" placeholder="email du nouveau Chef"></input>
                        </div>

                        <div class="text-center">
                            <button type="submit" name="modChef" id="submit-btn" class="btn btn-primary w-50 p-2 text-center">Modifier Chef</button>
                        </div>

                    </fieldset>
                </form>

            </div>

        </div>

        <!--************************************************************************************************************* -->

        <div class="container-fluid ">
            <div id="ch" class="collapse">

                <?php


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

        <script>
            var body = document.getElementsByTagName('body')[0];
            body.style.backgroundImage = 'url(../img/la.jpg)';
            body.style.backgroundRepeat = 'no-repeat';
            body.style.backgroundSize = 'cover';
        </script>

    <?php endif; ?>



    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>

    <script>
        $(document).ready(function() {
            $('.collapse').on('show.bs.collapse', function() {
                $('.collapse.show').each(function() {
                    $(this).collapse('toggle');


                });
            });
        });
    </script>

</body>

</html>