<?php
include '../includes/bd.php';
session_start();
$id = $_SESSION['id'];


if (isset($_POST['submit'])) {

    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $date_nais = $_POST['date_nais'];
    $adr = $_POST['adr'];
    $email = $_POST['email'];
    $pass = $_POST['pass'];

    $sql = "SELECT * FROM utilisateurs WHERE email LIKE'$email'";
    $sqli = mysqli_query($con, $sql);
    $users = mysqli_fetch_assoc($sqli);

    if ($users['id'] != $id) {
        if (mysqli_num_rows($sqli) >= 1) {

            $error = "cette email deja exist";
        }
        $query = "UPDATE utilisateurs SET nom='$nom',prenom='$prenom',email='$email',pass='$pass',date_nais='$date_nais',adr='$adr' WHERE id= '$id'";
        $result = mysqli_query($con, $query) or die(mysqli_error($con));
        $saved = "Les modification sont enregistrer";
    } else {
        $query = "UPDATE utilisateurs SET nom='$nom',prenom='$prenom',email='$email',pass='$pass',date_nais='$date_nais',adr='$adr' WHERE id= '$id'";
        $result = mysqli_query($con, $query) or die(mysqli_error($con));
        $saved = "Les modification sont enregistrer";
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
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/style.css">

    <title>Mon Profil</title>

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


                    <li class="nav-item "><a class="nav-link " href="profil.php">Mon Profil</a></li>
                    <li class=""><button id="con-btn" class="bg-dark"><a class="nav-link active" href="logout.php"><span class="fas fa-sign-out-alt "></span> Se déconnecter </a></button></li>


                </ul>

            </div>

        </div>

    </nav>


    <div class=" vertical-center">
        <div class="container ">
            <div class="row d-flex justify-content-center">
                <form method="POST" class="form" action="" style="margin-bottom: 120px;">
                    <fieldset>

                        <legend class="text-center display-4">Modifier Les Info</legend>
                        <?= isset($error) ? "<p class= 'alert alert-danger'>$error</p>" : ""; ?>
                        <?= isset($saved) ? "<p class= 'alert alert-success'>$saved</p>" : ""; ?>
                        <div class="form-row">
                            <div class="form-group col-md-6">

                                <label for="nom">Nom</label>
                                <input type="text" name="nom" class="inpt" id="nom" placeholder="modifier Nom" required>

                            </div>

                            <div class="form-group col-md-6">
                                <label for="prenom">Prénom</label>
                                <input type="text" name="prenom" class="inpt" id="prenom" placeholder="modifier Prénom" required>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="date_nais">Date De Naissance</label>
                                <input type="date" name="date_nais" class="inpt" id="date_nais" required>

                            </div>

                            <div class="form-group col-md-6">
                                <label for="adr">Adresse</label>
                                <input type="text" name="adr" class="inpt" id="adr" placeholder="modifier Adresse" required>
                            </div>
                        </div>

                        <div class="form-group">

                            <label for="email">Email</label>
                            <input type="email" name="email" class="inpt" id="email" placeholder="modifier Email" required>

                        </div>
                        <div class="form-group">

                            <label for="pass">Mot de passe</label>
                            <input type="password" name="pass" class="inpt" id="pass" placeholder="modifier mot de passe" required>

                        </div>

                        <div class="text-center">
                            <button type="submit" name="submit" id="submit-btn" class="btn btn-primary w-50 p-2 text-center"> Modifier</button>
                        </div>

                    </fieldset>
                </form>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        var body = document.getElementsByTagName('body')[0];
        body.style.backgroundImage = 'url(../img/myImage.jpg)';
        body.style.backgroundRepeat = 'no-repeat';
        body.style.backgroundSize = 'cover';
    </script>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>


</body>

</html>