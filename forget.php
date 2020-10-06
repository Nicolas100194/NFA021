<?php
if(!empty($_POST) && !empty($_POST['email'])){ //si des données ont été posté et que l'email n'est pas vide
    require_once 'inc/db.php'; //inclusion de la partie connexion a la bdd
    $req = $pdo->prepare('SELECT * FROM users WHERE email = ? AND confirmed_at IS NOT NULL'); //requete qui prends en parametre l'email entré en post
    $req->execute([$_POST['email']]); //execution de la requete 
    $user = $req->fetch(); //on récupère l'enregistrement'
    if($user){
        session_start();
        $reset_token = str_random(60);
        $pdo->prepare('UPDATE users SET reset_token = ?, reset_at = NOW() WHERE id = ?')->execute([$reset_token, $user->id]);
        $_SESSION['flash']['success'] = 'Un email vous a été envoyé';
        mail($_POST['email'], 'Réinitialisation de votre mot de passe', "Afin de valider votre mot de passe cliquez sur ce lien\n\nhttp://nicolasdelacroix.fr/cnam/reset.php?id={$user->id}&token=$reset_token"); 
        header('Location: login.php');
        exit();
    }else{
        $_SESSION['flash']['danger'] = 'Aucun compte ne correspond a cette adresse';
    }
}
?>
<?php require 'inc/header.php' ; ?>

<h1>Mot de passe oublié</h1>

<div class="container">
    <form action="" method="POST">
        
        <div class="form-group">
            <label for="">Votre email</label>
            <input type="email"name="email" class="form-control" />
        </div>

        <button type="submit" class="btn btn-primary">Envoyer le mot de passe</button>

    </form>
</div>

