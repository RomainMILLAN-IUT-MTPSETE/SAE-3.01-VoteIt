<form class="profil-connexion--container" action="#" method="post">
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
        <input type="text" name="password" id="password" placeholder="********"/>
    </div>
    <div id="checkbox-div">
        <input type="checkbox" name="conditionandcasuse" id="conditionandcasuse">
        <p>J'ai lu et j'accepte les conditions de cas d’utilisation.</p>
    </div>


    <input type="submit" value="S'inscrire">
    <p id="lastp">Déja enregistrer ? <a href="frontController.php?controller=profil&action=connection"><span class="colored">Se connecter</span></a></p>

</form>