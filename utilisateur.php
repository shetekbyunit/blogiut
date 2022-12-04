<!--
  utilisateur.php
  Permet l'inscription d'un utilisateur
!-->
<?php
    //Initialisation des fichiers externes
    require 'config/init.conf.php';
    require_once './vendor/autoload.php';

    //Initialisation du TWIG
    $loader = new \Twig\Loader\FilesystemLoader('templates/');
    $twig = new \Twig\Environment($loader, ['debug' => true]);

    //Initialisation du hearder et navbar
    include 'includes/header.inc.php';
    include 'includes/navbar.inc.php';

?>

<?php
    //Appel du fichier html utilisateur
    echo $twig->render('utilisateur.html.twig');

    //Vérification du contenu du formulaire
    if (!empty($_POST['login'])) {
      //Création d'un nouvel utilisateur, ajout des données du formulaire dans la variable utilisateur
      $utilisateur = new utilisateur();
      $utilisateur->hydrate($_POST);

      $utilisateur->setmdp(password_hash($utilisateur->getmdp(), PASSWORD_DEFAULT)); //Chiffrement du mot de passe par HASH

      //Insérertion de l'utilisateur en BDD
      $utilisateurManager = new utilisateurManager($bdd);
      $utilisateurManager->add($utilisateur);
      exit();
    }

?>

<?php
  //Initialisation du footer
  include 'includes/footer.inc.php';
?>