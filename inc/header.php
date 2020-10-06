<?php 
session_start();
require 'inc/functions.php';
?>

<!doctype html>
<html lang="fr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Jekyll v3.8.6">
    <title>Projet CNAM NFA 021</title>

    <link rel="canonical" href="https://getbootstrap.com/docs/4.4/examples/starter-template/">

    <!-- Bootstrap core CSS -->
<link href="/cnam/css/app.css" rel="stylesheet">

    <!-- Favicons -->
<link rel="apple-touch-icon" href="/docs/4.4/assets/img/favicons/apple-touch-icon.png" sizes="180x180">
<link rel="icon" href="/docs/4.4/assets/img/favicons/favicon-32x32.png" sizes="32x32" type="image/png">
<link rel="icon" href="/docs/4.4/assets/img/favicons/favicon-16x16.png" sizes="16x16" type="image/png">
<link rel="manifest" href="/docs/4.4/assets/img/favicons/manifest.json">
<link rel="mask-icon" href="/docs/4.4/assets/img/favicons/safari-pinned-tab.svg" color="#563d7c">
<link rel="icon" href="/docs/4.4/assets/img/favicons/favicon.ico">
<meta name="msapplication-config" content="/docs/4.4/assets/img/favicons/browserconfig.xml">
<meta name="theme-color" content="#563d7c">

  </head>
  <body>
    <nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top">
  <a class="navbar-brand" href="index.php">Projet CNAM NFA 021</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarsExampleDefault">
    <ul class="navbar-nav mr-auto">
      <?php if (isset($_SESSION['auth'])): ?> <!--si lutilisateur est connecté on fait apparaitre se déconnecter -->
        <li class="nav-item">
          <a class="nav-link" href="logout.php">Se déconnecter</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="account.php">Mon compte</a>
        </li>
      <?php else : ?>
      <li class="nav-item">
        <a class="nav-link" href="register.php">s'inscrire</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="login.php">se connecter</a>
      </li>
      <?php endif; ?>
</nav>


  <?php if(isset($_SESSION['flash'])): ?> <!-- est-ce qu'il y a quelque chose dans la cle flash-->
    <?php foreach($_SESSION['flash'] as $type => $message): ?> <!-- parcourir flash $type correspond a danger, succes... et en valeur le message-->
      <div class="alert alert-<?= $type ?>">
        <?= $message; ?> 
      </div>
    <?php endforeach; ?>
    <?php unset($_SESSION['flash']); ?> <!--supprime les message d'erreur, supprime lindex-->
  <?php endif; ?>
  
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
