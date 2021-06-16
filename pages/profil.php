<?php
include '../includes/bd.php';
session_start();
$id = $_SESSION['id'];
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


                    <li class="nav-item "><a class="nav-link active" href="profil.php">Mon Profil</a></li>
                    <li class=""><button id="con-btn" class="bg-dark"><a class="nav-link active" href="logout.php"><span class="fas fa-sign-out-alt "></span> Se déconnecter </a></button></li>


                </ul>

            </div>

        </div>

    </nav>

    <?php
    $sql = "SELECT * FROM utilisateurs WHERE id ='$id' ";
    $sqli = mysqli_query($con, $sql);
    $user = mysqli_fetch_assoc($sqli);

    $query = "SELECT * FROM `production_sientifique` WHERE `num_chercheur` ='$id' ";
    $result = mysqli_query($con, $query);
    ?>

    <div id="tab" class="container ">
        <p class="display-4 text-center cap" style="color: white; margin-top: 20px;">Mes Information</p>
        <table class="table table-striped table-hover" style="margin-top: 50px; color: white;">

            <tbody>
                <tr>
                    <th>Nom : </th>
                    <td class="text-center"><?= $user['nom'] ?></td>

                </tr>
                <tr>
                    <th>Prenom : </th>
                    <td class="text-center"><?= $user['prenom'] ?></td>

                </tr>
                <tr>
                    <th>Email : </th>
                    <td class="text-center"><?= $user['email'] ?></td>

                </tr>
                <tr>
                    <th>Date de naissance : </th>
                    <td class="text-center"><?= $user['date_nais'] ?></td>

                </tr>
                <tr>
                    <th>Adresse : </th>
                    <td class="text-center"><?= $user['adr'] ?></td>

                </tr>
            </tbody>

        </table>
        <div class="text-center">
            <a class="modifier" href="update.php"><button id="submit-btn" class="btn btn-success w-50 p-2 text-center">Modifier les info</button></a>
        </div>


        <?php if ($result->num_rows > 0) : ?>
            <p class="display-4 text-center cap" style="margin-top: 50px; color: white;">Mes Production Sientifique</p>

            <table class="table table-striped table-hover text-center" style="margin-top: 50px; color: white;">

                <tbody>

                    <tr>
                        <th>Nom PS </th>
                        <th>Catégorie </th>
                        <th>Description </th>

                    </tr>

                    <?php while ($row = mysqli_fetch_assoc($result)) : ?>


                        <tr>
                            <td><?= $row["nom_ps"] ?></td>
                            <td><?= $row["categorie_ps"] ?></td>
                            <td><?= $row["description"] ?></td>

                        </tr>

                    <?php endwhile; ?>

                </tbody>

            </table>

        <?php endif; ?>
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