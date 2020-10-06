<?php require 'inc/db.php';
require_once 'inc/functions.php';
//REQUETE JEU EN STOCK
if(!empty($_POST) &&!empty($_POST['titre']) && !empty($_POST['idJeuxVideo'])){
    $result = $pdo->query('SELECT titre FROM jeuxvideos');
    while($donnees = $result->fetch()){
        $existe = false;
        if($_POST['titre'] == $donnees->titre){
            $existe = true;
            break;
        }
        
    }
    if($existe == false){
        echo "<p>le jeu n'existe pas</p>";
    }


    $req = $pdo->prepare('SELECT jeuxvideos.Titre, jeuxvideos.PrixDeVente, genre.NomGenre, plateformes.NomPlateforme, jeuxvideos.idJeuxVideo FROM ligne_vente, jeuxvideos, genre, plateformes
                        WHERE jeuxvideos.idPlateforme = plateformes.idPlateforme
                        AND jeuxvideos.idGenre = genre.idGenre
                        AND jeuxvideos.idJeuxVideo = ligne_vente.idJeuxVideo
                        AND jeuxvideos.Titre = ?
                        AND jeuxvideos.idJeuxVideo = ?');
    $req->execute(array($_POST['titre'], $_POST['idJeuxVideo']));

    $rep = $req->fetch();
    {
        if($rep == NULL && $existe == true){
            if(isAjax()){
            echo '<p>Le jeu est en stock</p>';
            }else
            $result = '<p>Le jeu est en stock';
        }else if ($rep == NULL && $existe == false){
            if(isAjax()){
                echo '';
                }else
                $result = '';
        }
        else if ($rep->Titre == $_POST['titre']){
            if(isAjax()){
                echo '<p>Le jeu est vendu</p>';
                }else
                $result = '<p>Le jeu est en stock';
        }
    }

}


//REQUETE DESCRIPTIF JEUVIDEO
if(!empty($_POST) &&!empty($_POST['titre_description'])){
    $req2 = $pdo->prepare('SELECT jeuxvideos.Titre, jeuxvideos.PrixDeVente, genre.NomGenre, plateformes.NomPlateforme
                        FROM jeuxvideos, genre, plateformes
                            WHERE jeuxvideos.idPlateforme = plateformes.idPlateforme
                            AND jeuxvideos.idGenre = genre.idGenre
                            AND jeuxvideos.Titre = ?');
    $req2->execute(array($_POST['titre_description']));
    $rep2 = $req2->fetch();
if($rep2 == NULL){
    if(isAjax()){
        echo '<p>jeu inconnu</p>';
    }else
    $result = '<p>jeu inconnu</p>';
}else{
    if(isAjax()){
        echo 'Titre : '. $rep2->Titre . '</br>Prix de vente : ' . $rep2->PrixDeVente . '€</br>Genre : '. $rep2->NomGenre . '</br> Plateforme : '. $rep2->NomPlateforme . '</br>';
    }
    $result = 'Titre : '. $rep2->Titre . '</br>Prix de vente : ' . $rep2->PrixDeVente . '€</br>Genre : '. $rep2->NomGenre . '</br> Plateforme : '. $rep2->NomPlateforme . '</br>';
}
}


//REQUETE VENTE DE LA JOURNEE
if(!empty($_POST) &&!empty($_POST['date_vente'])){
    $result = $pdo->query('SELECT dateVente FROM vente');
    $dateexiste = false;
    while($donnees = $result->fetch()){
        if($_POST['date_vente'] == $donnees->dateVente){
            $dateexiste = true;
            break;
        }
        
    }
    if($dateexiste == false){
        if(isAjax()){
            echo '<p>date non trouvée</p>';
        }
        $result = '<p>date non trouvée</p>';
    }
}


if(!empty($_POST) &&!empty($_POST['date_vente'])){
    $req3 = $pdo->prepare('SELECT vente.montant, vendeurs.NomVendeur, vendeurs.PrenomVendeur, clients.NomClient, clients.PrenomClient, vente.dateVente, ligne_vente.idLigne_vente, jeuxvideos.Titre, vente.idVente
                            FROM vente, clients, vendeurs, ligne_vente, jeuxvideos
                            WHERE vente.idVendeurs = vendeurs.idVendeurs
                            AND jeuxvideos.idJeuxVideo = ligne_vente.idJeuxVideo
                            AND vente.idClient = clients.idClient
                            AND ligne_vente.idVente = vente.idVente
                            AND vente.dateVente = ?');
    $result= [];                   
    $req3->execute(array($_POST['date_vente']));
        while($rep3 = $req3->fetch()){
            if(isAjax()){
                echo 'Montant : ' .$rep3->montant . '</br>Nom vendeur : '.$rep3->NomVendeur. '</br>Prenom vendeur : '.$rep3->PrenomVendeur. '</br>Nom client : '.$rep3->NomClient. '</br>Prenom Client'.$rep3->PrenomClient.'</br>Date de vente :'.$rep3->dateVente;
                echo '</br>id ligne vente :'.$rep3->idLigne_vente.'</br>Titre jeux : '.$rep3->Titre.'</br>Id vente : '.$rep3->idVente.'</br>';
            }else
                $result[] = get_object_vars($rep3);
            }
    }

//achats d'un acheteur
  if(!empty($_POST) &&!empty($_POST['nom_acheteur']) &&!empty($_POST['prenom_acheteur'])){
                        $result = $pdo->query('SELECT NomAcheteur, PrenomAcheteur FROM acheteurs');
                        $acheteurexiste = false;
                        while($donnees = $result->fetch()){
                            if($_POST['nom_acheteur'] == $donnees->NomAcheteur && $_POST['prenom_acheteur'] == $donnees->PrenomAcheteur){
                                $acheteurexiste = true;
                                break;
                            }
                            
                        }
                        if($acheteurexiste == false){
                            if(isAjax()){
                                echo 'acheteur non trouvé';
                            }
                            $result = 'acheteur non trouvé';
                        }
                    }


                    if(!empty($_POST) &&!empty($_POST['nom_acheteur']) &&!empty($_POST['prenom_acheteur'])){
                        $req4 = $pdo->prepare('SELECT achat.montant, acheteurs.NomAcheteur, acheteurs.PrenomAcheteur, clients.NomClient, clients.PrenomClient, achat.dateAchat, ligne_achat.idLigne_achat, jeuxvideos.Titre, achat.idAchat
                        FROM achat, clients, acheteurs, ligne_achat, jeuxvideos
                        WHERE achat.idAcheteurs = acheteurs.idAcheteurs
                        and jeuxvideos.idJeuxVideo = ligne_achat.idJeuxVideo
                        and achat.idClient = clients.idClient
                        and ligne_achat.idAchat = achat.idAchat
                        and acheteurs.NomAcheteur = ?
                        and acheteurs.PrenomAcheteur = ?');
                    $result = [];
                    $req4->execute(array($_POST['nom_acheteur'], $_POST['prenom_acheteur']));
                    while($rep4 = $req4->fetch()){
                        if(isAjax()){
                            echo 'Montant : ' .$rep4->montant . '</br>Nom acheteur : '.$rep4->NomAcheteur. '</br>Prenom acheteur : '.$rep4->PrenomAcheteur. '</br>Nom client : '.$rep4->NomClient. '</br>Prenom Client'.$rep4->PrenomClient.'</br>Date d\'achat :'.$rep4->dateAchat;
                            echo '</br>id ligne achat :'.$rep4->idLigne_achat.'</br>Titre jeux : '.$rep4->Titre.'</br>Id achat : '.$rep4->idAchat.'</br>';
                        }
                        $result[] = get_object_vars($rep4);
                    }
            }

//modifier informations d'un client

if(!empty($_POST) &&!empty($_POST['nom_client']) &&!empty($_POST['prenom_client']) &&!empty($_POST['modif_adr']) &&!empty($_POST['modif_tel']) &&!empty($_POST['modif_cp']) &&!empty($_POST['modif_ville'])){
    $req5 = $pdo->prepare('UPDATE clients SET Adresse = :modif_adr, Tel = :modif_tel, CodePostal = :modif_cp, Ville = :modif_ville 
                           WHERE NomClient = :nom_client
                            AND PrenomClient = :prenom_client');
    $req5->execute(array(':modif_adr' => $_POST['modif_adr'], 
                         ':modif_tel' => $_POST['modif_tel'], 
                         ':modif_cp' => $_POST['modif_cp'],
                         ':modif_ville' => $_POST['modif_ville'], 
                         ':nom_client' => $_POST['nom_client'], 
                         ':prenom_client' =>$_POST['prenom_client']));
    var_dump($_POST);
    echo 'modifications effectuées !';

}

//ajouter vendeur dans la bdd

if(!empty($_POST) &&!empty($_POST['nom_vendeur']) &&!empty($_POST['prenom_vendeur'])){
    $req6 = $pdo->prepare('INSERT INTO vendeurs (NomVendeur, PrenomVendeur) VALUES (?, ?)');
    $req6->execute(array($_POST['nom_vendeur'], $_POST['prenom_vendeur']));
}