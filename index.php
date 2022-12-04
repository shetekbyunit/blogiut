<!--
  index.php
  Page d'accueil
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
    //Création d'un nouveau article
    $articlesManager = new articlesManager($bdd);
    //Récupération de la liste des articles
    $listeArticles = $articlesManager->getList();
    
    //Ajout maximum de 2 articles sur la page
    $page = !empty($_GET['page']) ? $_GET['page'] : 1;
    $nbArticlesTotalAPublie = $articlesManager->countArticles();
    $nbPages = ceil($nbArticlesTotalAPublie / nb_articles_par_page);
    $indexDepart = ($page - 1) * nb_articles_par_page;
    $listeArticles = $articlesManager->getListArticlesAAfficher($indexDepart, nb_articles_par_page);

    //Appel du fichier html index
    echo $twig->render ('index.html.twig',
        ['session' => $_SESSION,
        'listeArticles' => $listeArticles,
        'nbPages' => $nbPages,
        'page' => $page
        ]);
    unset($_SESSION['notification']);
    ?>
<?php
//Vérification du contenu du formulaire
if (!empty($_POST['publier_com'])) {
    //Création d'un nouveau commentaire, ajout des données du formulaire dans la variable commentaire
    $commentaire = new commentaire();
    $commentaire->hydrate($_POST);

    //Insérer l'article en BDD
    $commentaireManager = new commentaireManager($bdd);
    $commentairelist = $commentaireManager->get_commentaire();
    exit();
}
?>

<?php
  //Initialisation du footer
  include 'includes/footer.inc.php';
?>