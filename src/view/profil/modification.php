<link rel="stylesheet" href="css/Profil/profil-formulaire.css">
<link rel="stylesheet" href="css/formulaire.css">
<form class="formulaire--container" action="frontController.php?controller=profil&action=edit" method="POST">
    <div class="formulaire-template">
        <h2 class="title">Modification de mon profil</h2>

        <div>
            <label for="mail">E-Mail</label>
            <input type="text" name="mail" id="mail" placeholder="johndoe@gmail.com" value="<?php echo(htmlspecialchars($user->getMail())) ?>"/>
        </div>
        <div>
            <label for="password">Mot de passe acutel</label>
            <input type="password" name="password" id="password" placeholder="********"/>
        </div>
        <div>
            <label for="password">Nouveau Mot de passe (laisser vide si vous ne voulez pas le changer)</label>
            <input type="password" name="newpassword" id="newpassword" placeholder="********"/>
        </div>
        <div>
            <label for="password">Confirmation nouveau Mot de passe (laisser vide si vous ne voulez pas le changer)</label>
            <input type="password" name="confirmnewpassword" id="confirmnewpassword" placeholder="********"/>
        </div>
        <div>
            <label for="prenom">Prénom</label>
            <input type="text" name="prenom" id="prenom" placeholder="John" value="<?php echo(htmlspecialchars($user->getPrenom())) ?>"/>
        </div>
        <div>
            <label for="nom">Nom</label>
            <input type="text" name="nom" id="nom" placeholder="DOE" value="<?php echo(htmlspecialchars($user->getNom())) ?>"/>
        </div>
        <div>
            <label for="dtnaissance">Date de naissance</label>
            <input type="date" name="dtnaissance" id="dtnaissance" placeholder="01-01-2001" value="<?php echo(htmlspecialchars($user->getDateNaissance())) ?>"/>
        </div>
        <div>
            <input type="hidden" name="identifiant" id="identifiant" placeholder="JohnDoe10" value="<?php echo(htmlspecialchars($user->getIdentifiant())) ?>" readonly/>
            <input type="submit" value="Validé">
        </div>
    </div>
 </form>