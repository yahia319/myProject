<?php 


$host ='localhost';
$user ='root';
$pass ='';
$con = mysqli_connect($host, $user,$pass,'bd');

if(!$con){
    die('Could not Connect to My Sql');
}
?>