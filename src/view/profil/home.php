<link rel="stylesheet" href="css/Profil/profil-home.css">

<a class="edit-button" href="frontController.php?controller=profil&action=modification&idUtilisateur=<?php echo(rawurlencode($user->getIdentifiant())); ?>" >Modifier profil : <img id="edit-img" src="assets/logo/modif.png"></a>
<section class="profil-home--container">
    <div id="info-user--container">
        <img id="icone-user" src="assets/logo/logoSansOmbre.png">
        <div class="identifiant-grade--container">
            <h1 class="souligner">Identifiant :</h1>
            <p class="info-user"><?php echo(htmlspecialchars($user->getIdentifiant())) ?> </p>
            <h2 class="souligner">Grade :</h2>
            <p class="info-user"><?php echo($user->getGrade()) ?> </p>
        </div>
    </div>
    <h2 class="souligner">E-mail :</h2>
    <p class="info-user"><?php echo(htmlspecialchars($user->getMail())) ?></p>
    <h2 class="souligner">Nom :</h2>
    <p class="info-user"><?php echo(htmlspecialchars($user->getNom())) ?></p>
    <h2 class="souligner">Prenom :</h2>
    <p class="info-user"><?php echo(htmlspecialchars($user->getPrenom())) ?> </p>
    <h2 class="souligner">Date de naissance :</h2>
    <p class="info-user"><?php echo(htmlspecialchars($user->getDateNaissance())) ?> </p>
</section>