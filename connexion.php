<!--
  connexion.php
  Permet la connexion d'un utilisateur
!-->
<?php
    //Initialisation des fichiers externes
    require 'config/init.conf.php';
    require_once './vendor/autoload.php';

    //Intialisation du TWIG
    $loader = new \Twig\Loader\FilesystemLoader('templates/');
    $twig = new \Twig\Environment($loader, ['debug' => true]);

    //Initialisation du hearder et navbar
    include 'includes/header.inc.php';
    include 'includes/navbar.inc.php';
?>

<?php
    //Appel du fichier html connexion
    echo $twig->render('connexion.html.twig');

    if (isset($_POST['connexion'])) {
        //Création de l'utilisateur, ajout des données du formulaire dans la variable utilisateurFormulaire
        $utilisateurFormulaire = new utilisateur();
        $utilisateurFormulaire->hydrate($_POST);

        //Recherche de l'utilisateur en BDD par rapport au email
        $utilisateurManager = new utilisateurManager($bdd);
        $utilisateurEnBdd = $utilisateurManager->getByEmail($utilisateurFormulaire->getEmail());

        //Vérification du mot de passe
        $isConnect = password_verify($utilisateurFormulaire->getMdp(), $utilisateurEnBdd->getMdp());

        //Vérification si l'utilisateur est connecté
        if ($isConnect == true) {
            $sid = md5($utilisateurEnBdd->getEmail() . time());
            //Création du cookie
            setcookie('sid', $sid, time() + 86400);
            //Mise en bdd du sid
            $utilisateurEnBdd->setSid($sid);
            $utilisateurManager->updateByEmail($utilisateurEnBdd);
        }
        //Notification de susccès de connexion
        if ($isConnect == true) {
            $_SESSION['notification']['result'] = 'success';
            $_SESSION['notification']['message'] = 'Vous êtes connecté !';
            header("Location: index.php");
            exit();
        } 
        else //Notification d'erreur de connexion
        {
            $_SESSION['notification']['result'] = 'danger';
            $_SESSION['notification']['message'] = 'Vérifiez votre login / mot de passe !';
            header("Location: connexion.php");
            exit();

        }
    }
?>

<?php
    //Initialisation du footer
    include 'includes/footer.inc.php';
?>