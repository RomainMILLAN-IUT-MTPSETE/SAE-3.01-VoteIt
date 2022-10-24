<form class="profil-connexion--container" action="frontController?controller=profil&action=connected" method="post">
    <h2>Connection</h2>

    <div>
        <label for="identifiant">Identifiant</label>
        <input type="text" name="identifiant" id="identifiant" placeholder="JohnDoe10"/>
    </div>
    <div>
        <label for="password">Mot de passe</label>
        <input type="text" name="password" id="password" placeholder="********"/>
        <a href="#"><p id="passwordlosse">Mot de passe oublié ?</p></a>
    </div>
    <div id="checkbox-div">
        <input type="checkbox" name="remember" id="remember">
        <p>Se souvenir de moi ?</p>
    </div>


    <input type="submit" value="Se connecter">
    <p id="lastp">Pas encore enregistrer ? <a href="frontController.php?controller=profil&action=inscription"><span class="colored">S'enregistrer</span></a></p>

</form>