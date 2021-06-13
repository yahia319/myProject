<?php
include '../includes/bd.php';

session_start();

if(isset($_SESSION['email']) && $_SESSION['email']){
    header('Location:index.php');
    exit();
}

if (isset($_POST['submit'])) {
    
    $email = $_POST['email'];
    $pass = $_POST['pass'];

    $sql= "SELECT * FROM utilisateurs WHERE email LIKE '$email' AND pass LIKE '$pass'";
    $sqli= mysqli_query($con, $sql);
    if(mysqli_num_rows($sqli)>=1)
      {
        $user = mysqli_fetch_assoc($sqli);
        $role =  $user["role"];
        $_SESSION['email'] = $email;
        $_SESSION['role'] = $role;
        header('Location:index.php?r=' . $role);
       
      }
    else {
        $error = "vérifie email et mot de passe";
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

    <title>Connexion</title>
</head>


<body style="background-image: url('../img/image.jpg'); background-repeat: no-repeat; background-size: cover; color: white;backdrop-filter: blur(10px);">


    <nav class="navbar navbar-dark bg-dark navbar-expand-md fixed-top">
        <div class="container-fluid">


            <p><a class="navbar-brand " href="index.php">Smart Campus UC2</a></p>

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

            </div>

        </div>

    </nav>


    <div class=" vertical-center">
        <div class="container ">
            <div class="form-row d-flex justify-content-center">
                <div class="col-6">
                
                    <form id="con" class="needs-validation" action="connexion.php" method="POST">

                        <fieldset>

                            <legend id="c" class="text-center display-4">Connexion</legend>

                            <?= isset($error) ? "<p style='color:red'>$error</p>" : ""; ?>
           

                            <div id="mail" class="form-group">
                                <label for="email">Email</label>
                                <input type="email" name="email" id="email" class="inpt" id="email" placeholder="Email" required>

                            </div>


                            <div id="pas" class="form-group">
                                <label for="pass">Mot de passe</label>
                                <input type="password" name="pass" class="inpt" id="pass" placeholder="Mot de passe" required>
                            </div>

                            <div class="text-center">
                                <button type="submit" name="submit" id="submit-btn" class="btn btn-primary w-50 p-2 text-center">Se connecter</button>
                                <p class="p">vous n'avez pas un compte?<a id="lien" href="inscrire.php"> S'inscrire</a></p>
                            </div>


                        </fieldset>

                    </form>
                </div>
            </div>
        </div>
    </div>
    </div>

    <footer>

        <div class="container">

            <hr><br>
            <p class="text-center">Copyright © Smart Campus UC2. Tous les droits sont réservés.</p><br>

        </div>

    </footer>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>


</body>

</html>

