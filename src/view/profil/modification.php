<link rel="stylesheet" href="css/Profil/profil-connexion.css">
<form class="profil-connexion--container" action="frontController.php?controller=profil&action=modification" method="get">
    <h2>Mon Profil</h2>

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



    <input type="submit" value="Validé">
 

</form>