<link rel="stylesheet" href="css/Profil/profil-connexion.css">
<form class="profil-connexion--container" action="frontController.php?controller=profil&action=register" method="post">
    <h2>Inscription</h2>

    <div>
        <label for="identifiant">Identifiant</label>
        <input type="text" name="identifiant" id="identifiant" placeholder="JohnDoe10"/>
    </div>
    <div>
        <label for="mail">E-Mail</label>
        <input type="text" name="mail" id="mail" placeholder="johndoe@gmail.com"/>
    </div>
    <div>
        <label for="password">Mot de passe</label>
        <input type="password" name="password" id="password" placeholder="********"/>
    </div>
    <div>
        <label for="prenom">Prénom</label>
        <input type="text" name="prenom" id="prenom" placeholder="John"/>
    </div>
    <div>
        <label for="nom">Nom</label>
        <input type="text" name="nom" id="nom" placeholder="DOE"/>
    </div>
    <div>
        <label for="dtnaissance">Date de Naissance</label>
        <input type="date" name="dtnaissance" id="dtnaissance" placeholder="01-01-2001"/>
    </div>
    <div id="checkbox-div">
        <input type="checkbox" name="conditionandcasuse" id="conditionandcasuse">
        <p>J'ai lu et j'accepte les conditions de cas d’utilisation.</p>
    </div>


    <input type="submit" value="S'inscrire">
    <p id="lastp">Déja enregistrer ? <a href="frontController.php?controller=profil&action=connection"><span class="colored">Se connecter</span></a></p>

</form>