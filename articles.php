<!--
  articles.php
  Permet la création d'un article
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
    //Appel du fichier html articles
    echo $twig->render('articles.html.twig');
    //Vérification du contenu du formulaire
    if (!empty($_POST['ajouter'])) {
    //Création d'un nouvel article, ajout des données du formulaire dans la variable article, puis ajoute la date
    $articles = new articles();
    $articles->hydrate($_POST);
    $articles->setDate(date('Y-m-d'));

    //Insérer l'article en BDD
    $articlesManager = new articlesManager($bdd);

    //Vérifie si l'article à été upload en bdd
    if ($articlesManager->get_result() == true) { 
        if($_FILES['image']['error'] == 0){
            //Renomme l'image, en l'id du commentaire
            $nomimage = $articlesManager->get_getLastInsertId();
            move_uploaded_file($_FILES['image']['tmp_name'], __DIR__ . "/img/" . $nomimage.".jpg");
        }
    }


    //Notification Succès / Erreur
    $messageNotification = $articlesManager->get_result() == true ? "Votre article à été ajouté" : "Votre article n'a pas pu être ajouté";
    $resultNotification = $articlesManager->get_result() == true ? "success" : "danger";
    $_SESSION['notification']['result'] = $resultNotification;
    $_SESSION['notification']['message'] = $messageNotification;
    //Renvoie sur la page principal
    header("Location: index.php");
    exit();
}
?>

<?php
  //Initialisation du footer
  include 'includes/footer.inc.php';
?>