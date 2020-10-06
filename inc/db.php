<?php
try{
$pdo = new PDO('mysql:dbname=dbs429211; host=db5000448760.hosting-data.io', 'dbu754211', 'Nicodu100194*');
}
catch(Exception $e){
    die('Erreur'.$e->getMessage());
}
$pdo-> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);//je veux accéder a la constante attr_errmode qui se situe dans pdo, renvoi l'erreur
$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);