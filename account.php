<?php 
require 'inc/header.php';
logged_only();
if(!empty($_POST)){

    if(empty($_POST['password']) || $_POST['password'] != $_POST['password_confirm']){
        $_SESSION['flash']['error'] = "Les mots de passe ne correspondent pas";
    }else{
        $user_id = $_SESSION['auth']->id;
        $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
        require_once 'inc/db.php';
        $pdo -> prepare ('UPDATE users SET password = ? WHERE id= ?')->execute([$password, $user_id]);
        $_SESSION['flash']['success'] = "Votre mot de passe à été mis à jour";
    }   
}

?>

<h1>Bonjour <?= $_SESSION['auth']->username;?></h1>

<div class="container">
    <form action="" method="POST"> 
            
        <div class="form-group">
            <label for="">Votre nouveau mot de passe</label>
            <input type="password"name="password" class="form-control" />
        </div>

        <div class="form-group">
            <label for="">Confirmez nouveau mot de passe</label>
            <input type="password"name="password_confirm" class="form-control"  />
        </div>
        <button type="submit" class="btn btn-primary">Changer mon mot de passe</button>
    </form>
</div>
