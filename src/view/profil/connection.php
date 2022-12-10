<link rel="stylesheet" href="css/formulaire.css">
<link rel="stylesheet" href="css/Profil/profil-formulaire.css">
<form class="formulaire--container" action="frontController.php?controller=profil&action=connected" method="post">
    <div class="formulaire-template">
        <h2 class="title">Connexion</h2>

        <div>
            <label for="mail">E-Mail</label>
            <input type="email" name="mail" id="mail" placeholder="johndoe10@gmail.com" required/>
        </div>
        <div>
            <label for="password">Mot de passe</label>
            <input type="password" name="password" id="password" placeholder="********" required/>
            <a href="#"><p id="passwordlosse">Mot de passe oublié ?</p></a>
        </div>
        <div id="checkbox-div">
            <input type="checkbox" name="remember" id="remember">
            <a href="frontController.php?controller=profil&action=mdpoublie"><p>Se souvenir de moi ?</p></a>
        </div>


        <div>
            <input type="submit" value="Se connecter">
            <p id="lastp">Pas encore enregistré ? <a href="frontController.php?controller=profil&action=inscription"><span class="colored">S'enregistrer</span></a></p>
        </div>
    </div>
</form>