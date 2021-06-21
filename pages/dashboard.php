<?php
include '../includes/bd.php';

session_start();

// ******** Ajouter laboratoire *****

if (isset($_POST['ajoutLab'])) {

    $email = $_POST['email'];
    $sql = "SELECT * FROM utilisateurs WHERE email LIKE '$email'";
    $result = mysqli_query($con, $sql);
    $user = mysqli_fetch_assoc($result);
    $idDirec = $user['id'];
    if ($user == null) {
        $error = "Cet utilisateur n'existe pas vérifier l'email";
    } elseif ($user['role'] == 3 || $user['role'] == 2) {
        $error = "Cet utilisateur est un Directeur dans une autre Laboratoire";
    } else {

        $query =  "INSERT INTO `labo`(`num_directeur`) VALUES ('$idDirec')";
        mysqli_query($con, $query) or die(mysqli_error($con)); // *****  Créer labo  ******

        $sql1 = "SELECT * FROM labo WHERE num_directeur ='$idDirec'";
        $results = mysqli_query($con, $sql1);
        $lab = mysqli_fetch_assoc($results);
        $numLab =  $lab['num_labo']; // ****** récupérer le numéro de labo que vous avez créé  *******

        $query1 = "INSERT INTO `equipe`( `num_chef`, `num_labo`) VALUES ('$idDirec','$numLab')";
        mysqli_query($con, $query1) or die(mysqli_error($con)); // *****  Créer une équipe  ******

        $sql2 = "SELECT * FROM equipe WHERE num_chef LIKE'$idDirec'";
        $result1 = mysqli_query($con, $sql2);
        $eq = mysqli_fetch_assoc($result1);
        $numeq =  $eq['num_equipe']; // ****** récupérer le numéro d'équipe que vous avez créé  *******


        $query2 =  "UPDATE utilisateurs SET role= 3,num_equipe='$numeq',num_labo='$numLab' WHERE id LIKE '$idDirec'";
        mysqli_query($con, $query2) or die(mysqli_error($con));

        $saved = "Vous avez Créer un laboratoire ";
    }
} ///////////////////////////////////////////////////////////////////////////////////////////////////////

// ******** Supprimer laboratoire *****

if (isset($_POST['supLab'])) {
    $email = $_POST['email'];
    $sql = "SELECT * FROM utilisateurs WHERE email LIKE '$email'";
    $result = mysqli_query($con, $sql);
    $user = mysqli_fetch_assoc($result);
    $idDirec = $user['id'];
    if ($user == null) {
        $error = "Cet utilisateur n'existe pas vérifier l'email";
    } elseif ($user['role'] != 3) {
        $error = "Cet utilisateur n'est pas un Directeur";
    } else {
        $numLab = $user['num_labo'];

        $query1 = "SELECT * FROM utilisateurs WHERE num_labo ='$numLab'";
        $users = mysqli_query($con, $query1); // ****** récupérer Tous les utilisateurs qui appartiennent à ce labo  *******

        if ($users->num_rows > 0) {
            while ($row = mysqli_fetch_assoc($users)) {
                $idUser = $row["id"];
                $query2 = "UPDATE utilisateurs SET role= 1,num_equipe = NULL,num_labo= NULL WHERE id LIKE '$idUser'";
                mysqli_query($con, $query2) or die(mysqli_error($con)); // *****  Mettre à jour les informations de l'utilisateur ******
            }
        }

        $query3 = "DELETE FROM `equipe` WHERE num_labo ='$numLab' ";
        mysqli_query($con, $query3) or die(mysqli_error($con)); // ****** supprimer Tous les équipe qui appartiennent à ce labo  *******


        $query4 = "SELECT * FROM salle WHERE num_labo = '$numLab'";
        $salles = mysqli_query($con, $query4);
        if ($salles->num_rows > 0) {
            while ($row = mysqli_fetch_assoc($salles)) {
                $numSalleR = $row["num_salle"];
                $query5 = "DELETE FROM `ressource_materielle` WHERE num_salle LIKE '$numSalleR'";
                mysqli_query($con, $query5) or die(mysqli_error($con)); // ***** Supprimer les ressource materielle de laboratoire ******
            }
        }

        $query6 = "DELETE FROM `salle` WHERE num_labo LIKE '$numLab'";
        mysqli_query($con, $query6) or die(mysqli_error($con)); // ***** Supprimer les Salles de laboratoire ******


        $query = "DELETE FROM `labo` WHERE num_labo ='$numLab' ";
        mysqli_query($con, $query) or die(mysqli_error($con));

        $saved = "Vous avez Supprimer un laboratoire ";
    }
} ///////////////////////////////////////////////////////////////////////////////////////////////////////

if (isset($_POST['modDirec'])) {

    $email = $_POST['email1'];
    $sql = "SELECT * FROM utilisateurs WHERE email LIKE'$email'";
    $result = mysqli_query($con, $sql);
    $user = mysqli_fetch_assoc($result);
    $direcA = $user['id']; // ****** récupérer l'id' du ancien Directeur *******
    $numeq = $user['num_equipe'];
    $numLab = $user['num_labo'];

    $email1 = $_POST['email2'];
    $sql1 = "SELECT * FROM utilisateurs WHERE email LIKE'$email1'";
    $result1 = mysqli_query($con, $sql1);
    $user1 = mysqli_fetch_assoc($result1);
    $direcN = $user1['id']; // ****** récupérer l'id' du nouveau Directeur *******

    if ($user['role'] != 3) {
        $error = "Cet utilisateur n'est pas un Directeur";
    } elseif ($user1['role'] != 1) {
        $error = "Cet utilisateur est un Directeur dans une autre équipe";
    } else {

        $query = "UPDATE labo SET num_directeur='$direcN' WHERE num_directeur='$direcA'";
        mysqli_query($con, $query) or die(mysqli_error($con));

        $query = "UPDATE equipe SET num_directeur='$direcN' WHERE num_directeur='$direcA'";
        mysqli_query($con, $query) or die(mysqli_error($con));



        $query = "UPDATE utilisateurs SET role= 1 WHERE id LIKE '$direcA'";
        mysqli_query($con, $query) or die(mysqli_error($con));

        $query = "UPDATE utilisateurs SET role= 3, num_equipe='$numeq',num_labo ='$numLab'WHERE id LIKE '$direcN'";
        mysqli_query($con, $query) or die(mysqli_error($con));
        $saved = "Vous avez modifier le Directeur de laboratoire numéro " . $numLab;
    }
} ///////////////////////////////////////////////////////////////////////////////////////////////////////

if (isset($_POST['ajoutProjet'])) {

    $categorie = $_POST['categorie'];
    $sql = "SELECT * FROM projet WHERE categorie LIKE'$categorie'";
    $result = mysqli_query($con, $sql);
    $projets = mysqli_fetch_assoc($result);

    if ($projets['categorie'] == $categorie) {
        $error = "Ce projet déja existe";
    } else {
        $query = " INSERT INTO `projet`(`categorie`) VALUES ('$categorie')";
        mysqli_query($con, $query) or die(mysqli_error($con));
        $saved = "Vous avez ajouter un Projet ";
    }
} ///////////////////////////////////////////////////////////////////////////////////////////////////////

if (isset($_POST['supProjet'])) {

    $categorie = $_POST['categorie'];

    $sql = "SELECT * FROM projet WHERE categorie LIKE'$categorie'";
    $result = mysqli_query($con, $sql);
    $projets = mysqli_fetch_assoc($result);
    if ($projets == null) {
        $error = "Ce projet n'existe pas";
    } else {
        $numProjet =  $projets['num_projet'];

        $query = "SELECT * FROM utilisateurs WHERE num_labo ='$numProjet'";
        $users = mysqli_query($con, $query); // ****** récupérer Tous les utilisateurs qui appartiennent à ce projet  *******

        if ($users->num_rows > 0) {
            while ($row = mysqli_fetch_assoc($users)) {
                $idUser = $row["id"];
                $query2 = "UPDATE utilisateurs SET num_projet = NULL WHERE id LIKE '$idUser'";
                mysqli_query($con, $query2) or die(mysqli_error($con)); // *****  Mettre à jour les informations de l'utilisateur ******
            }
        }
        $query1 = "DELETE FROM `projet` WHERE categorie LIKE'$categorie'";
        mysqli_query($con, $query1) or die(mysqli_error($con));
        $saved = "Vous avez supprimer un Projet ";
    }
} ///////////////////////////////////////////////////////////////////////////////////////////////////////

if (isset($_POST['modProjet'])) {

    $ancienCa = $_POST['ancategorie'];
    $nouvCa = $_POST['nouvcategorie'];

    $sql = "SELECT * FROM projet WHERE categorie LIKE'$ancienCa'";
    $result = mysqli_query($con, $sql);
    $projets = mysqli_fetch_assoc($result);

    if ($projets['categorie'] == null) {
        $error = "Ce projet n'existe pas";
    } else {
        $query = " UPDATE `projet` SET `categorie`='$nouvCa' WHERE categorie LIKE $ancienCa ";
        $saved = "Vous avez modifier un Projet ";
    }
} ///////////////////////////////////////////////////////////////////////////////////////////////////////

if (isset($_POST['ajoutSalle'])) {

    $email = $_POST['email'];
    $type = $_POST['type'];

    $sql = "SELECT * FROM labo WHERE num_directeur IN (SELECT id FROM utilisateurs WHERE email LIKE '$email')";
    $result = mysqli_query($con, $sql) or die(mysqli_error($con));
    $lab = mysqli_fetch_assoc($result);

    if ($lab == null) {
        $error = "Il n'y a pas Directeur avec cet email";
    } else {
        $numLab = $lab['num_labo'];
        $query = "INSERT INTO `salle`(`num_labo`, `type`) VALUES ('$numLab','$type')";
        mysqli_query($con, $query) or die(mysqli_error($con));
        $saved = "Vous avez ajouter une Salle ";
    }
} ///////////////////////////////////////////////////////////////////////////////////////////////////////

if (isset($_POST['supSalle'])) {

    $email = $_POST['email'];
    $type = $_POST['type'];

    $sql = "SELECT * FROM salle WHERE type LIKE '$type' AND num_labo IN (SELECT num_labo FROM labo WHERE num_directeur IN (
          SELECT id FROM utilisateurs WHERE  email LIKE '$email')) ";
    $result = mysqli_query($con, $sql) or die(mysqli_error($con));
    $salles = mysqli_fetch_assoc($result);


    if ($salles == null) {
        $error = "Il n'y a pas de telle salle dans ce laboratoire ";
    } else {
        $numSalle = $salles['num_salle'];

        $sql1 = "DELETE FROM ressource_materielle WHERE num_salle = '$numSalle' ";
        mysqli_query($con, $sql1) or die(mysqli_error($con));


        $query = "DELETE FROM `salle` WHERE num_salle = '$numSalle'";
        mysqli_query($con, $query) or die(mysqli_error($con));
        $saved = "Vous avez supprimer une Salle ";
    }
} ///////////////////////////////////////////////////////////////////////////////////////////////////////

if (isset($_POST['modSalle'])) {

    $email = $_POST['email'];
    $type = $_POST['type'];
    $type1 = $_POST['type1'];


    $sql = "SELECT * FROM salle WHERE type LIKE '$type' AND num_labo IN (SELECT num_labo FROM labo WHERE num_directeur IN (
          SELECT id FROM utilisateurs WHERE  email LIKE '$email')) ";
    $result = mysqli_query($con, $sql) or die(mysqli_error($con));
    $salles = mysqli_fetch_assoc($result);

    if ($salles == null) {
        $error = "Il n'y a pas de " . $type . " dans ce laboratoire ";
    } else {
        $numSalle = $salles['num_salle'];

        $query = "UPDATE `salle` SET `type`='$type1' WHERE num_salle = '$numSalle'";
        mysqli_query($con, $query) or die(mysqli_error($con));
        $saved = "Vous avez modifier le Type de Salle ";
    }
} ///////////////////////////////////////////////////////////////////////////////////////////////////////


if (isset($_POST['ajoutRessource'])) {

    $email = $_POST['email'];
    $type = $_POST['type'];
    $type1 = $_POST['type1'];


    $sql = "SELECT * FROM salle WHERE type LIKE '$type' AND num_labo IN (SELECT num_labo FROM labo WHERE num_directeur IN (
        SELECT id FROM utilisateurs WHERE  email LIKE '$email')) ";
    $result = mysqli_query($con, $sql) or die(mysqli_error($con));
    $salles = mysqli_fetch_assoc($result);

    if ($salles == null) {
        $error = "Il n'y a pas de " . $type . " dans ce laboratoire  ";
    } else {
        $numSalle = $salles['num_salle'];

        $query = "INSERT INTO `ressource_materielle`(`num_salle`, `type`) VALUES ('$numSalle','$type1')";
        mysqli_query($con, $query) or die(mysqli_error($con));
        $saved = "Vous avez ajouter une Ressource Materielle dans " . $salles['type'] . "  de Labo numéro " . $salles['num_labo'] . "";
    }
} ///////////////////////////////////////////////////////////////////////////////////////////////////////

if (isset($_POST['supRessource'])) {

    $email = $_POST['email'];
    $type = $_POST['type'];
    $type1 = $_POST['type1'];


    $sql = "SELECT * FROM salle WHERE type LIKE '$type' AND num_labo IN (SELECT num_labo FROM labo WHERE num_directeur IN (
        SELECT id FROM utilisateurs WHERE  email LIKE '$email')) ";
    $result = mysqli_query($con, $sql) or die(mysqli_error($con));
    $salles = mysqli_fetch_assoc($result);

    if ($salles == null) {
        $error = "Il n'y a pas de " . $type . " dans ce laboratoire  ";
    } else {
        $numSalle = $salles['num_salle'];

        $query = "DELETE FROM `ressource_materielle` WHERE num_salle ='$numSalle' AND type LIKE '$type1'";
        mysqli_query($con, $query) or die(mysqli_error($con));
        $saved = "Vous avez Supprimer une Ressource Materielle dans " . $salles['type'] . "  de Labo numéro " . $salles['num_labo'] . "";
    }
} ///////////////////////////////////////////////////////////////////////////////////////////////////////


if (isset($_POST['modRessource'])) {

    $email = $_POST['email'];
    $type = $_POST['type'];
    $type1 = $_POST['type1'];
    $type2 = $_POST['type2'];


    $sql = "SELECT * FROM salle WHERE type LIKE '$type' AND num_labo IN (SELECT num_labo FROM labo WHERE num_directeur IN (
        SELECT id FROM utilisateurs WHERE  email LIKE '$email')) ";
    $result = mysqli_query($con, $sql) or die(mysqli_error($con));
    $salles = mysqli_fetch_assoc($result);

    if ($salles == null) {
        $error = "Il n'y a pas de " . $type . " dans ce laboratoire  ";
    } else {
        $numSalle = $salles['num_salle'];

        $query = "UPDATE `ressource_materielle` SET `type`='$type2' WHERE type LIKE '$type1' AND num_salle ='$numSalle'";
        mysqli_query($con, $query) or die(mysqli_error($con));
        $saved = "Vous avez modifier une Ressource Materielle dans " . $salles['type'] . " de Labo numéro " . $salles['num_labo'] . "";
    }
} ///////////////////////////////////////////////////////////////////////////////////////////////////////
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

<body style="background-image: url('../img/admin2.jpg'); background-repeat: no-repeat; background-size: cover; color: white;">
    <nav class="navbar navbar-dark bg-dark navbar-expand-md ">
        <div class="container-fluid">


            <p><a class="navbar-brand" href="index.php">Smart Campus UC2</a></p>

            <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navCollapse"><span class="navbar-toggler-icon"></span></button>

            <div class="collapse navbar-collapse" id="navCollapse">
                <ul class="navbar-nav">

                    <li class="nav-item ">
                        <a class="nav-link" href="index.php">Accueil</a>
                    </li>

                </ul>

                <ul id="h" class="navbar-nav ml-auto">


                    <li class="nav-item "><a class="nav-link " href="profil.php"><span class="fa fa-user-circle"></span> Mon Profil</a></li>
                    <li class=""><button id="con-btn" class="bg-dark"><a class="nav-link active" href="logout.php"><span class="fas fa-sign-out-alt "></span> Se déconnecter </a></button></li>


                </ul>

            </div>

        </div>

    </nav>

    <h4 style=" padding: 10px; padding-left: 60px; background-color: gray; color: white;"> Espace Admin </h4>

    <?= isset($saved) ? "<p class= 'alert alert-success'>$saved</p>" : ""; ?>
    <?= isset($error) ? "<p class= 'alert alert-danger'>$error</p>" : ""; ?>

    <div class="row" style="margin-left: 60px;">


        <div style="width:400px ;">

            <ul id="list">

                <a href="" data-toggle="collapse" data-target="#ajoutLab">
                    <li>Ajouter Laboratoire</li>
                </a>

                <a href="" data-toggle="collapse" data-target="#supLab">
                    <li>Supprimer Laboratoire</li>
                </a>
                <a href="" data-toggle="collapse" data-target="#modDirec">
                    <li>Modifier Directeur</li>
                </a>

                <a href="" data-toggle="collapse" data-target="#ajoutProjet">
                    <li>Ajouter Projet</li>
                </a>
                <a href="" data-toggle="collapse" data-target="#supProjet">
                    <li>Supprimer Projet</li>
                </a>
                <a href="" data-toggle="collapse" data-target="#modProjet">
                    <li>Modifier Projet</li>
                </a>

                <a href="" data-toggle="collapse" data-target="#ajoutSalle">
                    <li>Ajouter Salle</li>
                </a>
                <a href="" data-toggle="collapse" data-target="#supSalle">
                    <li>Supprimer Salle</li>
                </a>
                <a href="" data-toggle="collapse" data-target="#modSalle">
                    <li>Modifier Salle</li>
                </a>

                <a href="" data-toggle="collapse" data-target="#ajoutRessource">
                    <li>Ajouter Ressource Materielle</li>
                </a>
                <a href="" data-toggle="collapse" data-target="#supRessource">
                    <li>Supprimer Ressource Materielle</li>
                </a>
                <a href="" data-toggle="collapse" data-target="#modRessource">
                    <li>Modifier Ressource Materielle</li>
                </a>


            </ul>


        </div>

        <div id="ajoutLab" class="collapse">

            <form method="POST" action="" class="form" style="margin-left: 320px; margin-top: 60px;">
                <fieldset>

                    <legend class="text-center display-4">Ajouter Laboratoire</legend>

                    <div class="form-group">

                        <label for="email">Email</label>
                        <input type="email" name="email" class="inpt" id="email" placeholder="email du directeur" required>

                    </div>


                    <div class="text-center">
                        <button type="submit" name="ajoutLab" id="submit-btn" class="btn btn-primary w-50 p-2 text-center">Ajouter</button>
                    </div>

                </fieldset>
            </form>

        </div>

        <div id="supLab" class="collapse">

            <form method="POST" action="" class="form" style="margin-left: 320px; margin-top: 60px;">
                <fieldset>

                    <legend class="text-center display-4">Supprimer Laboratoire</legend>

                    <div class="form-group">

                        <label for="email">Email</label>
                        <input type="email" name="email" class="inpt" id="email" placeholder="email du directeur" required>

                    </div>


                    <div class="text-center">
                        <button type="submit" name="supLab" id="submit-btn" class="btn btn-primary w-50 p-2 text-center">Supprimer</button>
                    </div>

                </fieldset>
            </form>

        </div>

        <div id="modDirec" class="collapse">

            <form method="POST" action="" class="form" style="margin-left: 320px; margin-top: 60px;">
                <fieldset>

                    <legend class="text-center display-4">Modifier Directeur</legend>

                    <div class="form-group">
                        <label for="email1">Ancien Directeur</label>
                        <input name="email1" type="email" class="inpt d-block" id="email1" placeholder="email du ancien Directeur"></input>
                    </div>

                    <div class="form-group">
                        <label for="email2">Nouveau Directeur</label>
                        <input name="email2" type="email" class="inpt d-block" id="email2" placeholder="email du nouveau Directeur"></input>
                    </div>


                    <div class="text-center">
                        <button type="submit" name="submit" id="submit-btn" class="btn btn-primary w-50 p-2 text-center">Modifier</button>
                    </div>

                </fieldset>
            </form>

        </div>

        <div id="ajoutProjet" class="collapse">

            <form method="POST" action="" class="form" style="margin-left: 350px; margin-top: 60px;">
                <fieldset>

                    <legend class="text-center display-4"> Ajouter Projet </legend>

                    <div class="form-group">

                        <label for="categorie">Catégorie</label>
                        <input type="text" name="categorie" class="inpt" id="categorie" placeholder="Catégorie du Projet" required>

                    </div>


                    <div class="text-center">
                        <button type="submit" name="ajoutProjet" id="submit-btn" class="btn btn-primary w-50 p-2 text-center">Ajouter</button>
                    </div>

                </fieldset>
            </form>

        </div>

        <div id="supProjet" class="collapse">

            <form method="POST" action="" class="form" style="margin-left: 350px; margin-top: 60px;">
                <fieldset>

                    <legend class="text-center display-4">Supprimer Projet</legend>

                    <div class="form-group">

                        <label for="categorie">Catégorie</label>
                        <input type="text" name="categorie" class="inpt" id="categorie" placeholder="Catégorie du Projet" required>

                    </div>


                    <div class="text-center">
                        <button type="submit" name="supProjet" id="submit-btn" class="btn btn-primary w-50 p-2 text-center">Supprimer</button>
                    </div>

                </fieldset>
            </form>

        </div>

        <div id="modProjet" class="collapse">

            <form method="POST" action="" class="form" style="margin-left: 350px; margin-top: 60px;">
                <fieldset>

                    <legend class="text-center display-4">Modifier Projet</legend>

                    <div class="form-group">
                        <label for="ancategorie">Ancien Catégorie</label>
                        <input name="ancategorie" type="text" class="inpt d-block" id="ancategorie" placeholder="Ancien Catégorie"></input>
                    </div>

                    <div class="form-group">
                        <label for="nouvcategorie">Nouveau Catégorie</label>
                        <input name="nouvcategorie" type="text" class="inpt d-block" id="nouvcategorie" placeholder="Nouveau Catégorie"></input>
                    </div>



                    <div class="text-center">
                        <button type="submit" name="modProjet" id="submit-btn" class="btn btn-primary w-50 p-2 text-center">Modifier</button>
                    </div>

                </fieldset>
            </form>

        </div>

        <div id="ajoutSalle" class="collapse">

            <form method="POST" action="" class="form" style="margin-left: 350px; margin-top: 180px;">
                <fieldset>

                    <legend class="text-center display-4"> Ajouter Salle </legend>

                    <div class="form-group">
                        <label for="email">Email Directeur</label>
                        <input name="email" type="email" class="inpt d-block" id="email" placeholder="Email directeur de labo"></input>
                    </div>

                    <div class="form-group">
                        <label for="type">Type</label>
                        <input name="type" type="text" class="inpt d-block" id="type" placeholder="salle de lecture, salle de conférence..."></input>
                    </div>



                    <div class="text-center">
                        <button type="submit" name="ajoutSalle" id="submit-btn" class="btn btn-primary w-50 p-2 text-center">Ajouter</button>
                    </div>

                </fieldset>
            </form>

        </div>

        <div id="supSalle" class="collapse">

            <form method="POST" action="" class="form" style="margin-left: 350px; margin-top: 180px;">
                <fieldset>

                    <legend class="text-center display-4"> Supprimer Salle </legend>

                    <div class="form-group">
                        <label for="email">Email Directeur</label>
                        <input name="email" type="email" class="inpt d-block" id="email" placeholder="Email directeur de labo"></input>
                    </div>

                    <div class="form-group">
                        <label for="type">Type</label>
                        <input name="type" type="text" class="inpt d-block" id="type" placeholder="salle de lecture, salle de conférence..."></input>
                    </div>



                    <div class="text-center">
                        <button type="submit" name="supSalle" id="submit-btn" class="btn btn-primary w-50 p-2 text-center">Supprimer</button>
                    </div>

                </fieldset>
            </form>

        </div>

        <div id="modSalle" class="collapse">

            <form method="POST" action="" class="form" style="margin-left: 350px; margin-top: 180px;">
                <fieldset>

                    <legend class="text-center display-4">Modifier Salle</legend>


                    <div class="form-group">
                        <label for="email">Email Directeur</label>
                        <input name="email" type="email" class="inpt d-block" id="email" placeholder="Email directeur de labo"></input>
                    </div>

                    <div class="form-group">
                        <label for="type">Type Ancien</label>
                        <input name="type" type="text" class="inpt d-block" id="type" placeholder="salle de lecture, salle de conférence..."></input>
                    </div>

                    <div class="form-group">
                        <label for="type1">Type Nouveau</label>
                        <input name="type1" type="text" class="inpt d-block" id="type1" placeholder="salle de lecture, salle de conférence..."></input>
                    </div>


                    <div class="text-center">
                        <button type="submit" name="modSalle" id="submit-btn" class="btn btn-primary w-50 p-2 text-center">Modifier</button>
                    </div>

                </fieldset>
            </form>

        </div>

        <div id="ajoutRessource" class="collapse">

            <form method="POST" action="" class="form" style="margin-left: 300px; margin-top: 220px;">
                <fieldset>

                    <legend class="text-center display-4">Ajouter Ressource Materielle</legend>

                    <div class="form-group">
                        <label for="email">Email Directeur</label>
                        <input name="email" type="email" class="inpt d-block" id="email" placeholder="Email directeur de labo"></input>
                    </div>

                    <div class="form-group">
                        <label for="type">Type De Salle</label>
                        <input name="type" type="text" class="inpt d-block" id="type" placeholder="salle de lecture, salle de conférence..."></input>
                    </div>

                    <div class="form-group">
                        <label for="type1">Type De Ressource</label>
                        <input name="type1" type="text" class="inpt d-block" id="type1" placeholder="équipements informatiques,ameublements, fournitures de bureau..."></input>
                    </div>




                    <div class="text-center">
                        <button type="submit" name="ajoutRessource" id="submit-btn" class="btn btn-primary w-50 p-2 text-center">Ajouter</button>
                    </div>

                </fieldset>
            </form>

        </div>

        <div id="supRessource" class="collapse">

            <form method="POST" action="" class="form" style="margin-left: 300px; margin-top: 220px;">
                <fieldset>

                    <legend class="text-center display-4">Supprimer Ressource Materielle</legend>

                    <div class="form-group">
                        <label for="email">Email Directeur</label>
                        <input name="email" type="email" class="inpt d-block" id="email" placeholder="Email directeur de labo"></input>
                    </div>

                    <div class="form-group">
                        <label for="type">Type De Salle</label>
                        <input name="type" type="text" class="inpt d-block" id="type" placeholder="salle de lecture, salle de conférence..."></input>
                    </div>

                    <div class="form-group">
                        <label for="type1">Type De Ressource</label>
                        <input name="type1" type="text" class="inpt d-block" id="type1" placeholder="équipements informatiques,ameublements, fournitures de bureau..."></input>
                    </div>


                    <div class="text-center">
                        <button type="submit" name="supRessource" id="submit-btn" class="btn btn-primary w-50 p-2 text-center">Supprimer</button>
                    </div>

                </fieldset>
            </form>

        </div>

        <div id="modRessource" class="collapse">

            <form method="POST" action="" class="form" style="margin-left: 300px; margin-top: 220px;">
                <fieldset>

                    <legend class="text-center display-4">Modifier Ressource Materielle</legend>

                    <div class="form-group">
                        <label for="email">Email Directeur</label>
                        <input name="email" type="email" class="inpt d-block" id="email" placeholder="Email directeur de laboratoire"></input>
                    </div>

                    <div class="form-group">
                        <label for="type">Type De Salle</label>
                        <input name="type" type="text" class="inpt d-block" id="type" placeholder="salle de lecture, salle de conférence..."></input>
                    </div>

                    <div class="form-group">
                        <label for="type1">Type De Ressource Ancien</label>
                        <input name="type1" type="text" class="inpt d-block" id="type1" placeholder="équipements informatiques,ameublements, fournitures de bureau..."></input>
                    </div>

                    <div class="form-group">
                        <label for="type2">Type De Ressource Nouveau</label>
                        <input name="type2" type="text" class="inpt d-block" id="type2" placeholder="équipements informatiques,ameublements, fournitures de bureau..."></input>
                    </div>


                    <div class="text-center">
                        <button type="submit" name="modRessource" id="submit-btn" class="btn btn-primary w-50 p-2 text-center">Modifier</button>
                    </div>

                </fieldset>
            </form>

        </div>

    </div>

    <script>
        document.documentElement.style.overflowX = 'hidden';
    </script>
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