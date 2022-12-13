<link rel="stylesheet" href="css/Profil/profil-home.css">

<div class="edit-div">
<a class="edit-button" href="frontController.php?controller=profil&action=modification" >Modifier profil : <img id="edit-img" src="assets/logo/modif.png"></a>
<a class="edit-button" href="frontController.php?controller=profil&action=deconnection" >Déconnection<img id="edit-img" src="assets/profil/logout.png"></a>
</div>
<section class="profil-home--container">
    <img id="icone-user" src="assets/logo/logoAvecOmbre.png">
    <div class="info-user-row">
        <div>
            <h2 class="souligner">Nom :</h2>
            <p class="info-user"><?php echo(htmlspecialchars($user->getNom())) ?></p>
        </div>
        <div>
            <h2 class="souligner">Prénom :</h2>
            <p class="info-user"><?php echo(htmlspecialchars($user->getPrenom())) ?> </p>
        </div>
    </div>
    <div class="info-user-row">
        <div>
            <h2 class="souligner">Date de naissance :</h2>
            <p class="info-user"><?php echo(htmlspecialchars($user->getDateNaissanceFR())) ?> </p>
        </div>
        <div>
            <h2 class="souligner">Grade :</h2>
            <p class="info-user"><?php echo($user->getGrade()) ?> </p>
        </div>
    </div>
    <h2 class="souligner">E-mail :</h2>
    <p class="info-user"><?php echo(htmlspecialchars($user->getMail())) ?></p>
</section>