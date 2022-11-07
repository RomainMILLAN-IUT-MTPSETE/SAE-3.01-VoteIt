<link rel="stylesheet" href="css/Profil/profil-connexion.css">
<form class="profil-connexion--container" action="frontController.php?controller=profil&action=edit" method="POST">
    <h2>Mon Profil</h2>

    <div>
        <label for="identifiant">Identifiant</label>
        <input type="text" name="identifiant" id="identifiant" placeholder="JohnDoe10" value="<?php echo($user->getIdentifiant()) ?>" readonly/>
    </div>
    <div>
        <label for="mail">E-Mail</label>
        <input type="text" name="mail" id="mail" placeholder="johndoe@gmail.com" value="<?php echo($user->getMail()) ?>"/>
    </div>
    <div>
        <label for="password">Mot de passe</label>
        <input type="password" name="password" id="password" placeholder="********" value="<?php echo($user->getMotDePasse()) ?>"/>
    </div>
    <div>
        <label for="prenom">Prénom</label>
        <input type="text" name="prenom" id="prenom" placeholder="John" value="<?php echo($user->getPrenom()) ?>"/>
    </div>
    <div>
        <label for="nom">Nom</label>
        <input type="text" name="nom" id="nom" placeholder="DOE" value="<?php echo($user->getNom()) ?>"/>
    </div>
    <div>
        <label for="dtnaissance">Date de Naissance</label>
        <input type="date" name="dtnaissance" id="dtnaissance" placeholder="01-01-2001" value="<?php echo($user->getDateNaissance()) ?>"/>
    </div>
    <input type="submit" value="Validé">
 </form>