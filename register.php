<?php
require 'inc/header.php';

//VERIFICATION DES CHAMPS DU FORMULAIRE----------------------
//-----------------------------------------------------------

if(!empty($_POST)){ //si la variable POST nest pas vide alors des données ont été posté il faut les vérifier....
    $errors = array(); //on stock les erreurs de remplissage dans un tableau nommé $errors
    require_once 'inc/db.php';
    //verifier que le pseudo ne soit pas vide
    if(empty($_POST['username']) || !preg_match('/^[a-zA-Z0-9_]+$/', $_POST['username'])){ //si c'est vide ou si il y a des caractere interdits alors...
        $errors['username'] = "Pseudo pas valide"; //on rempli le tableau erreur d'index "username"
    } else {
        $req = $pdo->prepare('SELECT id FROM users WHERE username = ?'); //requete verifiant si le pseudo n'est pas deja utilisé dans la bdd
        $req->execute([$_POST['username']]); //execution de la requete avec le champ "username" rempli par l'utilisateur
        $user = $req->fetch(); //récupère tout les "user" champ par champ
        if($user){
            $errors['username'] = 'Ce pseudo est déjà pris'; //comparaison du champ rempli et de chaque champ email de la bdd
        }
    }
    if(empty($_POST['email']) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){ //si c'est vide ou si c'est pas format email alors...
        $errors['email'] = "votre email n'est pas valide"; //on rempli le tableau erreur d'index "email"
    } else {
        $req = $pdo->prepare('SELECT id FROM users WHERE email = ?'); //requete verifiant si l'email n'est pas déjà présente dans la bdd
        $req->execute([$_POST['email']]); //execution de la requete avec le champ "email" rempli par l'utilisateur
        $user = $req->fetch(); //récupère tout les "email" champ par champ
        if($user){
            $errors['email'] = 'Email déjà utilisé'; //comparaison du champ rempli et de chaque champ email de la bdd
        }
    }
    if(empty($_POST['password']) || $_POST['password'] != $_POST['password_confirm']){ //vérifie si le mot de passe est le meme que le champ mot de passe confirm et pas vide
        $errors['password'] = "mots de passe incorrect";  //on rempli le tableau
    }
    if(empty($_POST['rang'])){
        $errors['rang'] = 'vous devez choisir un grade';
    }

//AJOUT DU COMPTE DANS LA BASE DE DONNEES--------------------
//-----------------------------------------------------------


    if(empty($errors)){ //execute la requete seulement si la variable errors est vide
        $req =  $pdo->prepare("INSERT INTO users SET username = ?, password = ?, email = ?, confirmation_token = ?, rang = ?"); //requete pour ajouter l'utilisateur /////////////A MODIFIER
        $password = password_hash($_POST['password'], PASSWORD_BCRYPT); //crypte le mot de passe entré par l'utilisateur
        $token = str_random(60); //appel de la fonction pour générer un cryptage du mdp
        $req ->execute([$_POST['username'], $password, $_POST['email'], $token, $_POST['rang']]); //on execute la requete "req"  ///////////////////////////////////////////////////A MODIFIER
        $user_id = $pdo->lastInsertId(); //renvoi le dernier id générer par pdo
        mail($_POST['email'], 'Confirmation de votre compte', "Afin de valider votre compte merci de cliquer sur ce lien\n\nhttp://nicolasdelacroix.fr/cnam/confirm.php?id=$user_id&token=$token"); 
        //création de l'email avec le lien contenant l'id utilisateur et le mdp crpyté
        $_SESSION['flash']['success'] = "un email de confirmation vous a été envoyé pour valider votre compte"; //indiquer a l'utilisateur que l'email a été envoyé
        header('Location: login.php');
        exit();
    }
} 

?>





<h1>S'inscrire</h1>

<?php if(!empty($errors)): ?>

<div class="alert alert-danger">
    <p>vous n'avez pas rempli le formulaire correctement</p>
    <ul>
        <?php foreach ($errors as $error):?>
            <li><?= $error; ?></li>
        <?php endforeach; ?>
    </ul>
</div>
<?php endif; ?>
<div class="container">
<!--FORMULAIRE INSCRIPTION-->
    <form action="" method="POST"> <!--action vide car renvoi page courante-->
        
        <div class="form-group">
            <label for="">Pseudo</label>
            <input type="text"name="username" class="form-control" /><!--USERNAME VARIABLE PHP-->
        </div>

        <div class="form-group">
            <label for="">Email</label>
            <input type="text"name="email" class="form-control"  /><!--EMAIL VARIABLE PHP-->
        </div>

        <div class="form-group">
            <label for="">Mot de passe</label>
            <input type="password"name="password" class="form-control"  /><!--PASSWORD VARIABLE PHP-->
        </div>

        <div class="form-group">
            <label for="">confirmez votre mot de passe</label>
            <input type="password"name="password_confirm" class="form-control"  /><!--PASSWORD_confirm variable php-->
        </div>

        <div class="form-group">
            <label for="">Votre grade</label>
            <input list="ranks" id="ranks_choice" name="rang"/>
            <datalist id="ranks">
                <option value="Utilisateur">
                <option value="Moderateur">
                <option value="Administrateur">
            </datalist>
        <p>Double cliquez pour accéder aux grades</p>
        <button type="submit" class="btn btn-primary">m'inscrire</button>

    </form>
</div>
