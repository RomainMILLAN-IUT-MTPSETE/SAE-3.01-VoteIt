<link rel="stylesheet" href="css/formulaire.css">

<form class="formulaire--container" action="frontController.php?controller=reponses&action=deleted&idQuestion=<?php echo(rawurlencode($_GET['idReponse'])); ?>" method="post">
    <div class="formulaire-template">
        <h2 class="title">Suppression de la réponse</h2>
        <div>
            <label for="idReponse">Titre de la Réponse</label>
            <input type="text" name="titleReponse" id="titleReponse" value="<?php echo(htmlspecialchars($reponse->getTitreReponse())); ?>" readonly required/>
        </div>
        <div>
            <label for="mdpUser">Votre mot de passe</label>
            <input type="password" name="mdpUser" id="mdpUser" placeholder="*****" required>
        </div>
        <div>
            <input type="number" name="idReponse" id="idReponse" value="<?php echo(htmlspecialchars($reponse->getIdReponse())); ?>" readonly hidden required/>
            <input type="submit" value="Supprimer la réponse">
        </div>
    </div>
</form>