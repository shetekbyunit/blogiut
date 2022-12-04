<!--
  recherche.php
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
    //Vérification du contenu du formulaire
    if (!empty($_GET['search'])) {
        //Création d'un articlesmanager
        $articlesManager = new articlesManager($bdd);
        $listeArticles = $articlesManager->getListArticlesFromRecherche($_GET['search']); //Appel de la fonction de recherche
    } else //Si aucun élément de recherche rien afficher
    {
        $listeArticles = [];
    }

    //Appel du fichier html recherche avec les deux variales
    echo $twig->render(
        'recherche.html.twig',
        [
            'session' => $_SESSION,
            'listeArticles' => $listeArticles
        ]
    );
?>

<?php
    //Initialisation du footer
    include 'includes/footer.inc.php';
?>