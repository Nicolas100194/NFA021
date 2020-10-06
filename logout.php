<?php 

session_start();
unset($_SESSION['auth']); //on retire l'utilisateur de la session 
$_SESSION['flash']['success'] = "vous etes deconnecté"; //on affiche la confirmation de deconnexion
header('Location: login.php'); //on redirige vers login.php