<?php

//TRAITEMENT CONFIRMATION CREATION DE COMPTE------*/
//**-------------------------------------------- */

$user_id = $_GET['id']; //récupération de l'id passer en paramètre dans l'url
$token = $_GET['token']; //récupération du token passer en paramètre dans l'url
require 'inc/db.php'; //connexion a la bdd
$req = $pdo->prepare('SELECT * FROM users WHERE id = ?'); //selectionne toute les infos de l'user passer en parametre dans l'url
$req->execute([$user_id]); //execution de la requete en passabt en parametre l'user id contenu dans l'url
$user = $req->fetch(); //recupération de l'enregistrement
session_start();

if($user && $user->confirmation_token == $token){ //si l'utilisateur correspond et le token passer en parametre correspond a celui de la table...

    $req = $pdo->prepare('UPDATE users SET confirmation_token = NULL, confirmed_at = NOW() WHERE id = ?')->execute([$user_id]); //le compte est connecté et confirmer on l'execute pour l'utilisateur passer en parametre dans l'url
    $_SESSION['flash']['success'] = "votre compte a bien été validé";
    $_SESSION['auth'] = $user; //auth = authentification ou l'on stock l'utilisateur
    header('Location: account.php');
}else{
    $_SESSION['flash']['danger'] = "plus valide";
    header('Location: login.php'); //rediriger l'utilisateur une fois que le compte est validé
}

