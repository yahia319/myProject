<?php
include '../includes/bd.php';
session_start();



$nom = "";
$prenom = "";
$date_nais = "";
$adr = "";
$email = "";
$pass = "";



if (isset($_POST['submit'])) {

    //TODO: valider les données du formulaire

    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $date_nais = $_POST['date_nais'];
    $adr = $_POST['adr'];
    $email = $_POST['email'];
    //$pass = password_hash($_GET['pass'],PASSWORD_DEFAULT)

    $pass = $_POST['pass'];

    $sql = "SELECT * FROM utilisateurs WHERE email LIKE'$email'";
    $sqli = mysqli_query($con, $sql);
    if (mysqli_num_rows($sqli) >= 1) {
        $error = "deja exist,  <a href='connexion.php'>connecter ?</a>";
    } else {
        $query = " INSERT INTO utilisateurs(nom,prenom,email,pass,date_nais,adr,role) VALUES ('$nom','$prenom','$email','$pass','$date_nais','$adr','1')";
        mysqli_query($con, $query) or die(mysqli_error($con));
        $connecter = "Vous êtes inscrit maintenant,  <a href='connexion.php'>connecter ?</a>";
    }
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
    <link rel="stylesheet" href="../css/style.css">

    <title>Inscription</title>
</head>

<body style="background-image: url('../img/image.jpg'); background-repeat: no-repeat; background-size: cover; color: white;backdrop-filter: blur(10px);">


    <nav class="navbar navbar-dark bg-dark navbar-expand-md ">
        <div class="container-fluid">


            <p><a class="navbar-brand " href="index.php">Smart Campus UC2</a></p>

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
                        <a class="nav-link" href="contact.php">contactez nous</a>
                    </li>

                </ul>

            </div>

        </div>

    </nav>


    <div class=" vertical-center">
        <div class="container ">
            <div class="row d-flex justify-content-center">
                <form method="POST" class="form" action="" style="margin-bottom: 120px;">
                    <fieldset>

                        <legend class="text-center display-4">S'inscrire</legend>
                        <?= isset($error) ? "<p class= 'alert alert-danger'>$error</p>" : ""; ?>
                        <?= isset($connecter) ? "<p class= 'alert alert-success'>$connecter</p>" : ""; ?>
                        <div class="form-row">
                            <div class="form-group col-md-6">

                                <label for="nom">Nom</label>
                                <input type="text" name="nom" class="inpt" id="nom" placeholder="Votre Nom" required>

                            </div>

                            <div class="form-group col-md-6">
                                <label for="prenom">Prénom</label>
                                <input type="text" name="prenom" class="inpt" id="prenom" placeholder="Votre Prénom" required>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="date_nais">Date De Naissance</label>
                                <input type="date" name="date_nais" class="inpt" id="date_nais" required>

                            </div>

                            <div class="form-group col-md-6">
                                <label for="adr">Address</label>
                                <input type="text" name="adr" class="inpt" id="adr" placeholder="Votre Adress" required>
                            </div>
                        </div>

                        <div class="form-group">

                            <label for="email">Email</label>
                            <input type="email" name="email" class="inpt" id="email" placeholder="Votre Email" required>

                        </div>

                        <div class="form-group">
                            <label for="pass">Mot de passe</label>
                            <input type="password" name="pass" class="inpt" id="pass" placeholder="Votre Mot de passe" required>
                        </div>

                        <div class="text-center">
                            <button type="submit" name="submit" id="submit-btn" class="btn btn-primary w-50 p-2 text-center"> S'inscrire</button>
                            <p class="p">vous avez déjà un compte?<a id="lien" href="connexion.php"> Connexion</a></p>
                        </div>

                    </fieldset>
                </form>
            </div>
        </div>
    </div>




    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>


</body>

</html>