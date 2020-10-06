<?php

function str_random($length){ //générer chaine de caractere aléatoire
    $alphabet = "02345679azertyuiopqsdfghjklmwxcvbnAZERTYUIOPQSDFGHJKLMWXCVBN";
    return substr(str_shuffle(str_repeat($alphabet, $length)), 0, $length);
}

function logged_only(){ //vérifie si l'utilisateur est connecté sinon message erreur
    if(session_status() == PHP_SESSION_NONE){
        session_start();
    }
    if(!isset($_SESSION['auth'])){ 
        $_SESSION['flash']['danger'] = "vous n'avez pas le droit d'accéder à cette page";
        header('Location: index.php');
        exit();
    }
}

function block_page(){
    if(isset($_SESSION['auth'])){ 
        $_SESSION['flash']['danger'] = "vous n'avez pas le droit d'accéder à cette page";
        header('Location: index.php');
        exit();
    }
}

function isAjax(){
    return !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
}