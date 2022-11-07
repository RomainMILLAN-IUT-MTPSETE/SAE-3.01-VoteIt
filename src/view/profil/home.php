<?php
namespace App\VoteIt\View\Profil;
use App\VoteIt\Model\Repository\UtilisateurRepository;

$idUser = $_GET['idUtilisateur'];
$user = (new UtilisateurRepository())->select($idUser);

if ($user == NULL) {
    echo "L'utilisateur n'existe pas";
}

?>
<link rel="stylesheet" href="css/Profil/profil-home.css">

<a class="edit-button" href="frontController.php?controller=profil&action=modification" >Modifier profile : <img id="edit-img" src="assets/logo/modif.png"></a>
<section class="profil-home--container">
    <div id="info-user--container">
        <img id="icone-user" src="assets/logo/logoSansOmbre.png">
        <div class="identifiant-grade--container">
            <h1 class="souligner">Identifiant :</h1>
            <p class="info-user"><?php echo($user->getIdentifiant()) ?> </p>
            <h2 class="souligner">Grade :</h2>
            <p class="info-user"><?php echo($user->getGrade()) ?> </p>
        </div>
    </div>

    <h2 class="souligner">E-mail :</h2>
    <p class="info-user"><?php echo($user->getIconeLink()) ?></p>
    <h2 class="souligner">Nom :</h2>
    <p class="info-user"><?php echo($user->getNom()) ?></p>
    <h2 class="souligner">Prenom :</h2>
    <p class="info-user"><?php echo($user->getPrenom()) ?> </p>
    <h2 class="souligner">Date de naissance :</h2>
    <p class="info-user"><?php echo($user->getDateNaissance()) ?> </p>
</section>