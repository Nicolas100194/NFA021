<?php
session_start();
require 'inc/header.php' ; 
if(!empty($_POST) && !empty($_POST['username']) && !empty($_POST['password'])){ //est ce que des données ont été postées, si un username et un password ont été entré
    require_once 'inc/db.php'; //inclusion de la partie connexion a la bdd
    $req = $pdo->prepare('SELECT * FROM users WHERE (username = :username OR email = :username) AND confirmed_at IS NOT NULL'); //requete qui prends en parametre le username dans post 
    $req->execute(['username' => $_POST['username']]); //execution de la requete 
    $user = $req->fetch(); //on récupère l'utilisateur (la ligne dans la bdd)
    if(password_verify($_POST['password'], $user->password)){
        $_SESSION['auth'] = $user; //on connecte l'utilisateur
        $_SESSION['flash']['success'] = 'vous êtes bien connecté';
        header('Location: account.php');
        exit();
    }else{
        $_SESSION['flash']['danger'] = 'Identifiant ou mot de passe incorrecte';
    }
}
?>

  
<h1>Se connecter</h1>

<div class="container">
    <form action="" method="POST">
        
        <div class="form-group">
            <label for="">Pseudo ou email</label>
            <input type="text"name="username" class="form-control" />
        </div>

        <div class="form-group">
            <label for="">Mot de passe<a href="forget.php">Mot de passe oublié</a></label>
            <input type="password"name="password" class="form-control"  />
        </div>

        <button type="submit" class="btn btn-primary">me connecter</button>

    </form>
</div>


