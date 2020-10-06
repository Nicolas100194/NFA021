<?php require 'inc/header.php';?>
<div class="title--head">
    <h1 style="text-align:center">Projet NFA 021</h1>
    <h2 style="text-align:center">Site WEB permettant de gérer le stock d'une boutique de achat/vente de jeuxvideo<h2>
</div>
<?php if (!isset($_SESSION['auth'])): ?>
    <div class="content">
        <p>Afin de pouvoir accéder à l'espace de gestion vous devez vous connecter ou vous inscrire si cela n'est pas fait</p>
        <a href="login.php">Vous connecter</a>
        <a href="register.php">Vous inscrire</a>
    </div>
<?php else: ?> 
    <div class="section">
        <h2 style="text-align: center;">Consultation dans la base de données</h2>
        <div class="row">
            <div class="content">
                <?php
                $json = array();
                if(isAjax()){
                    echo json_encode($json);
                    die();
                }else
                    if (isset($rep)){
                    echo $result;
                    }
                ?>
                <p>Savoir si le jeu est en stock ou non</p>
                    <form action="" method="POST">
                        <div class="form-group">
                            <label for="">Indiquez le titre de votre jeuxvideo</label>
                            <input type="text"name="titre" class="form-control" required placeholder="ex : Resident Evil 3" />
                            <label for="">Indiquer le code barre (id)</label>
                            <input type="number"name="idJeuxVideo" class="form-control" required />
                        </div>
                        <button type="submit" class="btn btn-primary">Envoyer la requête</button>
                    </form>
            </div>
            <div class="content">
                <?php
                if(isAjax()){
                    echo json_encode($json);
                    die();
                }else 
                if(isset($rep2)){
                    echo $result;
                }
                ?>
                <p>Récupérer descriptif jeuvideo</p>
                <form action="" method="POST">
                    <div class="form-group">
                        <label for="">Indiquez le titre de votre jeuxvideo</label>
                        <input type="text"name="titre_description" class="form-control" required placeholder="ex : Resident Evil 3" />
                    </div>
                    <button type="submit" class="btn btn-primary">Envoyer la requête</button>
                </form>
            </div>
        </div>

        <div class="row">
            <div class="content">
                <?php
                if(isAjax()){
                    echo json_encode($json);
                    die();
                }else
                if(isset($rep3)){
                    foreach($result as $cle =>$valeur){
                        if (is_array($valeur)) {
                            echo '</br>';
                            foreach ($valeur as $key=>$value) {
                                echo $key.' : '.$value. '</br>';
                            }
                        }
                    }
                }
                ?>
                <p>Récupérer vente de la journée en fonction d'une date</p>
                    <form action="" method="POST">
                        <div class="form-group">
                            <label for="">Indiquez la date au format AAAA-MM-JJ</label>
                            <input type="text"name="date_vente" class="form-control" required placeholder="2020-05-15" />
                        </div>
                        <button type="submit" class="btn btn-primary">Envoyer la requête</button>
                    </form>
            </div>
            <div class="content">
                <?php
                if(isAjax()){
                    echo json_encode($json);
                    die();
                }else
                if(isset($rep4)){
                    foreach($result as $cle =>$valeur){
                        if (is_array($valeur)) {
                            echo '</br>';
                            foreach ($valeur as $key=>$value) {
                                echo $key.' : '.$value. '</br>';
                            }
                        }
                    }    
                }
                ?>
                <p>Requete permettant de retrouver les achats d'un acheteur en fonction de son nom et prénom</p>
                <form action="" method="POST">
                    <div class="form-group">
                        <label for="">Indiquez le nom de l'acheteur</label>
                        <input type="text"name="nom_acheteur" class="form-control" required placeholder="Dupont" />
                        <label for="">Indiquez le prénom de l'acheteur</label>
                        <input type="text"name="prenom_acheteur" class="form-control" required placeholder="Jean" />
                    </div>
                        <button type="submit" class="btn btn-primary">Envoyer la requête</button>
                </form>
            </div>
        </div>
    </div>
<?php if ($_SESSION['auth']->rang == 'Administrateur'): ?>
        <div class="section">
            <h2 style= "text-align: center;">Modifier des enregistrements dans la base de données</h2>
            <h3 style= "text-align: center;">Reservé aux modérateurs et administrateurs</h3>

                <div class="row">
                    <div class="content">
                        <p>Modifier les informations d'un client</p>
                            <form action="" method="POST">
                                <div class="form-group">
                                    <label for="">Indiquez le nom du client</label>
                                    <input type="text"name="nom_client" class="form-control" placeholder="Dupont" />
                                    <label for="">Indiquez le prénom du client</label>
                                    <input type="text"name="prenom_client" class="form-control" placeholder="Jean" />
                                    <label for="">modifier l'adresse</label>
                                    <input type="text"name="modif_adr" class="form-control" placeholder="12 rue lamartine" />
                                    <label for="">modifier le téléphone</label>
                                    <input type="text"name="modif_tel" class="form-control" placeholder="0326586235" />
                                    <label for="">modifier le code postal</label>
                                    <input type="text"name="modif_cp" class="form-control" placeholder="51000" />
                                    <label for="">modifier la ville</label>
                                    <input type="text"name="modif_ville" class="form-control" placeholder="Reims" />
                                    <button type="submit" class="btn btn-primary">Modifier</button>
                            </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="section">
            <h2 style= "text-align: center;">Ajouter des enregistrements dans le base de données</h2>
            <h3 style= "text-align: center;">Réservé aux administrateurs</h3>

                <div class="row">
                    <div class="content">
                        <p>Ajouter un vendeur</p>
                        <form action="" method="POST">
                            <div class="form-group">
                                <label for="">Indiquez le nom du vendeur</label>
                                <input type="text" name="nom_vendeur" class="form-control" placeholder="Dupont"/>
                                <label for="">Indiquez le prénom du vendeur</label>
                                <input type="text" name="prenom_vendeur" class="form-control" placeholder="Jean"/>
                                <button type="submit" class="btn btn-primary">Ajouter</button>
                            </div>
                        </form>
                </div>
                </div>
        </div>
<?php else: if($_SESSION['auth']->rang == 'Moderateur'): ?>
        <div class="section">
            <h2 style= "text-align: center;">Modifier des enregistrements dans la base de données</h2>
            <h3 style= "text-align: center;">Reservé aux modérateurs et administrateurs</h3>

                <div class="row">
                    <div class="content">
                        <p>Modifier les informations d'un client</p>
                            <form action="" method="POST">
                                <div class="form-group">
                                    <label for="">Indiquez le nom du client</label>
                                    <input type="text"name="nom_client" class="form-control" placeholder="Dupont" />
                                    <label for="">Indiquez le prénom du client</label>
                                    <input type="text"name="prenom_client" class="form-control" placeholder="Jean" />
                                    <label for="">modifier l'adresse</label>
                                    <input type="text"name="modif_adr" class="form-control" placeholder="12 rue lamartine" />
                                    <label for="">modifier le téléphone</label>
                                    <input type="text"name="modif_tel" class="form-control" placeholder="0326586235" />
                                    <label for="">modifier le code postal</label>
                                    <input type="text"name="modif_cp" class="form-control" placeholder="51000" />
                                    <label for="">modifier la ville</label>
                                    <input type="text"name="modif_ville" class="form-control" placeholder="Reims" />
                                    <button type="submit" class="btn btn-primary">Modifier</button>
                            </form>
                    </div>
                </div>
            </div>
        </div>
<?php else: ?>
    <h1 style="text-align: center">Pour accéder aux autres requêtes il est impératif d'avoir un accès modérateur ou administrateur</h1>
<?php endif; 
endif; 
endif; ?>
<?php require 'inc/footer.php';?>