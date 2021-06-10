<?php
include 'bd.php';

$nom = "";
$prenom = "";
$date_nais = "";
$adr = "";
$email = "";
$pass = "";


if (isset($_GET['submit'])) {

    $nom = $_GET['nom'];
    $prenom = $_GET['prenom'];
    $date_nais = $_GET['date_nais'];
    $adr = $_GET['adr'];
    $email = $_GET['email'];
    $pass = password_hash($_GET['pass'],PASSWORD_DEFAULT);

    $sql= "SELECT * FROM utilisateurs WHERE email LIKE'$email'";
    $sqli= mysqli_query($con, $sql);
    if(mysqli_num_rows($sqli)>=1)
      {
        echo "<script type='text/javascript'>confirm('deja exist go to login');</script>";
       
      }
    else
       {
        $query = " INSERT INTO utilisateurs(nom,prenom,email,pass,date_nais,adr,role) VALUES ('$nom','$prenom','$email','$pass','$date_nais','$adr','1')";
        if (!empty($nom)) {
            mysqli_query($con, $query) or die("faild");
        } else {
            echo 'no';
        }
        header('location: index.php');
       }
      
}
?>