<!--
  déconnexion.php
  Permet la déconnexion d'un utilisateur
!-->
<?php
    //Initialisation du fichier externe
    require_once 'config/init.conf.php';

    //Reset des cookies de connexion
    setcookie('sid', '', -1);

    //Notificiation de déconnexion
    $_SESSION['notification']['result'] = 'danger';
    $_SESSION['notification']['message'] = 'Vous êtes déconnecté';

    //Renvoie sur la page d'accueil
    header("location: index.php");
    exit();
?>